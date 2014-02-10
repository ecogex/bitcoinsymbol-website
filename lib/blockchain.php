<?php

class Blockchain {

  static function receive_address($secret) {
    $btc_address = BITCOIN_ADDRESS;
    $root_url = 'https://blockchain.info/api/receive';
    $callback = urlencode(self::callback_url($secret));
    $params = "method=create&address=$btc_address&callback=$callback";
    try {
      $response = file_get_contents("$root_url?$params");
      $response = json_decode($response);
    } catch(Exception $e) {
      return NULL;
    }
    if (!$response) return NULL;
    return $response->input_address;
  }

  static function callback_url($secret) {
    $secret = urlencode($secret);
    return BASE_URL . "shop/paid/?secret=$secret";
  }

}
