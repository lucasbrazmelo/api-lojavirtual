<?php

namespace App\Filters;

use App\Libraries\OAuth;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use OAuth2\Request;

class OAuthFilter implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null)
    {
        $OAuth = new OAuth();
        $OAuth_request = Request::createFromGlobals();
        if(!$OAuth->server->verifyResourceRequest($OAuth_request)){
            $OAuth->server->getResponse()->send();
            exit();
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
