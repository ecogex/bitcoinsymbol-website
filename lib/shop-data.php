<?php

class ShopData {
  private $pdo;

  function __construct($db_file) {
    $this->pdo = $this->get_pdo('sqlite:'.$db_file);
    $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $this->create_structure_if_not_exists();
  }

  function btc_to_satoshi($amount) {
    return (int)(round($amount * 1e8));
  }

  function satoshi_to_btc($amount) {
    return ((float)$amount) / 1e8;
  }

  function get_all_products() {
    $st = $this->pdo->prepare("SELECT id, name, image, amount, stock, description FROM products");
    $st->execute();
    return $st->fetchAll();
  }

  function get_all_orders() {
    $st = $this->pdo->prepare("SELECT id, products, date, amount FROM orders");
    $st->execute();
    return $st->fetchAll();
  }

  function update_product($product) {
    $sql = 'UPDATE products SET '.
           'name=:name, image=:image, amount=:amount, stock=:stock, description=:description '.
           'WHERE id=:id';
    $st = $this->pdo->prepare($sql);
    return $st->execute(array(
      ':id' => $product['id'],
      ':name' => $product['name'],
      ':image' => $product['image'],
      ':amount' => $product['amount'],
      ':stock' => $product['stock'],
      ':description' => $product['description'],
    ));
  }

  function add_product($product) {
    $sql = 'INSERT INTO products (name, image, amount, stock, description) '.
           'VALUES (:name, :image, :amount, :stock, :description)';
    $st = $this->pdo->prepare($sql);
    return $st->execute(array(
      ':name' => $product['name'],
      ':image' => $product['image'],
      ':amount' => $product['amount'],
      ':stock' => $product['stock'],
      ':description' => $product['description'],
    ));
  }

  function delete_product($id) {
    $sql = 'DELETE FROM products WHERE id=:id';
    $st = $this->pdo->prepare($sql);
    return $st->execute(array(
      ':id' => $id,
    ));
  }

  function create_structure_if_not_exists() {
    try {
      $this->pdo->query("SELECT 1 FROM orders LIMIT 1");
    } catch (Exception $e) {
      $this->create_structure();
    }
  }

  function create_structure() {
    $this->pdo->exec("CREATE TABLE products (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      name TEXT,
      image TEXT,
      amount INTEGER,
      stock INTEGER,
      description TEXT
    )");
    $this->pdo->exec("CREATE TABLE orders (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      products TEXT,
      date TEXT,
      amount INTEGER,
      status TEXT
    )");
  }

  function get_pdo($dsn) {
    return new PDO($dsn, NULL, NULL, array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ));
  }
}
