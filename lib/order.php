<?php

class Model_Order extends RedBean_SimpleModel {

  function amount_btc($amount=NULL) {
    if ($amount === NULL) return ((float)$this->amount) / 1e8;
    $this->amount = (int)(round($amount * 1e8));
    return $this->amount;
  }

  function get_quantity($product_id) {
    $quantities = json_decode($this->quantities, TRUE);
    if (isset($quantities[$product_id])) {
      return $quantities[$product_id];
    }
    return NULL;
  }
}
