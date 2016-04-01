<?php

class user extends Controller
{
    public $requires_auth = true;

    function index()
    {
        $person_id = $_SESSION['person_id'];
        $this->courses = get_all("SELECT * FROM course WHERE person_id = '$person_id'");
        $this->videos = get_all("SELECT * FROM video WHERE person_id='$person_id'");
    }

    function view()
    {
        $video_id = $this->params[0];
        if (empty($video_id))
            error_out('Check video ID in address bar');
        $this->video = get_first("SELECT * FROM video WHERE video_id = '$video_id'");
        $this->course = get_first("SELECT * FROM course WHERE course_id=(SELECT course_id FROM video WHERE video_id = '$video_id')");
        $this->tags = get_all("SELECT tag_name FROM video_tags NATURAL JOIN tag WHERE video_id='$video_id'");

    }

    function edit()
    {
        $video_id = $this->params[0];
        $this->video = get_first("SELECT * FROM video WHERE video_id='$video_id'");
        $this->video_course = get_first("SELECT * FROM course WHERE course_id=(SELECT course_id FROM video WHERE video_id = '$video_id')");
        $this->courses = get_all("SELECT * FROM course WHERE person_id=" . $_SESSION['person_id'] . " OR course_id=1");
        $this->tags = get_all("SELECT tag_name FROM video_tags NATURAL JOIN tag WHERE video_id='$video_id'");
    }

    function course()
    {
        $course_id = $this->params[0];
        $this->course = get_first("SELECT * FROM course WHERE course_id = '$course_id'");
    }

    function course_post()
    {
        if (isset($_POST['data'])) {//update course
            $data = $_POST['data'];
            update('course', $data, "person_id = '" . $_SESSION['person_id'] . "' AND course_id = '" . $data['course_id'] . "'");
        } else if (isset($_POST['id'])) {//delete course
            update('video', ['course_id' => '1'], "person_id = " . $_SESSION['person_id'] . " AND course_id = " . $_POST['id']);
            q("DELETE FROM course WHERE person_id = " . $_SESSION['person_id'] . " AND course_id = " . $_POST['id']);
        }
        exit("Ok");
    }

    function upload()
    {
        // Verifies if given chunck is already uploaded
        if (!empty($_GET['resumableIdentifier'])) {
            $temp_dir = 'uploads/chunks/' . $_GET['resumableIdentifier'];
            $chunk_file = $temp_dir . '/' . $_GET['resumableFilename'] . '.part' . $_GET['resumableChunkNumber'];
            if (file_exists($chunk_file)) {
                header("HTTP/1.0 200 Ok");
                exit('Chunk exists');
            } else {
                header('HTTP/1.0 204 No Content');
                exit('No chunck');
            }
        }
    }

    function upload_post()
    {
        // loop through files and move the chunks to a temporarily created directory
        if (!empty($_FILES)) foreach ($_FILES as $file) {
            // check the error status
            if ($file['error'] != 0) {
                exit('error ' . $file['error'] . ' in file ' . $_POST['resumableFilename']);
                continue;
            }
            // init the destination file (format <filename.ext>.part<#chunk>
            // the file is stored in a temporary directory
            $temp_dir = 'uploads/chunks/' . $_POST['resumableIdentifier'];
            $dest_file = $temp_dir . '/' . $_POST['resumableFilename'] . '.part' . $_POST['resumableChunkNumber'];

            // create the temporary directory
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }

            // move the temporary file
            if (!move_uploaded_file($file['tmp_name'], $dest_file)) {
                exit('Error saving (move_uploaded_file) chunk ' . $_POST['resumableChunkNumber'] . ' for file ' . $_POST['resumableFilename']);
            } else {
                // check if all the parts present, and create the final destination file
                createFileFromChunks($temp_dir, $_POST['resumableFilename'],
                    $_POST['resumableChunkSize'], $_POST['resumableTotalSize']);
            }
            exit();
        }
    }

    function index_ajax()
    {
        exit('ajax');
        if (isset($_POST['link'])) {    // Youtube link was submitted
            //TODO: create video thumbnails
            global $db;
            $file = $_FILES['upload'];
            $filename = $data['filename'] = basename($file['name']);
            $info = pathinfo($filename);
            $ext = $info['extension']; // get the extension of the file
            $allowed = array('mp4', 'webm');
            if (!in_array($ext, $allowed)) {
                exit('Failitüüp ' . $ext . ' pole lubatud!');
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
                    exit('Faili ei suudetud üles laadida');

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
                    $video_exists = true;
                    break;
                }
            }
        }

        exit();
        if (!empty($_POST['data'])) {
            global $db;
            $data = $_POST['data'];
            $tags = $_POST['tags'];
            $course = $_POST['course'];
            // Course has been selected
            if (isset($data['course_id'])) {
                // Creating a new course
                if ($course['course_name'] != '') {
                    $course['person_id'] = $_SESSION['person_id'];
                    $result = mysqli_query($db, "SHOW TABLE STATUS LIKE 'course'");
                    $row = mysqli_fetch_array($result);
                    $data['course_id'] = $row['Auto_increment']; // Get the next id for creating a unique filename
                    insert('course', $course);
                    echo 'Kursus loodud!';
                }
            } else {
                $data['course_id'] = 1;
            }

            // variable to check for existing videos
            $video_exists = false;
            //getting tag array from $data array
            $tags = explode(", ", $tags['tags']);
            //setting person id to logged on person
            $data['person_id'] = $_SESSION['person_id'];
            $data['public'] = isset($data['public']) ? 1 : 0;

            if (isset($_FILES['upload'])) {//uploaded video
                //TODO: create video thumbnails
                global $db;
                $file = $_FILES['upload'];
                $filename = $data['filename'] = basename($file['name']);
                $info = pathinfo($filename);
                $ext = $info['extension']; // get the extension of the file
                $allowed = array('mp4', 'webm');
                if (!in_array($ext, $allowed)) {
                    exit('Failitüüp ' . $ext . ' pole lubatud!');
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
                        exit('Faili ei suudetud üles laadida');

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
                        $video_exists = true;
                        break;
                    }
                }
            }
            if (!$video_exists) {
                //TODO: error handling for insert functions
                insert('video', $data);
                $tags_db = get_all("SELECT tag_name FROM tag");
                $last_video_id = get_one("SELECT video_id FROM video ORDER BY video_id DESC LIMIT 1");// last added video id to add tags with it
                foreach ($tags as $tag) {
                    $tag_name['tag_name'] = $tag;
                    if (!in_array($tag_name, $tags_db)) {
                        insert('tag', $tag_name);
                    }
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

    function edit_post()
    {
        $video_id = $this->params[0];
        $data = $_POST['data'];
        $data['public'] = isset($data['public']) ? 1 : 0;
        $tags = $_POST['tags'];
        $tags = explode(", ", $tags['tags']);
        delete('video_tags', "video_id='$video_id'");
        $tags_db = get_all("SELECT tag_name FROM tag");
        foreach ($tags as $tag) {
            $tag_name['tag_name'] = $tag;
            if (!in_array($tag_name, $tags_db)) {
                insert('tag', $tag_name);
            }
            $tag_id = get_one("SELECT tag_id FROM tag WHERE tag_name='$tag'");
            $videotags['video_id'] = $video_id;
            $videotags['tag_id'] = $tag_id;
            insert('video_tags', $videotags);
        }
        update('video', $data, "video_id='$video_id'");

        if (isset($_FILES['upload'])) {//uploaded transcript
            $file = $_FILES['upload'];
            $filename = basename($file['name']);
            $info = pathinfo($filename);
            $ext = $info['extension']; // get the extension of the file
            $allowed = array('srt');
            if (!in_array($ext, $allowed)) {
                echo 'Failitüüp ' . $ext . ' pole lubatud!';
                return;
            }
            try {
                if ($wat = move_uploaded_file($file['tmp_name'], "uploads/$video_id.$ext")) {
                    update('video', ['subs' => "$video_id.$ext"], "video_id='$video_id'");
                    echo $filename . ' üles laetud!' . PHP_EOL;
                } else {
                    echo 'Faili ei suudetud üles laadida';
                    return;
                }
            } catch (Exception $e) {
                echo 'Midagi läks valesti: ' . $e->getMessage() . PHP_EOL;
                return;
            }
        }

        header('refresh:1; url=' . BASE_URL . 'user/view/' . $this->params[0]);
    }

    function delete_post()
    {
        $video = get_first("SELECT * FROM video WHERE video_id=" . $_POST['video_id']);
        if ($_SESSION['person_id'] == $video['person_id']) {
            $video_id = $_POST['video_id'];
            if ($video['linktype'] == 1) {
                if (!unlink('uploads/' . $video['link'])) {
                    print_r(error_get_last());
                    exit("0");
                }
            }
            delete('video_tags', "video_id = '$video_id'");
            delete('comment', "video_id = '$video_id'");
            delete('video', "video_id='$video_id'");
            exit("Ok");
        }
    }
}
