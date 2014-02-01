<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Administration</title>
    <link rel="stylesheet" href="<?= $base_url ?>css/admin.css">
  </head>
  <body>
    <header>
      <h1>Administration</h1>
      <?php if (isset($logged) && $logged): ?>
      <p><a href="<?= $base_url ?>admin/logout">logout</a></p>
      <?php endif ?>
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
    </nav>
    <?php endif ?>
