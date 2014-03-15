Hey, a bunch of stuff has been ordered from Bitcoinsymbol.org.

DON’T SEND IT YET! You will receive another email when the order will reach 6 confirmations.

Order details:

<?php foreach($order->products() as $product): ?>
# <?= $product->name ?>

- Quantity: <?= $order->get_quantity($product->id) ?>

- Amount: <?= $product->amount_btc ?> BTC

<?php endforeach ?>
# Total: <?= $order->amount_btc() ?> BTC

Delivery details:

Email: <?= $order->email ?>


Name: <?= $order->name ?>


Address:
<?= $order->address ?>


-- 
Bitcoinsymbol.org
http://bitcoinsymbol.org
