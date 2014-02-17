<?php
function controller_front($app) {

  // Filter the POST request and returns a Redbean order
  function get_order() {
    if (!isset($_POST['products']) || !is_array($_POST['products'])) {
      return NULL;
    }

    $order = R::dispense('order');
    $order->amount = 0;
    $order->created = R::isoDateTime();
    $order->input_address = NULL;
    $order->paid = NULL;

    $order->name = NULL;
    $order->address = NULL;
    $order->email = NULL;

    $quantities = [];

    foreach ($_POST['products'] as $id => $quantity) {
      $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
      if ($quantity === FALSE || $quantity < 1) continue;
      $product = R::load('product', $id);
      if (!$product->id) continue;
      $order->sharedProduct[] = $product;
      $quantities[$id] = $quantity;
      $order->amount += $product->amount;
    }

    $order->quantities = json_encode($quantities);

    // No products added
    if (!$order->sharedProduct) return NULL;

    return $order;
  }

  // Home
  $app->route('GET', '/', function() {
    $this->render('home');
  });

  // Shop
  $app->route('GET', '/shop', function() {
    $this->render('shop',
      ['products' => R::findAll('product')],
      ['layout' => FALSE]);
  });

  // Shop: submit a selection of products
  $app->route('POST', '/shop', function() {
    $order = get_order();
    if ($order === NULL) $this->redirect('/shop');
    $_SESSION['order'] = R::store($order);
    $this->redirect('/shop/delivery');
  });

  // Shop
  function check_order_process() {
    if (!isset($_SESSION['order'])) $this->redirect('/shop');
    $order = R::load('order', $_SESSION['order']);
    if (!$order->id) $this->redirect('/shop');
    return $order;
  }

  $app->route('GET', '/shop/delivery', function() {
    check_order_process();
    $this->render('shop/delivery', [], ['layout' => FALSE]);
  });

  $app->route('POST', '/shop/delivery', function() {
    $order = check_order_process();

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $name = isset($_POST['name'])? trim($_POST['name']) : NULL;
    $address = isset($_POST['address'])? trim($_POST['address']) : NULL;

    if (!$email || !$name || !$address) {
      $this->redirect('/shop/delivery?error');
    }

    $order->email = $email;
    $order->name = $name;
    $order->address = $address;
    $order->callback_secret = random_hash(CALLBACK_HASH_SEED);
    R::store($order);

    $input_address = Blockchain::receive_address($order->callback_secret);
    if ($input_address === NULL) {
      echo '<h1>There is an error with the Blockchain API, please try again.</h1>';
      return;
    }

    $order->input_address = $input_address;
    R::store($order);

    $this->redirect('/shop/payment');
  });

  $app->route('GET', '/shop/payment', function() {
    $order = check_order_process();
    echo $this->render('payment',
      ['order' => $order],
      ['templates' => $this->get_setting('templates').'/shop']);
  });
}
