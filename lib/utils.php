<?php

function error_generic($message, $status=500,
                       $status_message='Internal Server Error') {
  header("HTTP/1.0 $status $status_message");
  echo "<h1>$message</h1>";
  exit;
}

function error_404() {
  header('HTTP/1.0 404 Not Found');
  echo '<h1>404 Not Found</h1>';
  exit;
}

function random_hash($seed) {
  return sha1(uniqid($seed . mt_rand(), TRUE));
}

function btc_to_satoshi($amount) {
  return (int)(round($amount * 1e8));
}

function satoshi_to_btc($amount) {
  return ((float)$amount) / 1e8;
}

function validate_fields_exist($container, $fields) {
  foreach ($fields as $field) {
    if (!isset($container[$field]) || $container[$field] === '') {
      return FALSE;
    }
  }
  return TRUE;
}

function validate_admin_product_post() {
  $fields = [ 'name', 'image', 'image2', 'description', 'amount', 'stock' ];
  if(!validate_fields_exist($_POST, $fields)) return NULL;

  $product = [];
  $product['name'] = $_POST['name'];
  $product['image'] = $_POST['image'];
  $product['image2'] = $_POST['image2'];
  $product['description'] = $_POST['description'];

  $product['amount'] = filter_input(
    INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT,
    FILTER_FLAG_ALLOW_FRACTION);

  $product['stock'] = filter_input(
    INPUT_POST, 'stock', FILTER_VALIDATE_INT, ['min_range' => 0]);

  if ($product['stock'] === FALSE) $product['stock'] = 0;
  if ($product['amount'] < 0) $product['amount'] = 0;

  return (object)$product;
}
