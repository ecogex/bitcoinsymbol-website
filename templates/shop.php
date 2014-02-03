    <nav>
      <ul>
        <li><a href="http://bitcoinsymbol.org">Back to the main page</a></li>
      </ul>
    </nav>
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
            <?php foreach($products as $product): ?>
            <tr>
              <td><img src="<?= $product->image ?>"></td>
              <td>
                <input type="number"
                  style="width:60px;padding:10px;"
                  name="products[<?= $product->id ?>]"
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
