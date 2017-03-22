<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 28/01/2017
 * Time: 17:15
 */
namespace Whitecompany\Controllers\Categories;

use Whitecompany\Controllers\Controller;
use Whitecompany\Models\User;
use Whitecompany\Validation\InputForms\UserRecordBohurt;

class BohurtController extends Controller{

    public function postRecordBohurt($request,$response){

        $validation = $this->validator->validate($request,UserRecordBohurt::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('get.error',['param1' => 'bohurt']));
        }

        $user = User::find($request->getParam('figterId'));

        $user->bohurt()->create([
            'user_id' => $request->getParam('figterId'),
            'fights' =>(($request->getParam('won')+$request->getParam('down')+$request->getParam('last')+$request->getParam('suicide'))),
            'down' =>($request->getParam('down')),
            'last' =>($request->getParam('last')),
            'won' =>($request->getParam('won')),
            'suicide' =>($request->getParam('suicide')),
            'points' =>(((($request->getParam('won')*2)+$request->getParam('last'))-($request->getParam('suicide')*3))),
        ]);

        $user->update([
            'total_points' => ($user->total_points + ((($request->getParam('won')*2)+$request->getParam('last'))-($request->getParam('suicide')*3)))
        ]);


        return $response->withRedirect($this->router->pathFor('home'));

    }
  
    
}