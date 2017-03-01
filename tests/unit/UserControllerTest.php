<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 06/02/2017
 * Time: 08:26
 */
class UserControllerTest extends \PHPUnit_Framework_TestCase{


    public function testGetRequestReturnsEcho()
    {
// instantiate action
        $action = new \Whitecompany\Controllers\UserController();
// We need a request and response object to invoke the action
        $environment = \Slim\Http\Environment::mock([
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/echo',
                'QUERY_STRING'=>'foo=bar']
        );
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $response = new \Slim\Http\Response();
// run the controller action and test it
        $response = $action($request, $response, []);
        $this->assertSame((string)$response->getBody(), '{"foo":"bar"}');
    }



}