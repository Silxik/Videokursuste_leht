<?
/**
 * Display a fancy error page and quit.
 * @param $error_file_name_or_msg string The view file of the specific error (in views/errors folder, without _error_view.php suffix)
 */
function error_out($error_file_name_or_msg)
{
    if (!file_exists("views/errors/{$error_file_name_or_msg}_error_view.php")) {
        $errors[] = $error_file_name_or_msg;
    }
    require dirname(__FILE__) . '/../templates/error_template.php';
    exit();
}

function __autoload($className)
{
    (include dirname(__FILE__) . '/classes/' . $className . '.php') or
    (include dirname(__FILE__) . '/../../classes' . $className . '.php') or
    (error_out("Autoload of class $className failed."));
    debug("Autoloaded " . $className);
}

/**
 * @param $text string Text to translate
 * @return string
 */
function __($text)
{
    //TODO: Write your own translation code here
    echo $text;
}

function debug($msg)
{
    if (defined(DEBUG) and DEBUG == true) {
        echo "<br>\n";
        $file = debug_backtrace()[0]['file'];
        $line = debug_backtrace()[0]['line'];
        echo "[" . $file . ":" . $line . "] <b>" . $msg . "</b>";
    }
}

/**
 *
 * Check if all the parts exist, and
 * gather all the parts of the file together
 * @param string $temp_dir - the temporary directory holding all the parts of the file
 * @param string $fileName - the original file name
 * @param string $chunkSize - each chunk size (in bytes)
 * @param string $totalSize - original file size (in bytes)
 */
function createFileFromChunks($temp_dir, $fileName, $chunkSize, $totalSize)
{
    $destination_dir = 'uploads/files/';

    // count all the parts of this file
    $total_files = 0;
    foreach (scandir($temp_dir) as $file) {
        if (stripos($file, $fileName) !== false) {
            $total_files++;
        }
    }

    // check that all the parts are present
    // the size of the last part is between chunkSize and 2*$chunkSize
    if ($total_files * $chunkSize >= ($totalSize - $chunkSize + 1)) {

        if (isset($_SESSION['file'])) { // Update the database if a file has been previously uploaded
            $id = $_SESSION['file']['file_id'];
            update('video', ['filename' => $fileName, 'uploader_ip' => $_SERVER['REMOTE_ADDR']], "video_id = '$id'");
        } else {    // Create a new file record in database
            $id = insert('video', ['filename' => $fileName, 'uploader_ip' => $_SERVER['REMOTE_ADDR']]);
        }
        // Request the inserted row and assign results to session
        $data = get_first("SELECT * FROM video WHERE file_id = '$id'");
        $_SESSION['file'] = $data;


        // Check if path exists
        if (!is_dir($destination_dir)) {
            mkdir($destination_dir, 0777, true);
        }
        // create the final destination file and name it by file_id
        if (($fp = fopen($destination_dir . $data['file_id'], 'w')) !== false) {
            for ($i = 1; $i <= $total_files; $i++) {
                fwrite($fp, file_get_contents($temp_dir . '/' . $fileName . '.part' . $i));
                exit('writing chunk ' . $i);
            }
            fclose($fp);
        } else {
            exit('cannot create the destination file');
        }

        // rename the temporary directory (to avoid access from other
        // concurrent chunks uploads) and than delete it
        if (rename($temp_dir, $temp_dir . '_UNUSED')) {
            rrmdir($temp_dir . '_UNUSED');
        } else {
            rrmdir($temp_dir);
        }
    }
}

/**
 *
 * Delete a directory RECURSIVELY
 * @param string $dir - directory path
 * @link http://php.net/manual/en/function.rmdir.php
 */
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
