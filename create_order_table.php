<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$pdo->query("CREATE TABLE orders
    (id SERIAL,
    date DATE,
    product_id BIGINT UNSIGNED NOT NULL,
    qty INT UNSIGNED,
    amount DECIMAL(10,2),
    customer_id BIGINT UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES products (id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES users (id)
    ON DELETE RESTRICT ON UPDATE CASCADE)
    ENGINE InnoDB CHARACTER SET utf8;");