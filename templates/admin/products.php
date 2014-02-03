
<h2>Products</h2>

<?php if (count($products)): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Image</th>
    <th>Amount</th>
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
      <div class="normal">
        <?= $product->name ?>
      </div>
      <div class="edit">
        <input type="text" name="name" value="<?= $product->name ?>">
      </div>
    </td>
    <td>
      <div class="normal">
        <img src="<?= $base_url ?><?= $product->image ?>">
      </div>
      <div class="edit">
        <input type="text" name="image" value="<?= $product->image ?>">
      </div>
    </td>
    <td>
      <div class="normal">
        <?= $product->amount_btc ?>
      </div>
      <div class="edit">
        <input type="text" name="amount" value="<?= $product->amount_btc ?>">
      </div>
    </td>
    <td>
      <div class="normal">
        <?= $product->stock ?>
      </div>
      <div class="edit">
        <input type="number" min="0" name="stock" value="<?= $product->stock ?>">
      </div>
    </td>
    <td>
      <div class="normal">
        <?= $product->description ?>
      </div>
      <div class="edit">
        <input type="text" name="description" value="<?= $product->description ?>">
      </div>
    </td>
    <td>
      <div class="normal">
        <form method="post"
          action="<?= $base_url ?>admin/products/<?= $product->id ?>/delete"
          onsubmit="return confirm('Are you sure?')">
          <div>
            <button type="button" class="edit">Edit</button>
            <button type="submit">Delete</button>
          </div>
        </form>
      </div>
      <div class="edit">
        <form method="post" class="update"
          action="<?= $base_url ?>admin/products/<?= $product->id ?>/update">
          <input name="name" type="hidden">
          <input name="image" type="hidden">
          <input name="amount" type="hidden">
          <input name="stock" type="hidden">
          <input name="description" type="hidden">
          <button type="submit" class="save">Save</button>
          <button type="button" class="cancel">Cancel</button>
        </form>
      </div>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<?php else: ?>
<p>No products!</p>
<?php endif ?>

<form action="<?= $base_url ?>admin/products" method="post" class="new-product">
  <h2>Add a new product:</h2>
  <p><label><b>Name:</b><input name="name" type="text" placeholder="Name"></label></p>
  <p><label><b>Image (relative):</b><input name="image" type="text" placeholder="i/my-image.jpg"></label></p>
  <p><label><b>Amount:</b><input name="amount" type="text" placeholder="0.345"> BTC</label></p>
  <p><label><b>Stock:</b><input name="stock" type="number" min="0" placeholder="1"></label></p>
  <p><label><b>Description:</b><textarea name="description" type="text"></textarea></label></p>
  <p><button type="submit">Add</button></p>
</form>
