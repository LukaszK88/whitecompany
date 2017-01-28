<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 08/11/2016
 * Time: 10:05
 */
namespace Whitecompany\Validation\InputForms;

use Respect\Validation\Validator as v;

class UserProfile{

    public static function rules(){

        return[
            'name' => v::notEmpty()->alnum(),
            'rank' => v::notEmpty()->alpha(),
            'age' => v::notEmpty()->numeric(),
            'weight' => v::notEmpty()->numeric(),
            'quote' => v::alnum(),
            'about' => v::alnum(),

        ];
    }

}