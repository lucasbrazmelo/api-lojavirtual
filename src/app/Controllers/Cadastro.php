<?php

namespace App\Controllers;

use App\Models\CadastroModel;

class Cadastro extends BaseController
{
    public function __construct()
    {
        $this->cadastro = New CadastroModel();
    }

    public function find($id = null)
    {
        return $this->response->setJSON(
            $id ? $this->cadastro->find($id) : $this->cadastro->findAll()
        );
    }

    public function create()
    {
        return $this->response->setJSON(
            $this->cadastro->insert($this->getBody()) ? true : $this->cadastro->errors()
        );
    }
    public function update()
    {
        return $this->response->setJSON(
            $this->cadastro->save($this->getBody()) ? true : $this->cadastro->errors()
        );
    }
    public function delete($id = null)
    {
        return $this->response->setJSON($this->cadastro->delete($id));
    }

    private function getBody(){
        if(strpos($this->request->header('content-type'),'application/json')!==false)
            return $this->request->getJSON(true,2,0);
        
        if(strpos($this->request->header('content-type'),'multipart/form-data')!==false){
            if(!empty($this->request->getPostGet()))
                return $this->request->getPostGet();
            else
                return $this->request->getJSON(true,2,0);
        }
            

        return $this->response->setStatusCode(406, 'Content-Type inválido')->setJSON(["error"=>"invalid.header content-type"]);
    }
}
