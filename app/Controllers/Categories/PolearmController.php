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
use Whitecompany\Validation\InputForms\UserRecordPolearm;

class PolearmController extends Controller{

    public function postRecordPolearm($request,$response){

        $validation = $this->validator->validate($request,UserRecordPolearm::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'polearm']));
        }

        $user = User::find($request->getParam('figterId'));



        $user->polearm()->create([
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