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
    $route_callback = function() use($callback) {
      $args = func_get_args();
      array_unshift($args, $this);
      call_user_func_array($callback, $args);
    };
    if ($method === 'POST') {
      Macaw::post($path, $route_callback);
    } else {
      Macaw::get($path, $route_callback);
    }
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
    if (isset($settings['templates'])) {
      $tpl_dir = $settings['templates'];
    } else {
      $tpl_dir = $this->get_setting('templates', __DIR__ . '/../templates');
    }

    $data['base_url'] = $this->get_setting('base_url', '/');

    extract($data);
    $app = $this;
    include "$tpl_dir/_header.php";
    include "$tpl_dir/$name.php";
    include "$tpl_dir/_footer.php";
  }
}
