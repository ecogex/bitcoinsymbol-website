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

  $app->route('POST', '/admin/orders/(:num)/send', function($id) {
    check_auth();

    $order = R::load('order', $id);
    if ($order->id === 0) error_404();
    $data = ['order' => $order];

    if ($order->sent) {
      $this->redirect('/admin/orders');
    }

    $mailer = get_mailer();
    $subject = 'Order shipped - Bitcoinsymbol.org';
    $mailer->send($subject, [$order->email => $order->name], 'emails/order-sent', $data);
    $order->sent = TRUE;
    R::store($order);
    $this->redirect('/admin/orders');
  });
}
