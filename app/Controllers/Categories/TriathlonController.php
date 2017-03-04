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
use Whitecompany\Validation\InputForms\UserRecordTriathlon;

class TriathlonController extends Controller{

    public function postRecordTriathlon($request,$response){

        $validation = $this->validator->validate($request,UserRecordTriathlon::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'triathlon']));
        }

        $user = User::find($request->getParam('figterId'));

        $user->triathlon()->create([
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