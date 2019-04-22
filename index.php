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

                <?php if (!empty($url)): ?>
                    <?php
                    $file_contents = @file_get_contents($url);

                    $tag = !empty($_GET['tag']) ? $_GET['tag'] : null;
                    $file_contents_f = is_null($tag) ? $file_contents : str_replace([''], [''], $file_contents);

                    $dm = new DOMDocument();
                    @$dm->loadHTML($file_contents);

                    $html_tags = getHtmlTagsWithCount($dm);
                    ksort($html_tags, SORT_STRING);
                    ?>
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header pl-3" style="background-color: gray;"><h6 class="card-title mb-0 font-weight-bold">View Source</h6></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pre-scrollable bg-white">
                                            <pre><code><?= htmlentities($file_contents_f); ?></code></pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table text-left m-0 bg-white">
                                <thead>
                                <tr bgcolor="gray" class="font-weight-bold">
                                    <td colspan="2">Summary of findings</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr valign="top">
                                    <td width="150" class="p-0">
                                        <ul class="list-group">
                                            <?php foreach ($html_tags as $tag_name => $tag_count) { ?>
                                                <li class="list-group-item p-2">
                                                    <a href="#<?= $tag_name; ?>" class="text-dark">
                                                        <?= $tag_name; ?>
                                                        <span class="badge badge-info float-right"><?= $tag_count; ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                    <td><?php displayNodes($dm); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
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
<?php
function getHtmlTagsWithCount($dm)
{
    static $html_tags = [];
    foreach ($dm->childNodes as $node) {
        if (!property_exists($node, 'tagName')) {
            continue;
        }

        if (!isset($html_tags[$node->tagName])) {
            $html_tags[$node->tagName] = 0;
        }

        $html_tags[$node->tagName] += 1;

        if ($node->hasChildNodes()) {
            getHtmlTagsWithCount($node);
        }
    }

    return $html_tags;
}

function displayNodes($dm)
{
    echo '<ul>';
    foreach ($dm->childNodes as $node) {
        if (!property_exists($node, 'tagName')) continue;

        echo '<li>';
        echo '<a id="#' . $node->tagName . '">' . $node->tagName . '</a>';
        #echo '<pre>' . print_r($node, true) . '</pre>';

        #displayAttributes($node);

        if ($node->hasChildNodes()) {
            displayNodes($node);
        }
        echo '</li>';
    }
    echo '</ul>';
}

function displayAttributes($node)
{
    echo '<ul>';
    foreach ($node->attributes as $attribute) {
        echo '<li><b>' . $attribute->name . '</b> = ' . $attribute->value . '</li>';
        #echo '<pre>' . print_r($attribute, true) . '</pre>';
    }
    echo '</ul>';
}