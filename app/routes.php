<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 09:54
 */

use Whitecompany\Middleware\AuthMiddleware;
use Whitecompany\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('',function(){

    $this->get('/error[/{param1}]','UserController:getProfile')->setName('get.error');

    $this->post('/auth/signup', 'AuthController:postSignUp')->setName('auth.signup');

    $this->post('/auth/signin', 'AuthController:postSignIn')->setName('auth.signin');

    $this->get('/auth/password/forgot', 'PasswordController:getForgotPassword')->setName('auth.password.forgot');
    $this->post('/auth/password/forgot', 'PasswordController:postForgotPassword');

})->add(new GuestMiddleware($container));

    $app->group('',function(){
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');



    $this->post('/', 'UserController:postProfile')->setName('post.profile');
        
        $this->post('/record', 'UserController:postRecordBohurt')->setName('post.record.bohurt');


    
})->add(new AuthMiddleware($container));

