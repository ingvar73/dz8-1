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

$app->get('/order', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $selectStatement = $pdo->select()->from('orders')->leftJoin('users', 'orders.customer_id', '=', 'users.id');

    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');
});

$app->get('/order/{id}', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $order_id = $req->getAttribute('id');

    $selectStatement = $pdo->select()->from('orders')->leftJoin('users', 'orders.customer_id', '=', 'users.id')->where('orders.id', '=', $order_id);

    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');
});

$app->post('/user', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $data = $_POST;
    $action = $data['action'];

    switch ($action){
        case 'create':
                $statement = $pdo->insert(array('login', 'name'))
                    ->into('users')
                    ->values(array($data['login'], $data['name']));
            break;
        case 'delete':

            break;
    }

    $stmt = $statement->execute();
    if ($stmt){
        $success = true;
    } else{
        $success = false;
    }

    $data = array('success' => $success);
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');

});

$app->run();