<?php foreach ($posts as $post): ?>
<div class="card">
    <div class="list-unstyled">
    <div class="card-text">
        <div class="card-text"><strong>Title</strong>: <?php echo $post->getTitle() ?></div>
        <div class="card-text"><strong>Date</strong>: <?php echo $post->getPostDate() ?></div>
        <div class="card-text"><strong>Text</strong>: <?php echo $post->getContent() ?></div>

        <a href="/post/:<?php echo $post->getId(); ?>/edit">Edit</a>
        <a href="/post/:<?php echo $post->getId(); ?>/delete">Delete</a>
    </div>
    </div>
    <?php endforeach?>
</div>
</div>