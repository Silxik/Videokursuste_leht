<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?= BASE_URL ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title><?= PROJECT_NAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/components/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top:100px;
        }

        .nav input {
            margin-top:19px;
            width:200px;
            border-radius: 3px;
        }

        .navbar-brand {
            font-size: 2em;
            font-weight: 100;
            margin-top:5px;
        }

        .navbar-menu {
            padding-top: 7px;
        }


    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?= PROJECT_NAME ?></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-menu">
                <li><a href="tags">Märksõnad</a></li>
                <!-- <li><a href="#kontakt">Kontakt</a></li> -->
                <?if($auth->is_admin){?>
                    <li><a href="users">Kasutajate haldus</a></li>
                <?}?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><input name="Otsi" placeholder="Otsi"></li>
                <?php
                //Menu options based on login status
                if (!isset($_SESSION['person_id'])){
                    ?>
                    <li>
                        <a href="login"><button class="btn btn-primary">
                                Logi Sisse
                            </button></a>
                    </li>
                <?php } else {
                    $names=get_first("SELECT username, person_firstname FROM person WHERE person_id=".$_SESSION['person_id']);
                    $name=$names['person_firstname']==""?$names['username']:$names['person_firstname'];
                    echo '<li><a href="user">'.$name.'</a></li>';
                    ?>
                    <li>
                        <a href="logout"><button class="btn btn-primary">
                                Logi Välja
                            </button></a>
                    </li>

                <?php } ?>
                <!-- <li><button>Liitu</button></li> -->
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<div class="container">

    <!-- Main component for a primary marketing message or call to action -->
    <? if (!file_exists("views/$controller/{$controller}_$action.php")) error_out('The view <i>views/' . $controller . '/' . $controller . '_' . $action . '.php</i> does not exist. Create that file.'); ?>
    <? @require "views/$controller/{$controller}_$action.php"; ?>

</div>
<!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/components/jquery/1.10.2/jquery-1.10.2.min.js"></script>
<script src="assets/components/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</body>
</html>