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
        'image',
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

        return $this->hasMany(Bohurt::class);
    }
    
    public function triathlon(){

        return $this->hasMany(Triathlon::class);
    }

    public function sword(){

        return $this->hasMany(Sword::class);
    }

    public function longsword(){

        return $this->hasMany(Longsword::class);
    }

    public function polearm(){

        return $this->hasMany(Polearm::class);
    }

    public function profight(){

        return $this->hasMany(Profight::class);
    }
    
    public function achievement(){

        return $this->hasMany(Achievements::class);
    }

}