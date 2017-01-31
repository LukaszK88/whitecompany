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
use Whitecompany\Validation\InputForms\UserRecordProfight;

class ProfightController extends Controller{

    public function postRecordProfight($request,$response){

        $validation = $this->validator->validate($request,UserRecordProfight::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'profight']));
        }

        $user = User::find($request->getParam('figterId'));



        $user->profight()->updateOrCreate(['user_id' => $request->getParam('figterId')],[
            'win' =>( $user->profight->win + $request->getParam('win')),
            'loss' =>( $user->profight->loss + $request->getParam('loss')),
            'ko' =>( $user->profight->loss + $request->getParam('ko')),
            'points' =>( $user->profight->points + (($request->getParam('win')*3) + ($request->getParam('ko')*4) + $request->getParam('loss'))),
        ]);

        $user->update([
            'total_points' => ($user->total_points + (($request->getParam('win')*3) + ($request->getParam('ko')*4) + $request->getParam('loss')))
        ]);


        return $response->withRedirect($this->router->pathFor('home'));

    }
    
}