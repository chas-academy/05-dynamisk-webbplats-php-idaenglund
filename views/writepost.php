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
         <?php if(isset($infoMessage)): ?>
            <div class="info-message">
                <p><?php echo $infoMessage; ?></p>
            </div>
         <?php endif; ?>
         <form class="form1" method="POST" action="/posttext">
            <div class="writepost">Title
               <input type="text" name="title" style="width:700px;height:30px;"><br>
               <span class="text">Blogtext</span>
               <textarea class="textarea" name="content" style="width:700px;height:400px;"></textarea>
               <button class="submit" type="submit" style="width:100px;height;100px;">Post</button>
            </div>
         </form>
      </div>
      <?php foreach ($posts as $post): ?>
      <div class="card">
         <div class="list-unstyled">
            <div class="card-text">
               <div class="card-text"><strong>Title</strong>: <?php echo $post->getTitle() ?></div>
               <div class="card-text"><strong>Date</strong>: <?php echo $post->getPostDate() ?></div>
               <div class="card-text"><strong>Text</strong>: <?php echo $post->getContent() ?></div>
               <form class="update" method="POST" action="/deletePost">
                    <input type="hidden" name="postId" value="<?php echo $post->getId(); ?>" />
                    <button class="delete-button">Delete</button>
                </form> 

                <form class="update" method="POST" action="/editText">
                <input type="hidden" name="postId" value="<?php echo $post->getId(); ?>" />
                    <button class="edit-button">Edit</button>
                </form>
            </div>
         </div>
         <?php endforeach?>
         <footer class="footer1">@idaenglund Chas Academy </footer>
      </div>
    </div>
   </body>
</html>