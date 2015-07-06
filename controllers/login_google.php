<?php

class login_google extends Controller
{
    public $requires_auth = false;
    public $client_id = GOOGLE_CLIENT_ID;
    public $client_secret = GOOGLE_CLIENT_SECRET;
    public $redirect_uri = 'login_google/callback';

    function index()
    {
        // Set some variables
        $request_params = array(
            "response_type" => "code",
            "client_id" => "$this->client_id",
            "redirect_uri" => BASE_URL."$this->redirect_uri",
            "access_type" => "offline",
            "approval_prompt" => "force",
            "scope" => "openid profile email",
            "hd" => 'khk.ee'
        );
        $url = "https://accounts.google.com/o/oauth2/auth?" . http_build_query($request_params);

        // Redirect user to Google login page
        header("Location: " . $url);
    }


    function callback()
    {
        $case = isset($_GET['error']) ? 'error' : 'sign_in';
        switch ($case) {

            case 'error':
                die($_GET['error']);


            case 'sign_in':

                // Process google output into object
                $authObj = $this->get_authObj($this->client_id, $this->client_secret, $this->redirect_uri);

                // If google returned an object which contains error property show it and quit
                if (isset($authObj->error)) die('Error: ' . $authObj->error . ' ' . $authObj->error_description);

                // Extract user data from google object
                $user = $this->get_user_data($authObj);

                // Get username
                $username = $_SESSION['login_user'] = $user->username;

                // Check if person already exsists in db
                $person = get_first("SELECT person_id, is_admin, person_first_visit, person_last_visit FROM person
                                     WHERE username = '$username'
                                     AND deleted = 0");

                if (empty($person['person_id'])) {

                    // Person did not exsist, insert this person and log the person in
                    $now = date('Y-m-d H:i:s');
                    $person = array('person_firstname' => $user->given_name,'person_lastname' => $user->family_name,'username' => $username, 'is_admin' => 0, 'person_first_visit' => $now, 'person_last_visit' => $now);
                    $person['person_id'] = insert('person', $person);

                } else {

                    // Person existed, update person's last visit time
                    q("UPDATE person SET person_last_visit=NOW() WHERE username = '$username'");
                }

                // Log the person in
                $_SESSION['person_id'] = $person['person_id'];

                /** Set remember me cookie **/


                // Generate 7 char random string
                $SID = substr(md5(rand()), 0, 7);

                // Set cookie to expire in January 2038
                $time = 2147483647;

                // Associate that random string with this user
                update('person', array('person_SID' => $SID), "username = '$username'");

                // Write that random string to cookie
                setcookie("teodor_SID", $SID, $time, '/');

                /** end **/

                if(!get_one("SELECT setup FROM person WHERE person_id={$person['person_id']}")){
                    header('Location: ' . BASE_URL . 'user_setup');
                    exit();
                }

                //Load user data and return
                $this->load_user_data($person);

                // Redirect to home page
                header('Location: ' . BASE_URL);

        }

    }

    public function load_user_data($person)
    {
        foreach ($person as $person_attr => $value) {
            $this->$person_attr = $value;
        }
        $this->logged_in = TRUE;
        $this->person_name = $this->person_firstname . ' ' . $this->person_lastname;

    }

    private function get_user_data($authObj)
    {

        // Get user data
        $dataurl = "https://www.googleapis.com/userinfo/v2/me?access_token={$authObj->refresh_token}";
        $curl = curl_init($dataurl);

        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer {$authObj->access_token}"));
        $json_response = curl_exec($curl);
        curl_close($curl);

        // Decode Google JSON response into PHP object
        $user = json_decode($json_response);

        // Add username into object
        $user->username = substr($user->email, 0, strpos($user->email, '@'));

        // Return user object
        return $user;
    }


    private function get_authObj()
    {
        // Get refresh_token and access_token from Google
        $params = array(
            "code" => $_GET['code'],
            "client_id" => "$this->client_id",
            "client_secret" => "$this->client_secret",
            "redirect_uri" => BASE_URL."$this->redirect_uri",
            "grant_type" => "authorization_code"
        );
        $curl = curl_init('https://accounts.google.com/o/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json_response = curl_exec($curl);
        curl_close($curl);
        $authObj = json_decode($json_response);
        return $authObj;
    }

}
