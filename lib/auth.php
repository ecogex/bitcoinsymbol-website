<?php
require_once __DIR__ . '/../vendor/nocsrf.php';

class Auth {
  private $username = NULL;
  private $password = NULL;
  private $csrf_id = NULL;

  function __construct($username, $password, $csrf_id) {
    $this->username = $username;
    $this->password = $password;
    $this->csrf_id = $csrf_id;
  }

  function csrf() {
    return NoCSRF::generate($this->csrf_id);
  }

  function is_logged() {
    return isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === TRUE;
  }

  function login() {
    if (isset($_POST['username']) && $_POST['username'] === $this->username &&
        isset($_POST['password']) && $_POST['password'] === $this->password &&
        NoCSRF::check($this->csrf_id, $_POST, FALSE)) {
      $_SESSION['is_logged'] = TRUE;
      return TRUE;
    }
    return FALSE;
  }

  function logout() {
    session_destroy();
  }
}
