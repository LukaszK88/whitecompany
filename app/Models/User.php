<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:25
 */

namespace Whitecompany\Models;

use Illuminate\Database\Eloquent\Model;
use Whitecompany\Models\Bohurt;

class User extends Model{

    protected $table = 'users';
    
    protected $fillable=[
        'name',
        'username',
        'temp_password',
        'salt',
        'password',
        'role',
        'weight',
        'total_points',
    ];

    public function setTempPassword($password){

        $this->update([
            'password' => '',
            'temp_password' => md5($password)
        ]);

    }

    public function setPassword($password){
        
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'temp_password' => ''
        ]);
        
    }

    public function bohurt(){

        return $this->hasOne(Bohurt::class);
    }

}