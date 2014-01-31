
<h2>Orders</h2>

<?php if (count($orders)): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Date</th>
    <th>Products</th>
    <th>Amount</th>
  </tr>
  <?php foreach($orders as $order): ?>
  <tr>
    <td><?= $order->id ?></td>
    <td><?= $order->date ?></td>
    <td><?= $order->products ?></td>
    <td></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php else: ?>
<p>No orders!</p>
<?php endif ?>
