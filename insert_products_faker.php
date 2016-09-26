<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);
$faker = Faker\Factory::create();
//$dir = 'image/';

for ($i = 0; $i < 30; $i++){
    $insertStatement = $pdo->insert(array('id'))
        ->into('products')
        ->columns(array('description', 'details', 'price'))
        ->values(array('',
            $faker->realText(100),
            $faker->text(200),
            $faker->numerify('####.##')
        ));

    $insertId = $insertStatement->execute(false);
}
