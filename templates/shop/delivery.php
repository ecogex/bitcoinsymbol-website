    <header><a href="./">Back</a></header>
    <main>
      <div class="left delivery">
        <h1>Delivery</h1>
        <?php if (isset($errors)): ?>
        <div class="errors">
          <p><strong>There are some errors that you need to fix:</strong></p>
          <ul>
            <?php foreach($errors as $error): ?>
            <li><?= $error ?></li>
            <?php endforeach ?>
          </ul>
        </div>
        <?php endif ?>
        <form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
          <p>
            <label>
              Email (double check!):<br>
              <input name="email" type="email" value="<?= $email ?>" required>
            </label>
          </p>
          <p>
            <label>
              Name:<br>
              <input name="name" type="text" value="<?= $name ?>" required>
            </label>
          </p>
          <p>
            <label>
              Postal Address (complete, including the country):<br>
              <textarea name="address" cols="40" rows="10" required><?= $address ?></textarea>
            </label>
          </p>
          <p class="submit"><button type="submit">Confirm</button></p>
        </form>
      </div>
      <section class="right order">
        <h1>Order</h1>
        <ul>
        <?php foreach($order->sharedProduct as $product): ?>
        <li>
          <img src="<?= $base_url.$product->image ?>" alt="" width="100"><br>
          <?= $product->name ?>
          (<?= $order->get_quantity($product->id) ?>)
        </li>
        <?php endforeach ?>
        </ul>
        <p class="total">Total: <?= $order->amount_btc() ?> BTC</p>
      </section>
    </main>
