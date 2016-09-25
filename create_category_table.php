<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$pdo->query("CREATE TABLE IF NOT EXISTS `category` (
                `id` SERIAL,
                `title` varchar(30) NOT NULL,
                `table_title` varchar(30) NOT NULL,
                PRIMARY KEY (`id`)
                ) Engine=InnoDB DEFAULT CHARSET=utf8;");