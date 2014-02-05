<?php
require_once __DIR__ . '/lib/app.php';
require_once __DIR__ . '/lib/utils.php';
require_once __DIR__ . '/lib/auth.php';
require_once __DIR__ . '/lib/shop-data.php';

define('ADMIN_USER', 'pierre');
define('ADMIN_PASSWORD', 'abc');
define('DATA_DIR', __DIR__ . '/data');

$shop_data = new ShopData(DATA_DIR.'/shop.db');

$app = new App(array(
  'base_url' => 'http://localhost/bitcoinsymbol/',
  'templates' =>  __DIR__ . '/templates',
));

function error_404() {
  header('HTTP/1.0 404 Not Found');
  echo '<h1>404 Not Found</h1>';
  exit;
}

// Home
$app->route('GET', '/', function($app) {
  $app->render('home');
});

// Shop
$app->route('GET', '/shop', function($app) use($shop_data) {
  $products = $shop_data->get_all_products();
  $app->render('shop', array( 'products' => $products ));
});

// Shop: submit a selection of products
$app->route('POST', '/shop', function($app) use($shop_data) {
  $products = filter_post_products($shop_data->get_all_products());
  if (empty($products)) {
    $app->redirect('/shop');
  }
  // var_dump($products);
});

// Admin auth
$admin_auth = new Auth(ADMIN_USER, ADMIN_PASSWORD, 'admin_csrf');
function check_admin_auth() {
  global $app, $admin_auth;
  if (!$admin_auth->is_logged()) {
    $app->redirect('/admin/login');
  }
}

// Login (GET)
$app->route('GET', '/admin/login', function($app) use($admin_auth) {
  $data = array('admin_csrf' => $admin_auth->csrf());
  $app->render('login', $data, array(
    'templates' => __DIR__ . '/templates/admin'
  ));
});

// Login (POST)
$app->route('POST', '/admin/login', function($app) use($admin_auth) {
  if ($admin_auth->login()) $app->redirect('/admin');
  $data = array(
    'error' => 'Authentification problem, please try again.',
    'admin_csrf' => $admin_auth->csrf(),
  );
  $app->render('login', $data, array(
    'templates' => __DIR__ . '/templates/admin'
  ));
});

// Logout
$app->route('GET', '/admin/logout', function($app) use($admin_auth) {
  $admin_auth->logout();
  $app->redirect('/');
});

// Admin: index
$app->route('GET', '/admin', function($app) {
  check_admin_auth();
  $app->redirect('/admin/products');
});

// Admin: products list
$app->route('GET', '/admin/products', function($app) use($shop_data) {
  check_admin_auth();
  $data = array('logged' => TRUE);
  $data['products'] = $shop_data->get_all_products();
  if ($data['products']) {
    foreach ($data['products'] as $product) {
      $product->amount_btc = $shop_data->satoshi_to_btc($product->amount);
    }
  }
  $app->render('products', $data, array(
    'templates' => __DIR__ . '/templates/admin'
  ));
});

// Admin: add a new product
$app->route('POST', '/admin/products', function($app) use($shop_data) {
  check_admin_auth();
  $product = validate_admin_product_post();
  if ($product === NULL) { return error_404(); }
  $product['amount'] = $shop_data->btc_to_satoshi($product['amount']);
  $shop_data->add_product($product);
  $app->redirect('/admin/products');
});

// Admin: delete a product
$app->route('POST', '/admin/products/(:num)/delete', function($app, $id) use($shop_data) {
  check_admin_auth();
  $shop_data->delete_product($id);
  $app->redirect('/admin/products');
});

// Admin: update a product
$app->route('POST', '/admin/products/(:num)/update', function($app, $id) use($shop_data) {
  check_admin_auth();
  $product = validate_admin_product_post();
  if ($product === NULL) { return error_404(); }
  $product['id'] = $id;
  $product['amount'] = $shop_data->btc_to_satoshi($product['amount']);
  $shop_data->update_product($product);
  $app->redirect('/admin/products');
});

// Orders list
$app->route('GET', '/admin/orders', function($app) use($shop_data) {
  check_admin_auth();
  $data = array('logged' => TRUE);
  $data['orders'] = $shop_data->get_all_orders();
  foreach ($data['orders'] as $order) {
    $order->amount_btc = $shop_data->satoshi_to_btc($order->amount);
  }
  $app->render('orders', $data, array(
    'templates' => __DIR__ . '/templates/admin'
  ));
});

$app->error(function($app) {
  error_404();
});

$app->start();
