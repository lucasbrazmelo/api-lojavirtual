<?php

namespace App\Controllers;

use App\Models\CadastroModel;
use CodeIgniter\API\ResponseTrait;

class Cadastro extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->cadastro = new CadastroModel();
	}

	public function find($id = null)
	{
		return $this->respond(
				$id ? $this->cadastro->find($id) : $this->cadastro->findAll(), 
				200, 'Listando usuarios');
	}

	public function create()
	{
		$data = $this->getBody();
		return $this->cadastro->insert($data) ? 
										$this->respond($data, 200, 'Cadastro criado') : 
										$this->fail($this->cadastro->errors());
	}

	public function update()
	{
		$data = $this->getBody();
		return $this->cadastro->save($data) ? 
								$this->respond($data, 200, 'Cadastro salvo') : 
								$this->fail($this->cadastro->errors());
	}

	public function delete($id = null)
	{
		return $this->cadastro->delete($id) ?
								$this->respond($id, 200, 'Cadastro deletado') : 
								$this->fail($this->cadastro->errors());
	}

	private function getBody()
	{
		//se for um content-type application/json
		if (strpos($this->request->header('content-type'), 'application/json') !== false)
			return $this->request->getJSON(true, 2, 0);
		//se for um content-type multipart/form-data
		if (strpos($this->request->header('content-type'), 'multipart/form-data') !== false) {
			//casos comuns [post]
			if (!empty($this->request->getPostGet()))
				return $this->request->getPostGet();
			else
				//casos incomuns [put-multipart] - atraves do raw_data eliminando e filtrando o boundary
				return $this->getBodyBoundary();
		}
		//caso contrario
		return $this->response->setStatusCode(406, 'Content-Type inválido')->setJSON(["error" => "invalid.header content-type"]);
	}

	private function getBodyBoundary()
	{
		$raw_data = file_get_contents('php://input');
		$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
		$parts = array_slice(explode($boundary, $raw_data), 1);
		$data = array();

		foreach ($parts as $part) {
			if ($part == "--\r\n") break;
			$part = ltrim($part, "\r\n");
			list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);
			$raw_headers = explode("\r\n", $raw_headers);
			$headers = array();
			foreach ($raw_headers as $header) {
				list($name, $value) = explode(':', $header);
				$headers[strtolower($name)] = ltrim($value, ' ');
			}
			if (isset($headers['content-disposition'])) {
				preg_match(
					'/^(.+); *name="([^"]+)"(;)?/',
					$headers['content-disposition'],
					$matches
				);
				list(, $type, $name) = $matches;
				$data[$name] = substr($body, 0, strlen($body) - 2);
			}
		}

		return $data;
	}
}
