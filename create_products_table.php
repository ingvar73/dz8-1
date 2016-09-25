<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$pdo->query("CREATE TABLE products
(id SERIAL,
description VARCHAR(100),
details TEXT,
price DECIMAL(8,2),
PRIMARY KEY (id))
ENGINE InnoDB CHARACTER SET utf8;");