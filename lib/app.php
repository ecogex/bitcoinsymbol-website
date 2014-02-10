<?php
require_once __DIR__ . '/../vendor/macaw.php';

class App {

  private $settings = array();

  function __construct($settings) {
    $this->settings = $settings;
  }

  function start() {
    session_start();
    Macaw::dispatch();
  }

  function get_setting($name, $default=NULL) {
    if (isset($this->settings[$name])) {
      return $this->settings[$name];
    }
    return $default;
  }

  function route($method, $path, $callback) {
    $macaw_method = ($method === 'POST')? 'post' : 'get';
    call_user_func("Macaw::$macaw_method", $path, $callback->bindTo($this));
  }

  function get_routes() {
    return Macaw::$routes;
  }

  function redirect($location) {
    if (count($location) > 0 && $location[0] === '/') {
      if (!$this->get_setting('base_url')) {
        $host = $_SERVER['HTTP_HOST'];
        $protocol = empty($_SERVER['HTTPS'])? 'http' : 'https';
        $location = "$protocol://$host$location";
      } else {
        $location = $this->get_setting('base_url') . ltrim($location, '/');
      }
    }
    header("Location: $location");
    exit();
  }

  function error($callback) {
    Macaw::error(function() use($callback) {
      $callback($this);
    });
  }

  function render($name, $data=array(), $settings=array()) {
    $layout = !isset($settings['layout']) || $settings['layout'] === TRUE;

    if (isset($settings['templates'])) {
      $tpl_dir = $settings['templates'];
    } else {
      $tpl_dir = $this->get_setting('templates', __DIR__ . '/../templates');
    }

    $data['base_url'] = $this->get_setting('base_url', '/');

    extract($data);
    $app = $this;

    if ($layout) include "$tpl_dir/_header.php";
    include "$tpl_dir/$name.php";
    if ($layout) include "$tpl_dir/_footer.php";
  }
}
