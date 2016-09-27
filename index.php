<?php
require_once 'config.php';
header('Content-Type: application/json');
session_start();
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/assets/templates', [
        'cache' => false
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

//$app->config('debug', true);
$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$app->get('/', function ($req, $resp, $options){
    return $this->view->render($resp, 'layout.twig', ['title' => 'Главная страница']);
//    $resp->write('Hello from GET');
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
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');
});

$app->post('/user', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $data = $_POST;
    $action = $data['action'];

    switch ($action){
        case 'create':
                $statement = $pdo->insert(array('login', 'name', 'email', 'age', 'about', 'password'))
                    ->into('users')
                    ->values(array(
                        $data['login'],
                        $data['name'],
                        $data['email'],
                        $data['age'],
                        $data['about'],
                        $data['password']
                    ));
            break;
        case 'delete':
            $statement = $pdo->delete()
                ->from('users')
                ->where('id', '=', $data['id']);
            break;
    }

    $stmt = $statement->execute();

    if ($stmt){
        $success = true;
    } else{
        $success = false;
    }

    $data = array('success' => $success);
//    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');

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

$app->get('/product', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $selectStatement = $pdo->select()->from('orders')->leftJoin('products', 'orders.product_id', '=', 'products.id');

    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');
});

$app->get('/product/{id}', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $order_id = $req->getAttribute('id');

    $selectStatement = $pdo->select()->from('orders')->leftJoin('products', 'orders.product_id', '=', 'products.id')->where('orders.id', '=', $order_id);

    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json');
});

$app->run();

