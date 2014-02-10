<?php
require_once __DIR__ . '/vendor/redbean.php';

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lib/utils.php';
require_once __DIR__ . '/lib/blockchain.php';
require_once __DIR__ . '/lib/app.php';
require_once __DIR__ . '/lib/auth.php';
require_once __DIR__ . '/lib/product.php';
require_once __DIR__ . '/lib/order.php';

R::setup('sqlite:'.DATA_DIR.'/shop.db');
R::useWriterCache(true);
// R::freeze(TRUE);

// Auth
$auth = NULL;
function get_auth() {
  global $auth;
  if ($auth === NULL) {
    $auth = new Auth(ADMIN_USER, ADMIN_PASSWORD, 'admin_csrf');
  }
  return $auth;
}
function check_auth() {
  global $app;
  $auth = get_auth();
  if (!$auth->is_logged()) {
    $app->redirect('/admin/login');
  }
}

$app = new App([
  'base_url' =>  BASE_URL,
  'templates' =>  TEMPLATES_DIR,
]);

// Include and init controllers
foreach (glob(CONTROLLERS_DIR . '/*.php') as $filename) {
  require_once $filename;
  $fn = 'controller_' . basename($filename, '.php');
  if (function_exists($fn)) {
    call_user_func($fn, $app);
  }
}

// App errors
$app->error(function() use($app) {

  // Remove the final slash if present
  $routes = $app->get_routes();
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  if (substr($uri, -1) !== '/') error_404();
  $uri_noslash = substr($uri, 0, -1);
  if (in_array($uri_noslash, $routes)) {
    $base = dirname($_SERVER['PHP_SELF']);
    $app->redirect(str_replace($base, '', $uri_noslash));
  }

  // Or 404
  error_404();
});

$app->start();
