<?php
require "config.php";
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);
$faker = Faker\Factory::create('ru_RU');
//$dir = 'image/';

for ($i = 0; $i < 30; $i++){
    $insertStatement = $pdo->insert(array('id'))
        ->into('users')
        ->columns(array('login', 'name', 'email', 'age', 'about', 'password', 'avatar', 'activate', 'url', 'remember_token'))
        ->values(array('',
            $faker->userName,
            $faker->name,
            $faker->email,
            $faker->numberBetween(10, 100),
            $faker->realText(200),
            $faker->password(6, 20),
            $faker->imageUrl(300, 300, 'cats'),
            $faker->numberBetween(0, 1),
            $faker->url,
            $faker->sha256));

    $insertId = $insertStatement->execute(false);
}
