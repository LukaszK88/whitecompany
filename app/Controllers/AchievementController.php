<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 10:33
 */
namespace Whitecompany\Controllers;

use Slim\Views\Twig as View;
use Whitecompany\Models\Achievements;
use Whitecompany\Models\User;
use Whitecompany\Validation\InputForms\Achievement;

class AchievementController extends Controller{


    public function postAddAchievement($request, $response, $achievementId){

        if(empty($achievementId)){
            $achievementId = 0;
        }
        
        $validation = $this->validator->validate($request,Achievement::rules());

        if($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.profile.page',[
                'userId' => $this->auth->user()->id,
                'error' => 'achievement',
            ]));

        }

        $user = User::find($this->auth->user()->id);

        $user->achievement()->updateOrCreate(['id' => $achievementId],[
            'competition_name' => $request->getParam('competition_name'),
            'location' => $request->getParam('location'),
            'category' => $request->getParam('category'),
            'place' => $request->getParam('place'),
            'date' => $request->getParam('date'),

            ]);

        $this->flash->addMessage('success','Achievement added');

        return $response->withRedirect($this->router->pathFor('get.profile.page',['userId' => $this->auth->user()->id]));

    }

    public function getDeleteAchievement($request, $response, $achievementId){

        Achievements::where('id',$achievementId)->delete();

        $this->flash->addMessage('success','Achievement deleted');

        return $response->withRedirect($this->router->pathFor('get.profile.page',['userId' => $this->auth->user()->id]));
        
    }
    
}