<?php

class videos extends Controller
{

    function index()
    {
        $this->persons = get_all("SELECT * FROM person");
        $this->videos = get_all("SELECT * FROM video");
    }
    function view()
    {
        $video_id = $this-> params[0];
        $this-> video = get_first("SELECT * FROM video NATURAL JOIN person WHERE video_id='$video_id'");
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