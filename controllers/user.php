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

            // variable to check for existing videos
            $check_for_video = true;
            //getting tag array from $data array
            $tags = array_splice($data, 3, 1);
            $tags = explode(", ", $tags['tags']);
            //setting person id to logged on person
            $data['person_id'] = $_SESSION['person_id'];
            $data['public'] = isset($data['public']) ? 1 : 0;

            if ($_FILES['upload']['size'] != 0) {//uploaded video
                //TODO: create video thumbnails
                global $db;
                $file = $_FILES['upload'];
                $filename = basename($file['name']);
                $info = pathinfo($filename);
                $ext = $info['extension']; // get the extension of the file
                $allowed = array('mp4', 'webm');
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
                        echo $filename . ' üles laetud!' . PHP_EOL;
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
            } else {//youtube video
                //TODO: parse short youtube links
                parse_str(parse_url($data['link'], PHP_URL_QUERY), $url_vars);
                $data['link'] = $url_vars['v'];
                $data['linktype'] = 0;

                $video_db = get_all("SELECT title, link FROM video");// getting list of existing videos for check
                // loop to look for videos in database based on title or link
                foreach ($video_db as $video_s) {
                    if (in_array($data['title'], $video_s) || in_array($data['link'], $video_s)) {
                        $check_for_video = false;
                        break;
                    }
                }
            }
            if ($check_for_video) {
                //TODO: error handling for insert functions
                insert('video', $data);
                foreach ($tags as $tag) {
                    $tags_db = get_all("SELECT tag_name FROM tag");
                    $tag_name['tag_name'] = $tag;
                    if (!in_array($tag_name, $tags_db)) {
                        insert('tag', $tag_name);
                    }
                }

                $last_video_id = get_one("SELECT video_id FROM video ORDER BY video_id DESC LIMIT 1");// last added video id to add tags with it
                foreach ($tags as $tag) {
                    $tag_id = get_one("SELECT tag_id FROM tag WHERE tag_name='$tag'");
                    if ($tag_id == 0) {
                        $tag_id = 1;// if there were no tags before in the database, change value to 1
                    }
                    $videotags['video_id'] = $last_video_id;
                    $videotags['tag_id'] = $tag_id;
                    insert('video_tags', $videotags);
                }
                //TODO: prettier notifications
                echo '<b>Video lisatud!</b>';
            } else {
                echo '<b>Video on juba olemas!</b>';
            }
        }
    }
}
