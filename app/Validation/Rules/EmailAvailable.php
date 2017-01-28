<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 25/11/2016
 * Time: 09:29
 */

namespace Whitecompany\Validation\Rules;

use Whitecompany\Models\User;
use Respect\Validation\Rules\AbstractRule;


class EmailAvailable extends AbstractRule{

    public function validate($input){

        return User::where('username',$input)->count()===0;


    }
}