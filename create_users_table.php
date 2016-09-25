<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$pdo->query("CREATE TABLE IF NOT EXISTS `users` (
                `id` SERIAL,
                `login` varchar(30) NOT NULL,
                `name` varchar(30) NOT NULL,
                `email` varchar(30) UNIQUE NOT NULL,
                `age` int(11) NOT NULL,
                `about` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `avatar` varchar(255) NOT NULL,
                `activate` SMALLINT (1) NOT NULL DEFAULT 0,
                `url` varchar(255) NOT NULL,
                `remember_token` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
                ) Engine=InnoDB DEFAULT CHARSET=utf8;");