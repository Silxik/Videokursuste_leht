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
            padding-top: 70px;
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
            <ul class="nav navbar-nav">
                <li><a href="#kursused">Kursused</a></li>
                <li><a href="#kontakt">Kontakt</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><input name="Otsi" placeholder="Otsi"></li>
                <li>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Logi Sisse
                    </button>

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Log in</h4>
                                </div> <!-- /.modal-header -->

                                <div class="modal-body">
                                    <form role="form">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="uLogin" placeholder="Login">
                                                <label for="uLogin" class="input-group-addon glyphicon glyphicon-user"></label>
                                            </div>
                                        </div> <!-- /.form-group -->

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="uPassword" placeholder="Password">
                                                <label for="uPassword" class="input-group-addon glyphicon glyphicon-lock"></label>
                                            </div> <!-- /.input-group -->
                                        </div> <!-- /.form-group -->

                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Remember me
                                            </label>
                                        </div> <!-- /.checkbox -->
                                    </form>

                                </div> <!-- /.modal-body -->

                                <div class="modal-footer">
                                    <button class="form-control btn btn-primary" >Ok</button>

                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
                                            <span class="sr-only">progress</span>
                                        </div>
                                    </div>
                                </div> <!-- /.modal-footer -->

                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </li>
                <li><button>Liitu</button></li>
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
