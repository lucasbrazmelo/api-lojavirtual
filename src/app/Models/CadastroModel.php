<?php 

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\ViaCEP;

class CadastroModel extends Model
{
    protected $table = 'cadastros';
    protected $primaryKey = 'id';
    protected $allowedFields = [
                                'id', 
                                'nome', 
                                'email',
                                'telefone',
                                'data_nascimento',
                                'cpf',
                                'cep',
                                'logradouro',
                                'bairro',
                                'estado',
                                'cidade'
                            ];
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $validationRules    = [
        'nome'              => 'required|alpha_numeric_space|max_length[255]',
        'email'             => 'required|valid_email', 
        'telefone'          => 'required|numeric|min_length[10]|max_length[14]',
        'data_nascimento'   => 'required|valid_date',
        'cpf'               => 'required|numeric|exact_length[11]', 
        'cep'               => 'required|numeric|exact_length[8]'
    ];
    //é desejável um is_unique[cadastros.email]
    //é desejável também uma validação de cpf (acredito já ter esse código pronto em algum lugar)

    protected $skipValidation     = false;
    protected $validationMessages = [
        'nome'=> [
            'alpha_space' => 'O campo Nome deve conter apenas letras e espaços.',
            'required' => 'O campo Nome é obrigatório',
            'max_length' => 'O campo Nome só pode conter 255 caracteres.'
        ],
        'email'=> [
            'valid_email' => 'Informe um Email válido',
            'required' => 'O Campo Email é obrigatório'
        ],
        'telefone'=> [
            'numeric' => 'O campo Telefone deve conter apenas números.',
            'required' => 'O campo Telefone é obrigatório',
            'max_length' => 'O campo Telefone deve conter no máximo 14 caracteres númericos.',
            'min_length' => 'O campo Telefone deve conter ao menos 11 caracteres númericos.'
        ],
        'data_nascimento'=> [
            'required' => 'O campo Data de Nascimento é obrigatório',
            'valid_date' => 'O campo Data de Nascimento não contém uma data válida'
        ],
        'cpf'=> [
            'required' => 'O campo CPF é obrigatório',
            'numeric' => 'O campo CPF deve conter apenas números.',
            'min_length' => 'O campo CEP deve conter exatamente 11 caracteres númericos.'
        ],
        'cep'=> [
            'required' => 'O campo CEP é obrigatório',
            'numeric' => 'O campo CEP deve conter apenas números.',
            'min_length' => 'O campo CEP deve conter exatamente 8 caracteres númericos.'
        ]        
    ];
	
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $beforeInsert = ['findCEP'];

    protected function findCEP(array $data) {
        $viacep = new ViaCEP();
        $viacep->find($data['data']['cep']);
        $data['data']['logradouro']= $viacep->getLogradouro();
        $data['data']['cidade']= $viacep->getLocalidade();
        $data['data']['bairro']= $viacep->getBairro();
        $data['data']['estado']= $viacep->getUf();
        return $data;
    }
}