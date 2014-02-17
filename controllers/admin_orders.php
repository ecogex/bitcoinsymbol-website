<?php
function controller_admin_orders($app) {

  // Orders list
  $app->route('GET', '/admin/orders', function() {
    check_auth();
    $data = ['logged' => TRUE];
    $data['orders'] = R::findAll('order', 'ORDER BY created DESC');
    echo $this->render('orders', $data, [
      'templates' => $this->get_setting('templates').'/admin'
    ]);
  });
}
