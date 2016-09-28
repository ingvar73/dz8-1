<?php
require_once 'config.php';
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
    return $resp;
//    $resp->write('Hello from GET');
});

//$app->get('/users', function ($req, $resp, $options){
//    $resp->write('Hello from Users');
//});

$app->get('/users', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $selectStatement = $pdo->select()->from('users');

    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

$app->get('/users/{id}', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $user_id = $req->getAttribute('id');

    $selectStatement = $pdo->select()->from('users')->where('id', '=', $user_id);

    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

$app->post('/users', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
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
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

/***
 *  Для таблицы заказов: вывод всех, вывод одной записи, вставка / удаление
 *
 */

$app->get('/orders', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $selectStatement = $pdo->select()->from('orders');
        //->leftJoin('users', 'orders.customer_id', '=', 'users.id');

    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

$app->get('/orders/{id}', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $order_id = $req->getAttribute('id');

    $selectStatement = $pdo->select()->from('orders');
    //->leftJoin('users', 'orders.customer_id', '=', 'users.id')->where('orders.id', '=', $order_id);

    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

$app->post('/orders', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $data = $_POST;
    $action = $data['action'];

    switch ($action){
        case 'create':
            $statement = $pdo->insert(array('date', 'product_id', 'qty', 'amount', 'customer_id'))
                ->into('orders')
                ->values(array(
                    $data['date'],
                    $data['product_id'],
                    $data['qty'],
                    $data['amount'],
                    $data['customer_id']
                ));
            break;
        case 'delete':
            $statement = $pdo->delete()
                ->from('orders')
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
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

/***
*  Для таблицы товаров: вывод всех, вывод одной записи, вставка / удаление
*
*/

$app->get('/products', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $selectStatement = $pdo->select()->from('products');
    //   ->leftJoin('products', 'orders.product_id', '=', 'products.id');

    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

$app->get('/products/{id}', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $order_id = $req->getAttribute('id');

    $selectStatement = $pdo->select()->from('products');
    //->leftJoin('products', 'orders.product_id', '=', 'products.id')->where('orders.id', '=', $order_id);

    $stmt = $selectStatement->execute();
    $data = $stmt->fetch();
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

$app->post('/products', function (ServerRequestInterface $req, ResponseInterface $resp) use ($pdo){
    $data = $_POST;
    $action = $data['action'];

    switch ($action){
        case 'create':
            $statement = $pdo->insert(array('description', 'details', 'price'))
                ->into('products')
                ->values(array(
                    $data['description'],
                    $data['details'],
                    $data['price']
                ));
            break;
        case 'delete':
            $statement = $pdo->delete()
                ->from('products')
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
    return $resp->withJson($data)->withHeader('Content-Type', 'application/json; charset=utf-8');
});

$app->run();

