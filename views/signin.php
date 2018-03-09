<div class="container">

  <div>
    <?php echo $this->flash->flash(); ?>
  </div>

  <form class="form-signin" method="POST" action="/login">
    <div class="form-label-group">
      <label for="username">Username</label>
      <input name="username" type="text" id="username" class="form-control" placeholder="Username" required autofocus>
    </div>

    <div class="form-group form-label-group">
      <label for="password">Password</label>
      <input name="password" type="password" id="password" class="form-control" placeholder="Password" required>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  </form>
</div>