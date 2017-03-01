<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 16:18
 */

namespace Whitecompany\Middleware;

class OldInputMiddleware extends Middleware{


    public function __invoke($request, $response, $next)
    {
        if(!empty($_SESSION['old'])){
            $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);

            $_SESSION['old'] = $request->getParams();
        }
        $response = $next($request,$response);

        return $response;
    }
}