<div class="container">

    <form id="postForm" action="/admin/tag/<?php echo $tag['id'] ?>/update" method="POST">
        <div class="form-group">
            <label for="title">Tag name</label>
            <input id="name" name="name" value="<?php echo $tag['name'] ?>" type="text" class="form-control" />
        </div>

        <a class="btn btn-secondary" href="/admin" title="Avbryt">Cancel</a>
        <button class="btn btn-primary" type="submit">Update tag</button>
    <form>
</div>