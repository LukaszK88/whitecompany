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


class MatchesPassword extends AbstractRule{

    protected   $password,
                $temp_password;

    public function __construct($temp_password,$password){

        $this->password = $password;
        $this->temp_password = $temp_password;
    }

    public function validate($input){


        if (!empty($this->password)){

            return password_verify($input, $this->password);

        }elseif (!empty($this->temp_password)){

            return true;
        }

        return false;

    }
}