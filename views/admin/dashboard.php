<div class="container">
  <table class="table table-striped table-bordered table-list">
    <thead>
      <tr>
        <th>
            Actions
        </th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Date</th>
        <th>Content (abbr.)</th>
        <th>Category</th>
        <th>Tags</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ?>
          <tr>
            <td align="left">
              <a class="btn btn-primary" href="<?php echo "/admin/post/" . $post->getId()?>/edit">
                  <svg id="i-edit" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z" />
                  </svg>
              </a>
              <a class="btn btn-danger" href="<?php echo "/admin/post/" . $post->getId()?>/delete">
                  <svg id="i-trash" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6" />
                  </svg>
              </a>
            </td>
            <td><?php echo $post->getId() ?></td>
            <td><?php echo "Author Goes here" ?></td>
            <td><?php echo $post->getTitle() ?></td>
            <td><?php echo $post->getPostDate() ?></td>
            <td><?php echo substr($post->getContent(), 0, 20) ?></td>
            <td><?php echo $post->getCategoryId() ?></td>
            <td><?php echo (empty($post->getTagIds()) === true) ? 'No tags' : $post->getTags() ?></td>
          </tr>
        <?php endforeach; ?>
          <tr>
              <td align="center" colspan="8">
                <a href="/admin/post/create">Add more posts</a>
              </td>
          </tr>
        <?php else: ?>
          <tr>
              <td align="center" colspan="8">
                <a href="/admin/post/create">No posts here, create one?</a>
              </td>
          </tr>
        <?php endif; ?>
    </tbody>
  </table>

<table class="table table-striped table-bordered table-list">
    <thead>
      <tr>
        <th>
            Actions
        </th>
        <th>Id</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($tags) > 0): ?>
        <?php foreach ($tags as $tag): ?>
          <tr>
            <td align="left">
              <a class="btn btn-primary" href="<?php echo "/admin/tag/" . $tag['id'] ?>/edit">
                  <svg id="i-edit" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <path d="M30 7 L25 2 5 22 3 29 10 27 Z M21 6 L26 11 Z M5 22 L10 27 Z" />
                  </svg>
              </a>
              <a class="btn btn-danger" href="<?php echo "/admin/tag/" . $tag['id'] ?>/delete">
                  <svg id="i-trash" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6" />
                  </svg>
              </a>
            </td>
            <td><?php echo $tag['id'] ?></td>
            <td><?php echo $tag['name'] ?></td>
          </tr>
          <?php endforeach; ?>
            <tr>
              <td align="center" colspan="3">
                <a href="/admin/tag/create">Want to add more tags? Go here!</a>
              </td>
            </tr>
        <?php else: ?>
        <tr>
            <td align="center" colspan="3">
              <a href="/admin/tag/create">No tags here, create one?</a>
            </td>
          </tr>
        <?php endif; ?>
    </tbody>
  </table>


</div>