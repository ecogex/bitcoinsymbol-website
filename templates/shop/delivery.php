<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
    <header id="top">
      <div class="bbox">
        <h1><span class="theb copy">Ƀ</span></h1>
        <p class="description">Bitcoin deserves the right symbol.</p>
      </div>
      <div class="bbox min">
        <div class="theb">Ƀ</div>
      </div>
    </header>
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
