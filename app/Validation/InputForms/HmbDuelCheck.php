<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 08/11/2016
 * Time: 10:05
 */
namespace Whitecompany\Validation\InputForms;

use Respect\Validation\Validator as v;

class HmbDuelCheck{

    public static function rules(){

        return[
            'catDuels' => v::notEmpty(),
            'duelWeapons' => v::notEmpty(),
            'lengthDuel' => v::alnum('.,')->notEmpty(),
            'weightDuel' => v::alnum('.,')->notEmpty(),
        ];
    }

}