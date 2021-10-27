<?php

namespace App\Controllers;

use App\Libraries\OAuth;
use OAuth2\Request;
use CodeIgniter\API\ResponseTrait;

class Authentication extends BaseController
{
    use ResponseTrait;
    protected $OAuth;
    protected $OAuth_request;
    protected $OAuth_respond;

    public function __construct()
    {
        $this->OAuth = new OAuth();
        $this->OAuth_request = new Request();
    }
    public function login()
    {
        $this->OAuth_respond = $this->OAuth->server->handleTokenRequest(
            $this->OAuth_request->createFromGlobals()
        );

        $code = $this->OAuth_respond->getStatusCode();
        $body = $this->OAuth_respond->getResponseBody();

        return $this->sendResponse($code, $body);
    }
    public function sendResponse($code, $body){
        if($code == 200)
        {
            return $this->respond([
                'code' => $code,
                'data' => json_decode($body),
                'authorized'=> $code
            ]);
        } 
        else
        {
            return $this->fail(json_decode($body));
        }
    }
}