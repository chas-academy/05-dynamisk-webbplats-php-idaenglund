<?php
    global $assetPath;

    if ($_SERVER['SERVER_NAME'] === 'test.idaenglund.chas.academy') {
        $assetPath = 'http://' . $_SERVER['HTTP_HOST'] . '/web';
    } else {
        $assetPath = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $assetPath . "styles/bootstrap.min.css " ?> ">
    <link rel="stylesheet" type="text/css" href="<?php echo $assetPath . "styles/style.css " ?>">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
        rel="stylesheet">
    <title>My Blog</title>
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <a class="navbar-brand" href="/">My Blog</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/post/category/3">Animals</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/post/category/4">Animal sanctuaries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/post/category/5">Animal activists</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/post/category/6">Animal welfare organisations</a>
            </li>
            <?php if(isset($_COOKIE['user'])): ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-success" href="/admin">Admin dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-primary" href="/logout">Log out</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="btn btn-outline-primary" href="/signin">Log in</a>
                </li>
            <?php endif;?>
        </ul>
    </div>
</nav>

<!-- Masthead -->
<header class="masthead" style="background-image: url('<?php echo $assetPath . "styles/images/patrick-hendry-221863.jpg" ?>')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>My Blog</h1>
                    <span class="subheading">“The question is not, can they reason?, nor can they talk? but, can they suffer?” - Jeremy Buntham
                        </p>
                        <form class="form" method="POST" action="/post/search">
                            <div class="form-group">
                                <input type="text" name="query" class="form-control-lg" placeholder="Search here" />
                                <button class="btn btn-primary btn-lg" type="submit">Search</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</header>