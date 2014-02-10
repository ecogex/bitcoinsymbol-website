<?php
function controller_admin_auth($app) {

  // Login (GET)
  $app->route('GET', '/admin/login', function() {
    $auth = get_auth();
    $data = ['admin_csrf' => $auth->csrf()];
    $this->render('login', $data, [
      'templates' => $this->get_setting('templates') . '/admin'
    ]);
  });

  // Login (POST)
  $app->route('POST', '/admin/login', function() {
    $auth = get_auth();
    if ($auth->login()) $this->redirect('/admin');
    $data = [
      'error' => 'Authentification problem, please try again.',
      'admin_csrf' => $auth->csrf(),
    ];
    $this->render('login', $data, [
      'templates' => $this->get_setting('templates') . '/admin'
    ]);
  });

  // Logout
  $app->route('GET', '/admin/logout', function() {
    $auth = get_auth();
    $auth->logout();
    $this->redirect('/');
  });
}
