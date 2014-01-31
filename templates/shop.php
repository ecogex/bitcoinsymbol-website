    <nav>
      <ul>
        <li><a href="#why">Why Ƀ?</a></li>
        <li><a href="#customize">Customize</a></li>
        <li><a href="#download">Download</a></li>
        <li><a href="#goodies">Goodies and Support</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li><a href="#about">About</a></li>
      </ul>
    </nav>
    <main>
      <section class="box">
        <div class="section-inner">
          <h1>Shop</h1>
          <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>" novalidate>
            <div class="shop-items">
              <table>
                <tr>
                  <th>Image</th>
                  <th>Number</th>
                  <th>Name</th>
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
                </tr>
                <?php endforeach; ?>
              </table>
              <p class="submit"><button type="submit">BUY</button></p>
            </div>
          </form>
        </div>
      </section>
    </main>
