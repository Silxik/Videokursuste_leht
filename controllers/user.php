<?php

class user extends Controller
{
    public $requires_auth = true;

    function index()
    {

    }
    function index_post()
    {
        if(isset($_POST['data'])){
            $data = $_POST['data'];
            $data['person_id'] = 3;
            $data['public'] = isset($data['public']) ? 1 : 0;
            insert('video', $data);
        }
    }

}
