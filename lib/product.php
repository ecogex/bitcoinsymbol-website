<?php
require_once __DIR__ . '/../vendor/redbean.php';

class Model_Product extends RedBean_SimpleModel {

  function amount_btc($amount=NULL) {
    if ($amount === NULL) return ((float)$this->amount) / 1e8;
    $this->amount = (int)(round($amount * 1e8));
    return $this->amount;
  }

  function fill_with_filtered_product($product_filtered) {
    $this->name = $product_filtered->name;
    $this->image = $product_filtered->image;
    $this->image2 = $product_filtered->image2;
    $this->stock = $product_filtered->stock;
    $this->description = $product_filtered->description;
    $this->amount_btc($product_filtered->amount);
  }
}
