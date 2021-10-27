<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCadastros extends Migration
{
    public function up()
    {   
    /*  - Nome
        - Email
        - Data de nascimento
        - Telefone
        - CPF
        - Endereco (logradouro, bairro, cidade, estado, cep) `Para o endereço, a única entrada deverá ser o CEP, os outros campos deverão ser preenchidos utilizando a API do ViaCEP.`
        - Data de cadastro (Controlado pelo sistema)
        - Data de atualização (Controlado pelo sistema) 
    */
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome'       => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'data_nascimento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'cpf' => [
                'type'       => 'VARCHAR',
                'constraint' => '11',
            ],
            'cep' => [
                'type'       => 'VARCHAR',
                'constraint' => '8',
            ],
            'logradouro'       => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'bairro'       => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cidade'       => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estado' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
            ],
            'created_at'       => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'       => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cadastros');
    }

    public function down()
    {
        $this->forge->dropTable('cadastros');
    }
}
