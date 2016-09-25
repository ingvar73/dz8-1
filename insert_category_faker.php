<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);
$faker = Faker\Factory::create('ru_RU');
//$dir = 'image/';

for ($i = 0; $i < 10; $i++){
    $insertStatement = $pdo->insert(array('id'))
        ->into('category')
        ->columns(array('title', 'table_title'))
        ->values(array('',
            $faker->text(10),
            $faker->text(10),
        ));

    $insertId = $insertStatement->execute(false);
}
