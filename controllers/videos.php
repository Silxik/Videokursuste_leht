<?php

class videos extends Controller
{

    function index()
    {
        $this->persons = get_all("SELECT * FROM person");
        $this->videos = get_all("SELECT * FROM video");
        $_tags=get_all("SELECT * FROM video_tags NATURAL JOIN tag");
        foreach($_tags as $tag){
            $this->tags[$tag['video_id']][]=$tag['tag_name'];
        }
    }
    function view()
    {
        $video_id = $this-> params[0];
        $this-> video = get_first("SELECT * FROM video NATURAL JOIN person WHERE video_id='$video_id'");
        $this-> comments = get_all("SELECT * FROM comment NATURAL JOIN person WHERE video_id='$video_id' ORDER BY date_added DESC");
        $this-> persons = get_all("SELECT * FROM person");
        $this-> tags = get_all("SELECT * FROM video_tags NATURAL JOIN tag WHERE video_id='$video_id'");
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
    function view_post(){
        if(isset($_POST['data'])&& isset($_SESSION['person_id'])){
            $video_id=$this->params[0];
            $data = $_POST['data'];
            $data['video_id']=$video_id;
            $data['rating'] = 5;
            $data['person_id'] =$_SESSION['person_id'];
            insert('comment', $data);
            header('Location: ' . BASE_URL . 'videos/view/' . $video_id);
        }
    }
}