Dear <?= $order->name ?>,

Guess what: Your order has been confirmed!
Thank you for your support.

Now we will prepare your parcel here in Paris and send it to your place soon.
You will receive an email from us when the parcel is shipped.

Quick reminder of your order details:

<?php foreach($order->sharedProduct as $product): ?>
# <?= $product->name ?>

- Quantity: <?= $order->get_quantity($product->id) ?>

- Amount: <?= $product->amount_btc() ?> BTC

<?php endforeach ?>
# Total: <?= $order->amount_btc() ?> BTC

Your delivery details:

<?= $order->name ?>

<?= $order->address ?>


Cheers,
-- 
Nat from Bitcoinsymbol.org
http://bitcoinsymbol.org
