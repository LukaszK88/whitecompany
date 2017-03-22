<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 08/11/2016
 * Time: 10:05
 */
namespace Whitecompany\Validation\InputForms;

use Respect\Validation\Validator as v;

class UserRecordBohurt{

    public static function rules(){

        return[
            'won' => v::numeric(),
            'last' => v::numeric(),
            'down' => v::numeric(),
            'suicide' => v::numeric(),

        ];
    }

}