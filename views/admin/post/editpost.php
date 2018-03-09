<div class="container">

    <form id="postForm" action="/admin/post/<?php echo $post->getId() ?>/update" method="POST">
        <input type="hidden" name="author" value="<?php echo json_decode($_COOKIE['user']) ?>">

        <div class="form-group">
            <label for="title">Post title</label>
            <input id="title" name="title" value="<?php echo $post->getTitle() ?>" type="text" class="form-control" />
        </div>

        <div class="form-group">
            <select name="category_id" class="form-control">
                <?php foreach ($categories as $category): ?>
                    <?php if ((int) $category['id'] !== $post->getCategoryId()): ?>
                        <option value="<?php echo $category['id'] ?>">
                            <?php echo $category['name'] ?>
                        </option>
                    <?php else: ?>
                        <option value="<?php echo $category['id'] ?>" selected="selected">
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <select name="tags[]" multiple="multiple" class="form-control">
                <?php $postTags = explode(',', $post->getTagIds()) ?>
                <option value="NULL">
                    <?php echo 'No tags' ?>
                </option>
                <?php foreach ($tags as $tag): ?>
                    <?php if (array_search($tag['id'], $postTags) === false): ?>
                        <option value="<?php echo $tag['id'] ?>">
                            <?php echo $tag['name'] ?>
                        </option>
                    <?php else: ?>
                        <option value="<?php echo $tag['id'] ?>" selected="selected">
                            <?php echo $tag['name']; ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <textarea class="form-control" name="content">
                <?php echo $post->getContent() ?>
            </textarea>
        </div>

        <a class="btn btn-secondary" href="/admin" title="Avbryt">Cancel</a>
        <button class="btn btn-primary" type="submit">Update post</button>
    <form>
</div>