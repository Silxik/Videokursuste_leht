<?php

class user extends Controller
{
    public $requires_auth = true;

    function index()
    {

    }
    function index_post()
    {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
            $data['person_id'] = $_SESSION['person_id'];
            $data['public'] = isset($data['public']) ? 1 : 0;

            if (isset($_FILES)) {
                global $db;
                $file = $_FILES['upload'];
                $filename = basename($file['name']);
                $info = pathinfo($filename);
                $ext = $info['extension']; // get the extension of the file
                $allowed =  array('avi','mp4' ,'webm', 'mov', '3gp', 'mmv');
                if (!in_array($ext, $allowed)) {
                    echo 'Failitüüp ' . $ext . ' pole lubatud!';
                    return;
                }
                $result = mysqli_query($db, "SHOW TABLE STATUS LIKE 'video'");
                $row = mysqli_fetch_array($result);
                $nextId = $row['Auto_increment']; // get the next id for creating a unique filename

                $newname = "$nextId." . $ext;
                try {
                    if ($wat = move_uploaded_file($file['tmp_name'], 'uploads/' . $newname)) {
                        echo $filename . ' üles laetud!'. PHP_EOL;
                        $data['linktype'] = 1;
                    } else {
                        echo 'Faili ei suudetud üles laadida';
                        return;
                    }
                    $data['link'] = $newname;
                } catch (Exception $e) {
                    echo 'Midagi läks valesti: ' . $e->getMessage() . PHP_EOL;
                    return;
                }
            } else {
                parse_str( parse_url( $data['link'], PHP_URL_QUERY ), $url_vars);
                $data['link'] = $url_vars['v'];
                $data['linktype'] = 0;
            }

            if  (insert('video', $data)) {
                echo 'Video lisatud!';
            }
        }
    }

}
