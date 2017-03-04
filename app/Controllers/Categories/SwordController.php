<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 30/01/2017
 * Time: 14:49
 */

namespace Whitecompany\Controllers\Categories;

use Whitecompany\Controllers\Controller;
use Whitecompany\Models\User;
use Whitecompany\Validation\InputForms\UserRecordSword;

class SwordController extends Controller{

    public function postRecordSword($request,$response){

        $validation = $this->validator->validate($request,UserRecordSword::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'sword']));
        }

        $user = User::find($request->getParam('figterId'));



        $user->sword()->create([
            'user_id' => $request->getParam('figterId'),
            'win' =>( $request->getParam('win')),
            'loss' =>( $request->getParam('loss')),
            'points' =>( $request->getParam('win')),
        ]);

        $user->update([
            'total_points' => ($user->total_points + $request->getParam('win'))
        ]);


        return $response->withRedirect($this->router->pathFor('home'));

    }
    
}