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
    $order->confirmations = NULL;
    $order->sent = FALSE;

    $order->name = NULL;
    $order->address = NULL;
    $order->email = NULL;

    $products = [];
    $quantities = [];

    foreach ($_POST['products'] as $id => $quantity) {
      $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
      if ($quantity === FALSE || $quantity < 1) continue;
      $product = R::load('product', $id);
      if (!$product->id) continue;
      if ($quantity > (int)$product->stock) $quantity = (int)$product->stock;
      $static_product = $product->export();
      $static_product['amount_btc'] = (string)$product->amount_btc();
      $products[] = $static_product;
      $quantities[$id] = $quantity;
      $order->amount += ($product->amount * $quantity);
    }

    // No products added
    if (empty($products)) return NULL;

    $order->quantities = json_encode($quantities);
    $order->products_json = json_encode($products);

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
    global $app;

    if (!isset($_SESSION['order'])) $app->redirect('/shop');

    // Order limit
    $session_limit = 60 * 60; // 1 hour
    $elapsed_time = time() - strtotime($_SESSION['order']->created);
    if ($elapsed_time > $session_limit) {
      unset($_SESSION['order']);
      $app->redirect('/shop');
    }
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
      ['templates' => $this->get_setting('templates').'/shop']
    );
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

    // Check if each product quantity can be satisfied
    $products = [];
    $static_products = $order->products();
    foreach($static_products as $static_product) {
      $product = R::load('product', $static_product->id);
      $products[] = $product;
      $order_quantity = $order->get_quantity($product->id);
      $current_quantity = (int)$product->stock;
      if ($order_quantity > $current_quantity) { // Quantities updated
        unset($_SESSION['order']);
        die('<h1>An error occured during your order, '.
            '<a href="'.$this->get_setting('base_url').'shop">'.
            'please try again</a>.</h1>');
      }
      $product->stock = $product->stock - $order_quantity;
    }

    // Everything went fine, update the products quantities
    R::storeAll($products);

    if (!defined('DEBUG') || DEBUG === FALSE) {
      $input_address = Blockchain::receive_address($order->callback_secret);
    } else {
      $input_address = 'FAKE_API_ADDRESS';
    }

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

  $app->route('GET', '/shop/pay/(:any)', function($secret) {
    $order = R::findOne('order', 'callback_secret = ?', [$secret]);
    if (!$order || !$order->id) error_404();

    $url = parse_url($_SERVER['REQUEST_URI']);
    if (!isset($url['query']) || !$url['query']) error_404();
    parse_str($url['query'], $params);

    if (!isset($params['confirmations'])) error_404();
    $confirmations = filter_var($params['confirmations'], FILTER_VALIDATE_INT);
    if ($confirmations === FALSE) error_404();

    // Prevents multiple calls with same confirmations count
    if ($order->confirmations !== NULL && $confirmations === (int)$order->confirmations) {
      return;
    }

    $order->confirmations = $confirmations;
    R::store($order);

    $mailer = get_mailer();

    if ($confirmations >= 6) {
      // Admin email
      $admin_subject = 'An order on bitcoinsymbol.org has 6 validations';
      $mailer->send($admin_subject, ADMIN_EMAIL, 'emails/order-trusted', [
        'order' => $order,
      ]);
      die('*ok*'); // Stop API notifications

    } elseif ($confirmations === 0) {

      // Customer email
      $customer_subject = 'Order confirmation from Bitcoinsymbol.org';
      $mailer->send($customer_subject, [$order->email => $order->name], 'emails/order-confirmed', [
        'order' => $order,
      ]);

      // Admin email
      $admin_subject = 'New order on Bitcoinsymbol.org';
      $mailer->send($admin_subject, ADMIN_EMAIL, 'emails/new-order', [
        'order' => $order,
      ]);
    }
  });
}
