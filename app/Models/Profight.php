<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 28/01/2017
 * Time: 17:16
 */
namespace Whitecompany\Models;


use Illuminate\Database\Eloquent\Model;
use Whitecompany\Models\User;

class Profight extends Model{

    protected $table = 'profights';

    protected $fillable=[
        'user_id',
        'win',
        'loss',
        'ko',
        'points',
    ];
    
    public function user(){

        return $this->belongsToMany(User::class);

    }
}