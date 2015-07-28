<?php

$page = $this->controller;

?>
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

        .navbar-brand {
            font-size: 2em;
            font-weight: 100;
            margin-top:5px;
        }

        .navbar-menu {
            padding-top: 7px;
        }

        .searchbox {
            position: relative;
            min-width: 50px;
            width: 0%;
            height: 50px;
            float: right;
            overflow: hidden;
            margin: 13px 20px 0 0;

            -webkit-transition: width 0.3s;
            -moz-transition: width 0.3s;
            -ms-transition: width 0.3s;
            -o-transition: width 0.3s;
            transition: width 0.3s;
        }

        .searchbox-input {
            top: 0;
            right: 0;
            border: 0;
            outline: 0;
            background: #eaeaea;
            width: 350px;
            height: 40px;
            margin: 0;
            padding: 0 55px 0 10px;
            font-size: 17px;
        }

        .searchbox-submit, .searchbox-icon {
            width: 50px;
            height: 40px;
            display: block;
            position: absolute;
            top: 0;
            font-size: 25px;
            right: 0;
            padding: 0;
            margin: 0;
            border: 0;
            outline: 0;
            line-height: 40px;
            text-align: center;
            cursor: pointer;
            color: #6991AC;
            background: #F8F8F8;
        }

        .searchbox-open {
            width: 100%;
            color: #777;
        }

        .byline {
            position: absolute;
            top: 150px;
            left: 30%;
            text-align: center;
            font-size: 13px;
        }

        .byline a {
            text-decoration: none;
        }
    </style>
    <script>
        var init = [];
        init.push(function() {
            var submitIcon = $('.searchbox-icon');
            var inputBox = $('.searchbox-input');
            var searchBox = $('.searchbox');
            var isOpen = false;
            submitIcon.click(function () {
                if (isOpen == false) {
                    searchBox.addClass('searchbox-open');
                    inputBox.focus();
                    isOpen = true;
                } else {
                    searchBox.removeClass('searchbox-open');
                    inputBox.focusout();
                    isOpen = false;
                }
            });
            submitIcon.mouseup(function () {
                return false;
            });
            searchBox.mouseup(function () {
                return false;
            });
            $(document).mouseup(function () {
                if (isOpen == true) {
                    $('.searchbox-icon').css('display', 'block');
                    submitIcon.click();
                }
            });
        });
        /*function buttonUp(){
            var inputVal = $('.searchbox-input').val();
            inputVal = $.trim(inputVal).length;
            if( inputVal !== 0){
                $('.searchbox-icon').css('display','');
            } else {
                $('.searchbox-input').val('');
                $('.searchbox-icon').css('display','block');
            }
        }*/
        function searchq(str) {
            $.post("videos", {searchTxt: str},function (data) {
                $('#output').html(data);
                });
        }
    </script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
            <a class="navbar-brand" href="""><?= PROJECT_NAME ?></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-menu">
                <li><a class="<?= $page == 'tags' ? 'active' : ''?>" href="tags">Märksõnad</a></li>
                <!-- <li><a href="#kontakt">Kontakt</a></li> -->
                <?if($auth->is_admin){?>
                    <li><a class="<?= $page == 'users' ? 'active' : ''?>"href="users">Kasutajate haldus</a></li>
                <?}?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
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
            <ul class="nav navbar-nav navbar-right">
                <form class="searchbox">
                    <input type="search" placeholder="Otsi..." name="search" class="searchbox-input" onkeyup="searchq(this.value)" required>
                    <!-- <input type="submit" class="searchbox-submit" value="GO"> -->
                    <span class="glyphicon glyphicon-search searchbox-icon"></span>
                </form>
                <div id="output"></div>
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
<script>
    window.onload = function() {
        for (var i in init) {
            init[i]();
        }
    }
</script>
</body>
</html>