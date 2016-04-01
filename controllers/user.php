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
        if (!empty($_POST)) {
            global $db;

            // Course has been selected
            if (!empty($_POST['course_id'])) {
                // Creating a new course
                if (!empty($_POST['course_name'])) {
                    $_POST['person_id'] = $_SESSION['person_id'];
                    $result = insert('course', [
                        'course_name' => $_POST['course_name'],
                        'course_desc' => $_POST['course_desc'],
                        'person_id' => $_SESSION['person_id']
                    ]);
                    $_POST['course_id'] = $result;
                    echo 'Kursus loodud!';
                }
            } else {
                $_POST['course_id'] = 1;
            }

            if (!empty($_POST['link'])) {    // Youtube link
                //TODO: parse short youtube links
                parse_str(parse_url($_POST['link'], PHP_URL_QUERY), $url_vars);
                insert('video', [
                    'link' => $url_vars['v'],
                    'linktype' => 0,
                    'title' => $_POST['title'],
                    'video_desc' => $_POST['video_desc'],
                    'person_id' => $_SESSION['person_id'],
                    'uploader_ip' => $_SERVER['REMOTE_ADDR'],
                    'public' => isset($_POST['public']) ? 1 : 0,
                    'course_id' => $_POST['course_id']
                ]);
            } else {    // Uploaded video
                update('video', [
                    'title' => $_POST['title'],
                    'video_desc' => $_POST['video_desc'],
                    'public' => $_POST['public'],
                    'course_id' => $_POST['course_id']
                ], "video_id = {$_SESSION['file']['video_id']}");
            }

            $tags = explode(", ", $_POST['tags']);  // Getting tag array from $_POST array
            $tags_db = get_all("SELECT tag_name FROM tag");
            $last_video_id = get_one("SELECT video_id FROM video ORDER BY video_id DESC LIMIT 1");  // Last added video id to add tags with it
            foreach ($tags as $tag) {
                $tag_name['tag_name'] = $tag;
                if (!in_array($tag_name, $tags_db)) {
                    insert('tag', $tag_name);
                }
                $tag_id = get_one("SELECT tag_id FROM tag WHERE tag_name='$tag'");
                if ($tag_id == 0) {
                    $tag_id = 1;// If there were no tags before in the database, change value to 1
                }
                $videotags['video_id'] = $last_video_id;
                $videotags['tag_id'] = $tag_id;
                insert('video_tags', $videotags);
            }
        }

        unset($_SESSION['file']);

        exit('Ok');
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
