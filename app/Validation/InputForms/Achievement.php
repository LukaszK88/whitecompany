<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 08/11/2016
 * Time: 10:05
 */
namespace Whitecompany\Validation\InputForms;

use Respect\Validation\Validator as v;

class Achievement{

    public static function rules(){

        return[
            'competition_name' => v::notEmpty()->alnum(' '),
            'location' => v::notEmpty()->alpha(),
            'category' => v::notEmpty(),
            'place' => v::notEmpty(),
            'date' => v::date(),
            

        ];
    }

}