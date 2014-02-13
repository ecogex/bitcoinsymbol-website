<section class="single-product">
  <h1>Product: <?= $product->name ?></h1>
  <form action="<?= $base_url ?>admin/products/<?= $product->id ?>/update" method="post">
    <p>
      <label>
      <b>Name:</b><input name="name" type="text" placeholder="Name" value="<?= $product->name ?>">
      </label>
    </p>
    <p>
      <label>
        <b>Image (relative):</b><input name="image" type="text" placeholder="i/my-image.jpg" value="<?= $product->image ?>">
      </label>
    </p>
    <p>
      <label>
        <b>Price:</b><input name="amount" type="text" placeholder="0.345" value="<?= $product->amount_btc() ?>"> BTC
      </label>
    </p>
    <p>
      <label>
        <b>Stock:</b><input name="stock" type="number" min="0" placeholder="1" value="<?= $product->stock ?>">
      </label>
    </p>
    <p>
      <label>
        <b>Description:</b><textarea name="description" type="text"><?= $product->description ?></textarea>
      </label>
    </p>
    <p><button type="submit">Update</button></p>
  </form>
</section>
