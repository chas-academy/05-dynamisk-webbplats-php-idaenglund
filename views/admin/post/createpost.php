<div class="container">
    <?php echo '<h1> Welcome back ' . $user->getUsername() . '</h1>'; ?>

    <form id="postForm" action="/admin/post/create" method="POST">
        <input type="hidden" name="author_id" value="<?php echo json_decode($_COOKIE['user']) ?>">
        <div class="form-group">
            <label for="title">Post title</label>
            <input id="title" placeholder="Skriv en titel" name="title" value="" type="text" class="form-control" />
            <small id="titleHelp" class="form-text text-muted">Give your post a title</small>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" class="form-control">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id'] ?>">
                        <?php echo $category['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small id="categoryHelp" class="form-text text-muted">Give your post a category</small>
        </div>
        <div class="form-group">
            <label for="tags[]">Tags</label>
            <select name="tags[]" multiple="multiple" class="form-control">
                <?php foreach ($tags as $tag): ?>
                    <option value="<?php echo $tag['id'] ?>">
                        <?php echo $tag['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small id="tagsHelp" class="form-text text-muted">Give your post one more tags</small>
        </div>

        <div class="form-group">
            <textarea class="form-control" name="content" placeholder="Write your content here"></textarea>
        </div>

        <a class="btn btn-secondary" href="/admin" title="Avbryt">Cancel</a>
        <button class="btn btn-primary" type="submit">Create new post</button>
    <form>
</div>