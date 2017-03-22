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

class Polearm extends Model{

    protected $table = 'polearms';

    protected $fillable=[
        'user_id',
        'win',
        'loss',
        'points',
    ];
    
    public function user(){

        return $this->belongsToMany(User::class);

    }
}