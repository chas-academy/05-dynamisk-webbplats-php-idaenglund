<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="http://localhost:8080/styles/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <title>My blog</title>
</head>

<body>
    <div id="wrapper">
        <div id="header">
    <header class="header">
        <i class="fa fa-twitter" aria-hidden="true"></i>
        <?php echo '<h1> Welcome back ' . $username . '</h1>'; ?>
       

            <form class="form" method="POST" action="/logout">
                <button type="submit">Log out</button>
            </form>

    </header>
</div>
<div id="content">
    <form class="form1" method="POST" action="/posttext">
            <div class="writepost">Title
                <input type="text" name="title" style="width:700px;height:30px;"><br>
                <span class="text">Blogtext</span>
                <textarea class="textarea" name="content" style="width:700px;height:400px;"></textarea>
                <button type="submit" style="width:100px;height;100px;">Post</button>
            </div>
        </form>
</div>    

<footer class="footer1">@idaenglund Chas Academy </footer>
</div>  
</body>
</html>
