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
      <h1>Shop</h1>
      <p>Welcome to the shop of the Ƀ project! It accepts Bitcoin payment only.
      <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>" novalidate>
        <div class="shop-items">
          <table>
<!--
            <tr>
              <th>Product image</th>
              <th>Name and price</th>
              <th>Description</th>
              <th>Add to your order</th>
            </tr>
-->
            <?php foreach($products as $i => $product): ?>
            <tr>
              <td><img src="<?= $base_url . $product->image ?>"></td>
              <td><?= $product->name ?><br>Ƀ <?= $product->amount_btc() ?></td>
              <td><?= $product->description ?></td>
              <td>
                <input type="number"
                  class="number"
                  style="width:60px;padding:10px;"
                  name="products[<?= $i ?>]"
                  value="0"
                  min="0"
                  max="<?= $product->stock ?>">
              </td>
            </tr>
            <?php endforeach; ?>
          </table>
          <p class="submit"><button type="submit">Proceed to payment</button></p>
        </div>
      </form>
    </main>
  <script src="<?= $base_url ?>js/jquery-1.10.2.min.js"></script>
  <script src="<?= $base_url ?>js/shop.js"></script>
</body>
</html>
