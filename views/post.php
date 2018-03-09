<article>
        <div class="container">

                <h1><?php echo $post->getTitle(); ?></h1>
                <span class="meta">Posted by Author Name on <?php echo $post->getPostDate(); ?> in <?php echo $post->getCategory() ?></spa>

                <div class="form-group">
                        <a class="btn btn-outline-primary" href="/admin/post/<?php echo $post->getId(); ?>/edit">Edit</a>
                        <a class="btn btn-outline-danger" href="/admin/post/<?php echo $post->getId(); ?>/delete">Delete</a>
                </div>

                <hr>

                <div class="row">
                        <div class="col-lg-8 col-md-10 mx-auto">
                                <?php echo nl2br($post->getContent()) ?>
                        </div>
                </div>
                <a class="btn btn-outline-primary" href="/">Back to all posts</a>
        </div>
</article>