<div class="container">
    <form id="postForm" action="/admin/tag/create" method="POST">
        <div class="form-group">
            <label for="name">Tag name</label>
            <input id="name" placeholder="Give the tag a name" name="name" value="" type="text" class="form-control" />
            <small id="nameHelp" class="form-text text-muted">Give your tag a name</small>
        </div>

        <a class="btn btn-secondary" href="/admin" title="Cancel">Cancel</a>
        <button class="btn btn-primary" type="submit">Create new tag</button>
    <form>
</div>