New order on bitcoinsymbol.org!

# Order details:
<?php foreach($order->sharedProduct as $product): ?>

## <?= $product->name ?>

- Quantity: <?= $order->get_quantity($product->id) ?>

- Amount: <?= $product->amount_btc() ?> BTC

<?php endforeach ?>

## Total: <?= $order->amount_btc() ?> BTC


# Customer details:

Email: <?= $order->email ?>


Name: <?= $order->name ?>


Address:
<?= $order->address ?>


-- 
bitcoinsymbol.org
