Your order on bitcoinsymbol.org has been confirmed!

You will receive another email to inform you that your pack has been sent.

# Order details:
<?php foreach($order->sharedProduct as $product): ?>

## <?= $product->name ?>

- Quantity: <?= $order->get_quantity($product->id) ?>

- Amount: <?= $product->amount_btc() ?> BTC

<?php endforeach ?>

## Total: <?= $order->amount_btc() ?> BTC


# Delivery details:

Name: <?= $order->name ?>


Address:
<?= $order->address ?>


-- 
bitcoinsymbol.org
