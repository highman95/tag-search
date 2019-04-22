<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="mskrWcH6Y4ILIkWsaxNvvrZ00XlRxARmLdZQZIIP">

    <title>Tags Search | X-Media</title>

    <!-- Scripts -->
    <!--<script src="assets/js/app.js" defer></script>-->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/app-2.css" rel="stylesheet">
    <style type="text/css">
        .sapi-content-wrapper {
            min-height: 500px;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href=".">
                X-Media
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item active">
                        <a class="nav-link" href=".">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <main class="py-4 sapi-content-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Tags Search</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php $url = !empty($_GET['q']) ? $_GET['q'] : null; ?>

                    <br/>
                    <form method="get" action="">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" name="q" class="form-control" value="<?php echo $url; ?>" placeholder="Enter Web Address (URL) to fetch..."/>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-dark" title="Search">&nbsp;&rightarrow;</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr/>
                </div>
            </div>
        </main>

        <hr>
        <footer class="small">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-xs-8">
                    <p>&copy; 2019. <a href="#" class="text-bold">X-Media</a>. All Rights Reserved.</p>
                </div>
                <div class="col-md-5 col-xs-4 text-right">
                    <a href="#terms">Terms</a> | <a href="#privacy">Privacy</a>
                </div>
            </div>
        </footer>
    </div>
</div>
</body>
</html>