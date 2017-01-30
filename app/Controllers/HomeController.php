<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:33
 */
namespace Whitecompany\Controllers;

use Slim\Views\Twig as View;
use Whitecompany\Models\Bohurt;
use Whitecompany\Models\User;

class HomeController extends Controller{


    public function index($request, $response){

        $users = User::where('name','!=','')->get();

        return $this->view->render($response, 'home.twig',[
            'users' => $users,
        ]);
    }
    
    public function getFighterDetailsForModal($request, $response, $params){

        

        $user = User::where('id',$params['userId'])->get()->first();

       

        return $this->view->render($response, 'home.twig',[
            'params' => $params,
            'user' => $user,
            
        ]);
    }
}