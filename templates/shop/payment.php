    <header><a href="./delivery">Back</a></header>
    <main>
      <h1>Payment</h1>
      <p>
        Please send <strong><?= $order->amount_btc() ?>Ƀ</strong> to the following address: 
        <code class="bitcoin-address"
              data-bc-amount="<?= $order->amount_btc() ?>"
              data-bc-message="<?= $order->amount_btc() ?>Ƀ payment"
              data-bc-address="<?= $order->input_address ?>"><?= $order->input_address ?>
        </code>
      </p>
    </main>