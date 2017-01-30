<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 09:40
 */

use Respect\Validation\Validator as v;

session_start();
require __DIR__ .'/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$app = new \Slim\App([

    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'db' => [
            'driver'    => 'mysql',
            'host'      => getenv('DB_HOST'),
            'Validation'  => getenv('DB_DB'),
            'database'  => getenv('DB_DB'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]
    ]

]);



$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule){
    return $capsule;
};

$container['auth'] = function($container){
    return new \Whitecompany\Auth\Auth();
};

$container['flash'] = function($container){
    return new \Slim\Flash\Messages();
};

$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/views',[
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth',[
        'check' => $container->auth->check(),
        'admin' => $container->auth->hasPermission('admin'),
        'user' => $container->auth->user()
    ]);

    $view->getEnvironment()->addGlobal('flash',$container->flash);

    
    return $view;
};



$container['validator'] = function($container){
    return new Whitecompany\Validation\Validator;
};

$container['HomeController'] = function($container){
    return new \Whitecompany\Controllers\HomeController($container);
};

$container['UserController'] = function($container){
    return new \Whitecompany\Controllers\UserController($container);
};

$container['BohurtController'] = function($container){
    return new \Whitecompany\Controllers\Categories\BohurtController($container);
};

$container['AuthController'] = function($container){
    return new \Whitecompany\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function($container){
    return new \Whitecompany\Controllers\Auth\PasswordController($container);
};

$container['csrf'] = function($container){
    return new \Slim\Csrf\Guard();
};



$app->add(new \Whitecompany\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \Whitecompany\Middleware\OldInputMiddleware($container));
$app->add(new \Whitecompany\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);


v::with('Whitecompany\\Validation\\Rules');


require __DIR__.'/../app/routes.php';