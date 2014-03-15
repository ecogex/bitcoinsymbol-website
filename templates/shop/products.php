    <header><a href="./">Back to Bitcoin Symbol</a></header>
    <main>
      <h1>Shop</h1>
      <p>Welcome to the shop of the Ƀ project! Here you can pay only with Bitcoin.
      <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
        <div class="shop-items">
          <table>
            <?php foreach($products as $i => $product): ?>
            <tr<?php if ($product->stock == 0) echo ' class="no-stock"' ?>>
              <td><img src="<?= $base_url . $product->image ?>"></td>
              <td><?= $product->name ?><br>Ƀ <?= $product->amount_btc() ?></td>
              <td>
                <?= $product->description ?><br>
                <small>(<?= $product->stock ?> in stock)</small>
              </td>
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
