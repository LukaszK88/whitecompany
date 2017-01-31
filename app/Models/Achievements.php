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

class Achievements extends Model{

    protected $table = 'achievements';

    protected $fillable=[
        'user_id',
        'competition_name',
        'location',
        'category',
        'place',
        'date',
    ];
    
    public function user(){

        return $this->belongsToMany(User::class);

    }
}