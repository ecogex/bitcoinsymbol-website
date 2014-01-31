    <form action="<?= $base_url ?>admin/login" method="post" class="login">
      <?php if (isset($error)): ?>
      <p class="error"><?= $error ?></p>
      <?php endif ?>
      <input type="hidden" name="admin_csrf" value="<?= $admin_csrf ?>">
      <p><label for="username">username</label> <input name="username" id="username" autofocus></p>
      <p><label for="password">Password</label> <input type="password" name="password" id="password"></p>
      <p><button type="submit">Login</button></p>
    </form>
