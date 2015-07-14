<?php
/**
 * Created by PhpStorm.
 * User: Raul
 * Date: 13.07.2015
 * Time: 11:28
 */

class tags extends Controller {
    function index(){
        $this->tags= get_all("SELECT tag_name, COUNT(video_id) AS count FROM video_tags NATURAL JOIN tag GROUP BY tag_id");
    }
    function view(){
        $tag_id=$this->params[0];
        $this->videos=get_all("SELECT * FROM video_tags NATURAL JOIN video WHERE tag_id='$tag_id'");
        $this->tag=get_one("SELECT tag_name FROM tag WHERE tag_id='$tag_id'");
    }
}