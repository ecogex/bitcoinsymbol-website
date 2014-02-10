<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
    <header id="top">
      <div class="bbox">
        <h1><span class="theb copy">Ƀ</span></h1>
        <p class="description">Bitcoin deserves the right symbol.</p>
      </div>
      <div class="bbox min">
        <div class="theb">Ƀ</div>
      </div>
    </header>
    <main>
      <h1>Payment</h1>
      <p>
        Please send <strong><?= $order->amount_btc() ?> BTC</strong> to:
        <?= $order->input_address ?>
      </p>
    </main>
</body>
</html>
