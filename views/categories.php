<div class="post-wrapper">

<?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
    <div class="card">
        <div class="list-unstyled">
        <div class="card-text">
            <div class="card-text"><strong>Title</strong>: <?php echo $post->getTitle() ?></div>
            <div class="card-text"><strong>Date</strong>: <?php echo $post->getPostDate() ?></div>
            <div class="card-text"><strong>Text</strong>: <?php echo $post->getContent() ?></div>
            <div class="card-text"><strong>Categorie</strong>: <?php echo $post->getCategorieName() ?></div>


            <a class ="edit-link" href="/post/<?php echo $post->getId(); ?>/edit" >Edit</a>
            <a class="delete-link" href="/post/<?php echo $post->getId(); ?>/delete">Delete</a>
        </div>
        </div>
    </div>
    <?php endforeach?>
<?php else: ?>
<div class="card">
        <div class="list-unstyled">
        <div class="card-text">
            <p>Oops. Seems like there are no posts in this category! :(</p>
        </div>
        </div>
    </div>
<?php endif; ?>
</div>