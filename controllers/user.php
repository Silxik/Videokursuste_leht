<?php

class user extends Controller
{
    public $requires_auth = true;

    function index()
    {

    }
    function index_post()
    {
        if(isset($_POST['data'])) {
            $data = $_POST['data'];
            $tags = array_splice($data, 3, 1);
            $tags = explode(", ", $tags['tags']);
            $data['person_id'] = $_SESSION['person_id'];
            $data['public'] = isset($data['public']) ? 1 : 0;
            $video_db = get_all("SELECT title, link FROM video");
            $check_for_video = true;
            foreach ($video_db as $video_s) {
                if (in_array($data['title'], $video_s) || in_array($data['link'], $video_s)) {
                    $check_for_video = false;
                    break;
                }
            }
            if ($check_for_video) {
                insert('video', $data);
                foreach ($tags as $tag) {
                    $tags_db = get_all("SELECT tag_name FROM tag");
                    $tag_name['tag_name'] = $tag;
                    if (!in_array($tag_name, $tags_db)) {
                        insert('tag', $tag_name);
                    }
                }
                $last_video_id = get_one("SELECT video_id FROM video ORDER BY video_id DESC LIMIT 1");
                foreach ($tags as $tag) {
                    $tag_id = get_one("SELECT tag_id FROM tag WHERE tag_name='$tag'");
                    if($tag_id==0){
                        $tag_id=1;
                    }
                    $videotags['video_id'] = $last_video_id;
                    $videotags['tag_id'] = $tag_id;
                    insert('video_tags', $videotags);
                }
                echo '<script type="text/javascript">alert("Video lisatud!");</script>';
            }
            else{
                echo '<script type="text/javascript">alert("Video on juba lisatud!");</script>';
            }
        }
    }

}
