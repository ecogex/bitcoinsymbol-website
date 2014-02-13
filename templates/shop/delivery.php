<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--tempoprary links-->
<link rel="stylesheet" href="<?= $base_url ?>css/shop.css">
<link rel="stylesheet" href="<?= $base_url ?>css/fonts.css">
</head>
<body>
    <main>
      <h1>Delivery</h1>
      <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
        <p>
          <label>
            Email (double check!):<br>
            <input name="email" type="email">
          </label>
        </p>
        <p>
          <label>
            Name:<br>
            <input name="name" type="text">
          </label>
        </p>
        <p>
          <label>
            Postal Address (complete, including the country):<br>
            <textarea name="address" cols="40" rows="10"></textarea>
          </label>
        </p>
        <p class="submit"><button type="submit">Confirm</button></p>
      </form>
    </main>
</body>
</html>
