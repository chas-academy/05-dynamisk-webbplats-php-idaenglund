<div id="wrapper">
    <div id="header">
        <header class="header">
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <?php echo '<h1> Welcome back ' . $user->getUsername() . '</h1>'; ?>
        </header>
    </div>
    <div id="content">
        <?php if (isset($infoMessage)): ?>
        <div class="info-message">
            <p>
                <?php echo $infoMessage; ?>
            </p>
        </div>
        <?php endif; ?>
        <form class="form1" method="POST" action="/post/create">

            <div class="writepost">
                Title
                <input type="text" name="title" value="" style="width:700px;height:30px;" />
                <br>

                <!-- TODO This should fetch categories from the model and loop through them here, dont hardcode things! -->
                <?php
                    /*
                    <select name="categorie_id">
                        <option value="" selected="selected">Please select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id'] ?>">
                            <?php echo $category['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    */
                ?>
                <select name="categorie_id">
                    <option value="" selected="selected">Please select a category</option>
                    <option value="3">Animal</option>
                    <option value="4">Animal activists</option>
                    <option value="5">Animal organisations</option>
                    <option value="6">Animal sancturaries</option>
                </select>

                <span class="text">Blogtext</span>

                <textarea class="textarea" name="content" style="width:700px;height:400px;"></textarea>

                <span>Optional choose tagname</span>

                <select name="tags[]" multiple="multiple">
                    <?php foreach ($tags as $tag): ?>
                    <option value="<?php echo $tag['id'] ?>">
                        <?php echo $tag['name'] ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <button class="submit" type="submit" style="width:100px;height;100px;">Post</button>
            </div>
        </form>
    </div>
    <div class="post-wrapper">
        <?php foreach ($posts as $post): ?>
        <div class="card">
            <div class="list-unstyled">
                <div class="card-text">
                    <div class="card-text">
                        <strong>Title</strong>:
                        <?php echo $post->getTitle() ?>
                    </div>
                    <div class="card-text">
                        <strong>Date</strong>:
                        <?php echo $post->getPostDate() ?>
                    </div>
                    <div class="card-text">
                        <strong>Text</strong>:
                        <?php echo $post->getContent() ?>
                    </div>
                    <div class="card-text">
                        <strong>Categorie</strong>:
                        <?php echo $post->getCategorieId() ?>
                    </div>
                    <div class="card-text">
                        <strong>Tags</strong>:
                        <?php echo $post->getTagId() ?>
                    </div>

                    <a class="edit-link" href="/post/<?php echo $post->getId(); ?>/edit">Edit</a>
                    <a class="delete-link" href="/post/<?php echo $post->getId(); ?>/delete">Delete</a>
                </div>
            </div>
        </div>
        <?php endforeach?>
    </div>
</div>