<h2>Orders</h2>

<?php $fields = [
  'created',
  'amount',
  'input_address',
  'confirmations',
  'shipped',
  'email',
  'name',
  'address',
  'quantities',
] ?>

<?php if (count($orders)): ?>
<table>
  <tr>
    <?php foreach($fields as $field): ?>
    <th><?= $field ?></th>
    <?php endforeach ?>
  </tr>
  <?php foreach($orders as $order): ?>
  <tr>
    <?php foreach($fields as $field): ?>
    <?php if ($field === 'amount'): ?>
    <td title="<?= $order->amount ?> Satoshis"><?= $order->amount_btc() ?>Ƀ</td>
    <?php elseif ($field === 'shipped'): ?>
    <td>
      <?php if ($order->sent): ?>
      Yes
      <?php else:
      $order_id = $order->id;
      ?>
      <form action="<?= "${base_url}admin/orders/${order_id}/send" ?>" method="post">
      No <button class="table-btn" type="submit" onclick="return confirm('Sure? (<?= $order->confirmations ?> confirmations)')">Shipped?</button>
      </form>
      <?php endif ?>
    </td>
    <?php elseif ($field === 'quantities'): ?>
    <td>
    <?php
      $quantities = json_decode($order->quantities);
      $i = 0;
      foreach($quantities as $prd_id => $quantity): ?>
      <?php $product = R::load('product', $prd_id) ?>
      <?php if ($i > 0) echo ', ' ?>
      <a href="<?= "${base_url}admin/products/$prd_id" ?>"
         title="<?= $product->name ?>">
        <?= "{$product->name} ($quantity)" ?>
      </a>
    <?php $i++; endforeach ?>
    </td>
    <?php elseif ($field === 'confirmations'): ?>
    <td title="<?= Blockchain::callback_url($order->callback_secret) ?>"><?= $order->confirmations === NULL? 'nil' : $order->confirmations ?></td>
    <?php else: ?>
    <td><?= $order->$field ?></td>
    <?php endif ?>
    <?php endforeach ?>
  </tr>
  <?php endforeach; ?>
</table>
<?php else: ?>
<p>No orders!</p>
<?php endif ?>
