<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 25/11/2016
 * Time: 11:12
 */
namespace Whitecompany\Middleware;

class GuestMiddleware extends Middleware{

    public function __invoke($request, $response, $next){

        if($this->container->auth->check()){
         
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        $response = $next($request,$response);

        return $response;
    }
}