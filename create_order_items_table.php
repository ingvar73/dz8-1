<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$pdo->query("CREATE TABLE order_item (
      purchase_order SMALLINT NOT NULL,
      order_sequence SMALLINT NOT NULL,
      quantity SMALLINT(4) UNSIGNED NOT NULL,
      status_code TINYINT(2) UNSIGNED NOT NULL,
      order_date DATE NOT NULL,
      item_due_date DATE NOT NULL,
      deliver_date DATE NOT NULL,
      last_action_date TIMESTAMP,
      PRIMARY KEY (purchase_order,order_sequence),
      KEY (status_code,order_date)
    ) Engine=InnoDB DEFAULT CHARSET=utf8;");