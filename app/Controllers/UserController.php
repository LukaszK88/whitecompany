<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 28/01/2017
 * Time: 08:01
 */
namespace Whitecompany\Controllers;

use Whitecompany\Validation\InputForms\UserProfile;
use Whitecompany\Models\User;

class UserController extends Controller{

    public function postProfile($request,$response){
        
        $validation = $this->validator->validate($request,UserProfile::rules());

        if ($validation->fails()){

            return $response->withRedirect($this->router->pathFor('home',['param1' => 'profileError']));
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
}
