<?php

class user extends Controller
{
    //public $requires_auth = true;

    function index()
    {
        global $db;
       // Upload request has been sent
        if (isset ($_POST["submit"])) {
            $data = array('title' => $_POST['title'], 'link' => $_POST['link'],'tags' => $_POST['tags'],
                'description' => $_POST['desc'],'person_id' => '1','public' => $_POST['access'] == "checked" );

               $data = escape2 ($data);
            try {
                insert ('video', $data);
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

}
