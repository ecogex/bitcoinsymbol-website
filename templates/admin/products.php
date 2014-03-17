
<h2>Products</h2>

<?php if (count($products)): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Image</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Description</th>
    <th>Actions</th>
  </tr>
  <?php foreach($products as $product): ?>
  <tr>
    <td>
      <?= $product->id ?>
    </td>
    <td>
      <?= $product->name ?>
    </td>
    <td>
      <img src="<?= $base_url ?><?= $product->image ?>">
    </td>
    <td>
      <?= $product->amount_btc() ?>
    </td>
    <td>
      <?= $product->stock ?>
    </td>
    <td>
      <?= $product->description ?>
    </td>
    <td>
      <form method="post"
        action="<?= $base_url ?>admin/products/<?= $product->id ?>/delete"
        onsubmit="return confirm('Are you sure?')">
        <div>
          <a class="edit" href="<?= $base_url ?>admin/products/<?= $product->id ?>">Edit</a><br>
          <button class="delete" type="submit">Delete</button>
        </div>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<?php else: ?>
<p>No products!</p>
<?php endif ?>

<section class="single-product">
  <h1>Add a product</h1>
  <form action="<?= $base_url ?>admin/products" method="post">
    <p><label><b>Name:</b><input name="name" type="text" placeholder="Name"></label></p>
    <p><label><b>Image (relative):</b><input name="image" type="text" placeholder="i/my-image.jpg"></label></p>
    <p><label><b>Extra image (optional):</b><input name="image2" type="text" placeholder="i/my-image.jpg"></label></p>
    <p><label><b>Price:</b><input name="amount" type="text" placeholder="0.345"> BTC</label></p>
    <p><label><b>Stock:</b><input name="stock" type="number" min="0" placeholder="1"></label></p>
    <p><label><b>Description:</b><textarea name="description" type="text"></textarea></label></p>
    <p><button type="submit">Add</button></p>
  </form>
</section>
