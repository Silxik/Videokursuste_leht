<?php

class videos extends Controller
{

    function index()
    {
        $this->users = get_all("SELECT * FROM user");
        $this->videos = get_all("SELECT * FROM video");
    }
    function view()
    {
        $this->videos = get_one("SELECT * FROM video WHERE id={$this->params[0]}");
    }

    function index_ajax()
    {
        echo "\$_POST:<br>";
        var_dump($_POST);
    }

    function index_post()
    {
        echo "\$_POST:<br>";
        var_dump($_POST);
    }
}