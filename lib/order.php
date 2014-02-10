<?php

class Model_Order extends RedBean_SimpleModel {

  function amount_btc($amount=NULL) {
    if ($amount === NULL) return ((float)$this->amount) / 1e8;
    $this->amount = (int)(round($amount * 1e8));
    return $this->amount;
  }
}
