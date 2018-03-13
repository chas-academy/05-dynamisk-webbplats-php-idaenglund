<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-preview">
                        <a href="/post/<?php echo $post->getId(); ?>">
                            <h2 class="post-title">
                                <?php echo $post->getTitle() ?>
                            </h2>
                        </a>
                        <h3 class="post-subtitle">
                            <?php echo $post->getContent(); ?>...
                        </h3>
                        <p class="post-meta">
                            <strong>Posted by:</strong>
                            <a class="card-text"><?php echo $post->getAuthor() ?></a>
                                on <?php echo $post->getPostDate() ?>
                            <br />
                            <strong>Posted in:</strong> <?php echo $post->getCategory() ?> <br/>
                            <strong>Tagged with:</strong> <?php echo $post->getTags() ?>
                        </p>
                        </p>
                    </div>
                    <hr>
                <?php endforeach?>
                <?php else: ?>
                    <div class="post-preview text-center">
                        <?php if(isset($message)): ?>
                            <p><?php echo $message ?></p>
                        <?php else: ?>
                            <p>Nothing here yet. Go make posts!</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
        </div>
    </div>
</div>