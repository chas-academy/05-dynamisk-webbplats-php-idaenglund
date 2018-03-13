<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php foreach ($posts as $post): ?>
                <div class="post-preview">
                    <a href="/post/<?php echo $post->getId(); ?>">
                        <h2 class="post-title">
                            <?php echo $post->getTitle() ?>
                        </h2>
                        <h3 class="post-subtitle">
                        <?php echo $post->getContent(); ?>...
                        </h3>
                    </a>
                    <p class="post-meta">
                        Posted by
                        <a class="card-text"><?php echo $post->getAuthor() ?></a>
                            on <?php echo $post->getPostDate() ?>
                        <br />
                        Tagged with <?php echo $post->getTags() ?>
                    </p>
                    </p>
                </div>
                <hr>
            <?php endforeach?>
        </div>
    </div>
</div>