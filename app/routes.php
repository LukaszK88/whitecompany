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

$app->get('/error[/{param1}]','UserController:getModalErrors')->setName('get.error');

$app->get('/profile[/{userId}]','UserController:getUserProfile')->setName('get.profile.page');

$app->group('',function(){


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

    $this->post('/bohurt', 'BohurtController:postRecordBohurt')->setName('post.record.bohurt');
    $this->post('/triathlon', 'TriathlonController:postRecordTriathlon')->setName('post.record.triathlon');
    $this->post('/sword', 'SwordController:postRecordSword')->setName('post.record.sword');
    $this->post('/longsword', 'LongswordController:postRecordLongsword')->setName('post.record.longsword');
    $this->post('/polearm', 'PolearmController:postRecordPolearm')->setName('post.record.polearm');
    $this->post('/profight', 'ProfightController:postRecordProfight')->setName('post.record.profight');


    $this->post('/photo/{userId}/{param}', 'UserController:postPhotoUpload')->setName('photo');


    
})->add(new AuthMiddleware($container));

