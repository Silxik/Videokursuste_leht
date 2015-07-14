<?php

class login extends Controller
{
    public $requires_auth = true;

    function index()
    {
        //TODO: figure out auth->$is_admin
        $is_admin = get_one("SELECT is_admin FROM person WHERE person_id = " . $_SESSION['person_id']);
        if ($is_admin) {
            header('Location: ' . BASE_URL . 'user');
        } else {
            header('Location: ' . BASE_URL);
        }
    }
}