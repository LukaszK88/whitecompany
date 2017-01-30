<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 28/01/2017
 * Time: 08:01
 */
namespace Whitecompany\Controllers;

use Whitecompany\Models\Bohurt;
use Whitecompany\Validation\InputForms\UserProfile;
use Whitecompany\Models\User;
use Whitecompany\Validation\InputForms\UserRecordBohurt;
use Whitecompany\Validation\InputForms\UserRecordTriathlon;
use Whitecompany\Validation\InputForms\UserRecordSword;

class UserController extends Controller{



    public function getProfile($request,$response, $param1){

        $users = User::where('name','!=','')->get();

        return $this->view->render($response, 'home.twig',[
            'users' => $users,
            'param1' => $param1,
        ]);
    }

    public function postProfile($request,$response){
        
        $validation = $this->validator->validate($request,UserProfile::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'profile']));
        }

        User::where('id',$this->auth->user()->id)->update([
            'name' => $request->getParam('name'),
            'rank' => $request->getParam('rank'),
            'age' => $request->getParam('age'),
            'weight' => $request->getParam('weight'),
            'quote' => $request->getParam('quote'),
            'about' => $request->getParam('about'),
            
        ]);

        $this->flash->addMessage('success','Updated your details');
        return $response->withRedirect($this->router->pathFor('home'));
    }
    
    public function postRecordBohurt($request,$response){

        $validation = $this->validator->validate($request,UserRecordBohurt::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'bohurt']));
        }

        $user = User::find($request->getParam('figterId'));



        $user->bohurt()->updateOrCreate(['user_id' => $request->getParam('figterId')],[
            'fights' =>( $user->bohurt->fights +($request->getParam('won')+$request->getParam('down')+$request->getParam('last')+$request->getParam('suicide'))),
            'down' =>( $user->bohurt->down + $request->getParam('down')),
            'last' =>( $user->bohurt->last + $request->getParam('last')),
            'won' =>( $user->bohurt->won + $request->getParam('won')),
            'suicide' =>( $user->bohurt->suicide + $request->getParam('suicide')),
            'points' =>( $user->bohurt->points + ((($request->getParam('won')*2)+$request->getParam('last'))-($request->getParam('suicide')*3))),
        ]);

        $user->update([
            'total_points' => ($user->total_points + ((($request->getParam('won')*2)+$request->getParam('last'))-($request->getParam('suicide')*3)))
        ]);


        return $response->withRedirect($this->router->pathFor('home'));
        
    }

    public function postRecordTriathlon($request,$response){

        $validation = $this->validator->validate($request,UserRecordTriathlon::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'triathlon']));
        }

        $user = User::find($request->getParam('figterId'));



        $user->triathlon()->updateOrCreate(['user_id' => $request->getParam('figterId')],[
            'win' =>( $user->triathlon->win + $request->getParam('win')),
            'loss' =>( $user->triathlon->loss + $request->getParam('loss')),
            'points' =>( $user->triathlon->points + $request->getParam('win')),
        ]);

        $user->update([
            'total_points' => ($user->total_points + $request->getParam('win'))
        ]);


        return $response->withRedirect($this->router->pathFor('home'));

    }

    public function postRecordSword($request,$response){

        $validation = $this->validator->validate($request,UserRecordSword::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'sword']));
        }

        $user = User::find($request->getParam('figterId'));



        $user->sword()->updateOrCreate(['user_id' => $request->getParam('figterId')],[
            'win' =>( $user->sword->win + $request->getParam('win')),
            'loss' =>( $user->sword->loss + $request->getParam('loss')),
            'points' =>( $user->sword->points + $request->getParam('win')),
        ]);

        $user->update([
            'total_points' => ($user->total_points + $request->getParam('win'))
        ]);


        return $response->withRedirect($this->router->pathFor('home'));

    }
}
