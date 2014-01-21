<?php

require_once __DIR__ . '/vendor/macaw.php';

function render_template($name) {
  include __DIR__ .'/templates/_header.php';
  include __DIR__ ."/templates/$name.php";
  include __DIR__ .'/templates/_footer.php';
}

Macaw::get('/', function() {
  render_template('home');
});

Macaw::get('/shop', function() {
  render_template('shop');
});

Macaw::error(function() {
  header('HTTP/1.0 404 Not Found');
  echo '<h1>404 Not Found</h1>';
});

Macaw::dispatch();
