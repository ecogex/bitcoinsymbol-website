<?php

function validate_admin_product_post() {
  $results = array();
  if (empty($_POST['name'])) return NULL;
  if (empty($_POST['image'])) return NULL;
  if (empty($_POST['description'])) return NULL;
  $results['name'] = $_POST['name'];
  $results['image'] = $_POST['image'];
  $results['description'] = $_POST['description'];
  if (filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT) === FALSE) {
    return NULL;
  }
  $results['amount'] = filter_input(INPUT_POST, 'amount',
                                    FILTER_SANITIZE_NUMBER_FLOAT,
                                    FILTER_FLAG_ALLOW_FRACTION);
  $results['stock'] = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT,
                                   array('min_range' => 0));
  if ($results['stock'] === FALSE) $results['stock'] = 0;
  if ($results['amount'] < 0) $results['amount'] = 0;
  return $results;
}

function filter_post_products($all_products) {
  $prd_quantities_filtered = array();
  $prd_quantities = filter_input(INPUT_POST, 'products', FILTER_VALIDATE_INT,
                                 FILTER_REQUIRE_ARRAY);
  $prd_quantities = array_slice($prd_quantities, 0, count($all_products));
  foreach($prd_quantities as $quantity) {
    if (!isset($all_products[$product_id])) break;
    if ($quantity === FALSE) continue;
    if ($quantity < 1) continue;
    if ($quantity > $all_products[$product_id]->stock) continue;
    $prd_quantities_filtered[] = (object)array(
      'id' => $product_id,
      'quantity' => $quantity,
    );
  }
  return $prd_quantities_filtered;
}
