<?php

class videos extends Controller
{

    function index()
    {
        $this->courses = get_all("SELECT * FROM course ORDER BY 'date_added' ASC LIMIT 5");
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
        global $db;
        $output='';
        $searchTxt=$_POST['searchTxt'];
        $sql="SELECT * FROM video WHERE title LIKE '%$searchTxt%'";
        $q = mysqli_query($db, $sql) or db_error_out();
        $count=mysqli_num_rows($q);
        if($count==0){
            $output='There was no search results!';
        }
        else{
            while ($result= mysqli_fetch_assoc($q)) {
                $video_id=$result['video_id'];
                $title=$result['title'];
                $desc=$result['desc'];
                $output.='<li><a href="'.BASE_URL.'videos/view/'.$video_id.'">'.$title.'</a></li>';

            }

        }
        echo $output;
        /*echo "\$_POST:<br>";
        var_dump($_POST);*/
    }

    function index_post()
    {
/*        echo "\$_POST:<br>";
        var_dump($_POST);*/
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