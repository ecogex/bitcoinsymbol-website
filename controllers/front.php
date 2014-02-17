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
    echo $this->render('home');
  });

  // Shop
  $app->route('GET', '/shop', function() {
    echo $this->render('products',
      ['products' => R::findAll('product')],
      ['templates' => $this->get_setting('templates').'/shop']);
  });

  // Shop: submit a selection of products
  $app->route('POST', '/shop', function() {
    $order = get_order();
    if ($order === NULL) $this->redirect('/shop?error=noproducts');
    $_SESSION['order'] = $order;
    $this->redirect('/shop/delivery');
  });

  // Shop
  function check_order_process() {
    if (!isset($_SESSION['order'])) $this->redirect('/shop');
    return $_SESSION['order'];
  }

  $app->route('GET', '/shop/delivery', function() {
    $order = check_order_process();
    echo $this->render('delivery', [
        'order' => $order,
        'email' => '',
        'name' => '',
        'address' => '',
      ],
      ['templates' => $this->get_setting('templates').'/shop']);
  });

  $app->route('POST', '/shop/delivery', function() {
    $order = check_order_process();

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $name = isset($_POST['name'])? trim($_POST['name']) : NULL;
    $address = isset($_POST['address'])? trim($_POST['address']) : NULL;

    $errors = [];
    if (!$email) $errors['email'] = 'You need to provide a valid email address.';
    if (!$name) $errors['name'] = 'You need to provide a name.';
    if (!$address) $errors['address'] = 'You need to provide a postal address.';

    if (!empty($errors)) {
      // $this->redirect('/shop/delivery?error');
      echo $this->render('delivery', [
          'order' => $order,
          'email' => htmlspecialchars($email),
          'name' => htmlspecialchars($name),
          'address' => htmlspecialchars($address),
          'errors' => $errors,
        ],
        ['templates' => $this->get_setting('templates').'/shop']);
      return;
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
