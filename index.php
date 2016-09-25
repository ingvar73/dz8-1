<?php
require_once 'config.php';
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\App;

//$app->config('debug', true);
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$app->get('/', function ($req, $resp, $options){
    $resp->write('Hello from GET');
});

//$app->get('/users', function ($req, $resp, $options){
//    $resp->write('Hello from Users');
//});

$app->get('/user', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $selectStatement = $pdo->select()->from('users');

    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');

});

$app->get('/user/{id}', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $user_id = $req->getAttribute('id');

    $selectStatement = $pdo->select()->from('users')->where('id', '=', $user_id);

    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    echo $user_id;
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');
});



$app->run();