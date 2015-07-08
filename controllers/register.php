<?php

class register extends Controller
{

    function index()
    {
        $errors = [];

        if (isset($_POST["submit"])) {
            // kui kasutajanimi ON PUUDU...
            if (empty($_POST["user"])) {
                // ...teata, et kasutajanimi ON PUUDU
                $errors[] = "Kasutajanimi puudu!";
            } else {
                $user = $_POST["user"];
            }
            // kui parool ON PUUDU...
            if (empty($_POST["pass"]) || empty($_POST["pass2"])) {
                // ...teata, et parool ON PUUDU
                $errors[] = "Parool puudu!";
            } else if (strlen($_POST["pass"]) <= 5) {
                $errors[] = "Parool on liiga lühike!";
                // kui paroolid EI ÜHTI...
            } else if ($_POST["pass"] !== $_POST["pass2"]) {
                $errors[] = "Paroolid ei ühti!";
            } else {
                $pass = $_POST["pass"];
            }

            // kui email ON PUUDU...
            if (empty($_POST["email"])) {
                // ...teata, et email ON PUUDU
                $errors[] = "E-mail puudu!";
            } else if ($_POST["email"] !== $_POST["email2"]) {
                $errors[] = "E-mailid ei ühti!";
            } else if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Ebakorrektne e-maili aadress";
            } else {
                $mail = $_POST["email"];
            }

            // kui senini veateateid veel pole
            if (empty($errors)) {
                $user = htmlspecialchars($user);
                $pass = htmlspecialchars($pass);
                $mail = htmlspecialchars($mail);

                $sql = mysqli_query($con, "SELECT * FROM person WHERE username = '" . $user . "'") or die (mysql_error());
                if (mysqli_num_rows($sql) >= 1) {
                    $errors[] = "See kasutajanimi on juba võetud!";
                } else {
                    mysqli_query($con, "INSERT INTO person (username, password, email) VALUES('" . $user . "', '" . sha1($pass) . "', '" . $mail ."')") or die (mysql_error());
                    $errors[] = "Kasutaja loodud!";
                    header("refresh: 1; url=index.php");
                }
            }
            $this->persons = get_all("SELECT * FROM person");
            $this->videos = get_all("SELECT * FROM video");
            $this->data = [$errors, $user, $mail];
        }
    }

    function view()
    {
        $video_id = $this->params[0];
        $this->video = get_first("SELECT * FROM video NATURAL JOIN person WHERE video_id='$video_id'");
    }

}

