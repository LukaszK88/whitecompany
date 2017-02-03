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


    public function getModalErrors($request,$response, $param1){
        

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
        return $response->withRedirect($this->router->pathFor('get.profile.page',['userId' => $this->auth->user()->id]));
    }
    
    public function getUserProfile($request,$response,$userId){

        $user = User::find($userId)->first();

        $gold = $user->achievement()->where('place','fa fa-trophy fa-trophy-gold')->count();

        $silver = $user->achievement()->where('place','fa fa-trophy fa-trophy-silver')->count();

        $bronze = $user->achievement()->where('place','fa fa-trophy fa-trophy-bronze')->count();

        $countriesCompetedIn = $user->achievement()->orderBy('location','asc')->groupBy('location')->get();

        return $this->view->render($response, 'user/profilePage.twig',[
            'user' => $user,
           'userId' => $userId,
            'gold' => $gold,
            'silver' => $silver,
            'bronze' => $bronze,
            'countriesCompetedIn' => $countriesCompetedIn,
        ]);
    }
    
    public function postPhotoUpload($request,$response,$userId){

        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES['image']["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES['image']["tmp_name"]);
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {

                    $this->flash->addMessage('error', 'File is not an image');
                if($userId['param'] == 'photo') {

                    return $response->withRedirect($this->router->pathFor('get.profile.page', ['userId' => $this->auth->user()->id, 'error' => 'photo']));
                }elseif ($userId['param'] == 'coa'){

                    return $response->withRedirect($this->router->pathFor('get.error', ['param1' => 'coa']));
                }
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {

            $this->flash->addMessage('error', 'Sorry, file already exists');

            if($userId['param'] == 'photo') {

                return $response->withRedirect($this->router->pathFor('get.profile.page', ['userId' => $this->auth->user()->id, 'error' => 'photo']));
            }elseif ($userId['param'] == 'coa'){

                return $response->withRedirect($this->router->pathFor('get.error', ['param1' => 'coa']));
            }
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES['image']["size"] > 500000) {
            $this->flash->addMessage('error','Sorry, your file is too large.');
            if($userId['param'] == 'photo') {

                return $response->withRedirect($this->router->pathFor('get.profile.page', ['userId' => $this->auth->user()->id, 'error' => 'photo']));
            }elseif ($userId['param'] == 'coa'){

                return $response->withRedirect($this->router->pathFor('get.error', ['param1' => 'coa']));
            }
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $this->flash->addMessage('error','Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
            if($userId['param'] == 'photo') {

                return $response->withRedirect($this->router->pathFor('get.profile.page', ['userId' => $this->auth->user()->id, 'error' => 'photo']));
            }elseif ($userId['param'] == 'coa'){

                return $response->withRedirect($this->router->pathFor('get.error', ['param1' => 'coa']));
            }
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //Message::setMessage("Sorry, your file was not uploaded.","error");
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES['image']["tmp_name"], $target_file)) {
                if($userId['param'] == 'photo') {
                    User::where('id', $userId['userId'])->update([
                        'image' => '/img/' . $_FILES['image']["name"]
                    ]);
                    $this->flash->addMessage('success', 'The file ' . basename($_FILES['image']["name"]) . ' has been uploaded.');
                    return $response->withRedirect($this->router->pathFor('get.profile.page',['userId' => $this->auth->user()->id]));
                }elseif($userId['param'] == 'coa'){
                    User::where('id', $userId['userId'])->update([
                        'coa' => '/img/' . $_FILES['image']["name"]
                    ]);
                    $this->flash->addMessage('success', 'The file ' . basename($_FILES['image']["name"]) . ' has been uploaded.');
                    return $response->withRedirect($this->router->pathFor('home'));
                }
                
            } else{
                $this->flash->addMessage('error','Sorry, there was an error uploading your file.');
                if($userId['param'] == 'photo') {

                    return $response->withRedirect($this->router->pathFor('get.profile.page', ['userId' => $this->auth->user()->id, 'error' => 'photo']));
                }elseif ($userId['param'] == 'coa'){

                    return $response->withRedirect($this->router->pathFor('get.error', ['param1' => 'coa']));
                }
            }
        }
       
    }
}
