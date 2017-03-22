<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:33
 */
namespace Whitecompany\Controllers;

use Slim\Views\Twig as View;
use Whitecompany\Validation\InputForms\HmbDuelCheck;
use Whitecompany\Validation\InputForms\HmbGroupCheck;
use Whitecompany\Validation\InputForms\WmfcCheck;

class CalculatorController extends Controller{

    private $weapon,
            $weight,
            $length;
    
    
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

    //Function for group weapon check

    public function hmbGroupCheck($ruleWeight,$weaponName, $stringWeaponName){

        if(($this->weapon == $weaponName) && (($this->weight <= $ruleWeight))){

            $this->flash->addMessage('success','Great success ! You can use your '.$stringWeaponName.' in HMB');

        }elseif( $this->weapon == $weaponName ){
            // Ideal weight check
            if($this->weight > $ruleWeight ){
                $idealWeight = 'too heavy by '.abs($this->weight - $ruleWeight).' kg';
            }

            $this->flash->addMessage('error','Your '.$stringWeaponName.' does not match requirements '.$idealWeight);

        }
    }

    public function postHmbGroupCheck($request, $response){

        $validation = $this->validator->validate($request,HmbGroupCheck::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'hmbGroupCheck']));
        }

        $this->weapon = $request->getParam('groupWeapons');

        $this->weight = $request->getParam('weightGroup');

        // Sword sabre braodsword check
        $this->hmbGroupCheck(1.6,"Sabre","Single handed destruction");

        // Falchion check
        $this->hmbGroupCheck(1.8,"Falchion","Falchion");

        // Long check
        $this->hmbGroupCheck(2.5,"Long","Long");

        // TwoHanded other check
        $this->hmbGroupCheck(2,"TwoHanded","Two-Handed");

        // LongAxe other check
        $this->hmbGroupCheck(2.3,"LongAxe","Long-Axe");

        // Halberd other check
        $this->hmbGroupCheck(3,"Halberd","Halberd");

        return $response->withRedirect($this->router->pathFor('home'));
        
    }

    public function hmbDuelCheck($ruleMinLength, $ruleMaxLegth, $weaponName, $ruleMinWeight = "", $ruleMaxWeight = ""){

        if(($this->weapon == $weaponName) && (($this->weight >= $ruleMinWeight && $this->weight <= $ruleMaxWeight) && ($this->length >= $ruleMinLength && $this->length <= $ruleMaxLegth))){

            $this->flash->addMessage('success','Great success ! You can use your '.$weaponName.' in HMB');
        }elseif( $this->weapon == $weaponName ){
            // Ideal weight check
            if($this->weight < $ruleMinWeight ){
                $idealWeight = 'too light by '.abs($this->weight - $ruleMinWeight).' kg';
            }elseif ($this->weight > $ruleMaxWeight){
                $idealWeight = 'too heavy by '.abs($this->weight - $ruleMaxWeight).' kg';
            }
            //Ideal Length
            if($this->length < $ruleMinLength) {
                $idealLength = 'too short by ' . abs($this->length - $ruleMinLength) . ' cm';

            }elseif($this->length > $ruleMaxLegth){
                $idealLength = 'too long by ' . abs($this->length - $ruleMaxLegth) . ' cm';
            }
            $this->flash->addMessage('error','Your '.$weaponName.' does not match requirements '.$idealWeight.' '.$idealLength);

        }
    }

    public function postHmbDuelCheck($request, $response){

                $validation = $this->validator->validate($request,HmbDuelCheck::rules());
        
                if ($validation->fails()){

                    return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'hmbDuelCheck']));
                }

        $this->weapon = $request->getParam('duelWeapons');

        $this->weight = $request->getParam('weightDuel');

        $this->length = $request->getPAram('lengthDuel');

        // Longsword check
        $this->hmbDuelCheck(100, 135, "Longsword", 1.5, 2.3);

        // Single handed sword check
        $this->hmbDuelCheck(72, 100, "Sword", 1.3, 1.6);

        // Tournament shield check
        $this->hmbDuelCheck(0 , 75, "Shield",1 , 1);

        // Buckler check
        $this->hmbDuelCheck(0 , 35, "Buckler",1 , 1);
        
        return $response->withRedirect($this->router->pathFor('home'));
    }
}