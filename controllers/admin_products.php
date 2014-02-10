<?php
function controller_admin_products($app) {

  // Redirect the admin index ond the products list
  $app->route('GET', '/admin', function() {
    check_auth();
    $this->redirect('/admin/products');
  });

  // Products list
  $app->route('GET', '/admin/products', function() {
    check_auth();
    $data = [ 'logged' => TRUE, 'products' => R::findAll('product') ];
    $this->render('products', $data, [
      'templates' => $this->get_setting('templates').'/admin'
    ]);
  });

  // Add a new product
  $app->route('POST', '/admin/products', function() {
    check_auth();
    $product_filtered = validate_admin_product_post();
    if ($product_filtered === NULL) return error_404();

    // DB saving
    $product = R::dispense('product');
    $product->fill_with_filtered_product($product_filtered);
    R::store($product);

    $this->redirect('/admin/products');
  });

  // Single product
  $app->route('GET', '/admin/products/(:num)', function($id) {
    check_auth();
    $product = R::load('product', $id);
    if (!$product->id) $this->redirect('/admin/products');

    $data = [ 'logged' => TRUE, 'product' => $product ];
    $this->render('product', $data, [
      'templates' => $this->get_setting('templates').'/admin'
    ]);
  });

  // Update a product
  $app->route('POST', '/admin/products/(:num)/update', function($id) {
    check_auth();
    $product_filtered = validate_admin_product_post();
    if ($product_filtered === NULL) return error_generic('Error: go back and check the fields again.');

    // DB saving
    $product = R::load('product', $id);
    $product->fill_with_filtered_product($product_filtered);
    R::store($product);

    $this->redirect('/admin/products');
  });

  // Delete a product
  $app->route('POST', '/admin/products/(:num)/delete', function($id) {
    check_auth();
    $product = R::load('product', $id);
    R::trash($product);
    $this->redirect('/admin/products');
  });
}
