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
      <h1>Shop</h1>
      <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>" novalidate>
        <div class="shop-items">
          <table>
            <tr>
              <th>Image</th>
              <th>Number</th>
              <th>Name</th>
              <th>Description</th>
            </tr>
            <?php foreach($products as $i => $product): ?>
            <tr>
              <td><img src="<?= $base_url . $product->image ?>"></td>
              <td>
                <input type="number"
                  style="width:60px;padding:10px;"
                  name="products[<?= $i ?>]"
                  value="0"
                  min="0"
                  max="<?= $product->stock ?>">
              </td>
              <td><?= $product->name ?></td>
              <td><?= $product->description ?></td>
            </tr>
            <?php endforeach; ?>
          </table>
          <p class="submit"><button type="submit">BUY</button></p>
        </div>
      </form>
    </main>
</body>
</html>
