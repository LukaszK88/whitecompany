<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 08/11/2016
 * Time: 10:05
 */
namespace Whitecompany\Validation\InputForms;

use Respect\Validation\Validator as v;

class HmbGroupCheck{

    public static function rules(){

        return[
            'groupWeapons' => v::alnum('.,')->notEmpty(),
            'weightGroup' => v::alnum('.,')->notEmpty(),
        ];
    }

}