<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Administration</title>
    <link rel="stylesheet" href="<?= $base_url ?>css/admin.css">
    <link rel="stylesheet" href="<?= $base_url ?>css/fonts.css">
  </head>
  <body>
    <header>
      <h1>Administration</h1>
    </header>
    <?php if (isset($logged) && $logged): ?>
    <nav>
      <ul>
        <li>
          <a href="<?= $base_url ?>admin/products">Products</a>
        </li>
        <li>
          <a href="<?= $base_url ?>admin/orders">Orders</a>
        </li>
      </ul>
      <?php if (isset($logged) && $logged): ?>
      <p class="logout"><a href="<?= $base_url ?>admin/logout">logout</a></p>
      <?php endif ?>
    </nav>
    <?php endif ?>
