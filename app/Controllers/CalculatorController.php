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
use Whitecompany\Validation\InputForms\WmfcCheck;

class CalculatorController extends Controller{
    
    
    public function postWmfcCheck($request, $response){

        $validation = $this->validator->validate($request,WmfcCheck::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'wmfcCheck']));
        }
        
        $balance = $request->getParam('balance');
        $weaponWeight = $request->getParam('weight');
        
        $check = (($balance + 5) * $weaponWeight);

        $idealBalanceForTheFailedWeapon = number_format(((25.5 / $weaponWeight) - 5 ), 2, '.', ',');



        if($check < 25.5){
            $this->flash->addMessage('error','Your weapon does not meet requirements,
            for weapon weighing '.$weaponWeight.' kg , balance point needs to be '.$idealBalanceForTheFailedWeapon.'
                ');
        }if ($check >= 25.5){
            $this->flash->addMessage('success','Sweet, you can use your weapon in WMFC');
        }

        return $response->withRedirect($this->router->pathFor('home'));

    }
   
}