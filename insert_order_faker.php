<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);
$faker = Faker\Factory::create('ru_RU');
//$dir = 'image/';

for ($i = 0; $i < 30; $i++){
    $insertStatement = $pdo->insert(array('id'))
        ->into('orders')
        ->columns(array('date', 'product_id', 'qty', 'amount', 'customer_id'))
        ->values(array('',
            $faker->date('Y-m-d'),
            $faker->numberBetween(1, 30),
            $faker->randomDigitNotNull,
            $faker->numerify('####.##'),
            $faker->numberBetween(1, 30)
        ));

    $insertId = $insertStatement->execute(false);
}
