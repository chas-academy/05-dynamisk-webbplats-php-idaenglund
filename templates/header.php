<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="http://localhost:8080/styles/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <title> My blog </title>
</head>

<body>
    <header class="header">
        <i class="fa fa-twitter" aria-hidden="true"></i>
        <h1>My Blog</h1>
        <nav id="primary_nav_wrap">
            <ul>
                <li>
                    <a href="#">CATEGORIES</a>
                    <ul>    
                        <li>
                            <a href="/post/categorie">Animals</a>
                        </li>
                        <li>
                            <a href="/post/categorie">Animal activits</a>
                        </li>
                        <li>
                            <a href="/post/categorie">Animal organisations</a>
                        </li>
                        <li>
                            <a href="/post/categorie">Animal sanctuaries</a>
                    </ul>
                </li>
            </ul>
        <form class="form" method="POST" action="/search">
            <div class="inlog">Search for tags
                <input type="text" name="tags">
                <span class="hide"></span>
            </div>
        </form>
            
        <?php if(!isset($_COOKIE['user'])): ?>
        <form class="form" method="POST" action="/login">
            <div class="inlog">Username
                <input type="text" name="username">
                <span class="hide">
                    <br>
                </span>
                <span class="password">Password</span>
                <input type="password" name="password">
                <button class="signin-button"type="submit">Sign in</button>
            </div>
        </form>
        <?php else: ?>
        <a class="logout" href="/logout">Log out</a>
        <?php endif;?>

    <?php if(isset($_COOKIE['user'])): ?>
         <a class="newpost" href="/post/create">New post</a>
    <?php endif; ?>
        <p class="quote">“The question is not, can they reason?,
            <br> nor can they talk?
            <br>but, can they suffer?”
            <br> -Jeremy Buntham </p>
        <img class="lion" src="http://localhost:8080/views/images/patrick-hendry-221863.jpg" height="700px" width="200px" alt="Lion on a black back-ground">
    </header>