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

        //Select placement for the 1st class
        if($request->getParam('fc')== '1st'){
            $winner = 1;
        }elseif ($request->getParam('fc')== '2nd'){
            $second = 1;
        }elseif ($request->getParam('fc')== '3rd'){
            $third = 1;
        }




        $user->profight()->updateOrCreate(['user_id' => $request->getParam('figterId')],[
            'win' =>( $user->profight->win + $request->getParam('win')),
            'loss' =>( $user->profight->loss + $request->getParam('loss')),
            'fc_1' => ( $user->profight->fc_1 + $winner),
            'fc_2' => ( $user->profight->fc_2 + $second),
            'fc_3' => ( $user->profight->fc_3 + $third),
            'ko' =>( $user->profight->loss + $request->getParam('ko')),
            'points' =>( $user->profight->points + (($request->getParam('win')*3) + ($request->getParam('ko')*4) + $request->getParam('loss'))+(($winner * 10 ) + ($second*6) + ($third*3))),
        ]);

        $user->update([
            'total_points' => ($user->total_points + (($request->getParam('win')*3) + ($request->getParam('ko')*4) + $request->getParam('loss'))+(($winner * 10 ) + ($second*6) + ($third*3)))
        ]);


        return $response->withRedirect($this->router->pathFor('home'));

    }
    
}