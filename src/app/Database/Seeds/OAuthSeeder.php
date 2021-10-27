<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OAuthSeeder extends Seeder
{
        public function run()
        {
                $oauth_clients = [
                        'client_id' => 'admin',
                        'client_secret'    => 'f865b53623b121fd34ee5426c792e5c33af8c227',
                        'grant_types'    => 'password',
                        'scope'    => 'acessoExterno'
                ];
                $oauth_users = [
                        'username' => 'admin',
                        'password'    => 'f865b53623b121fd34ee5426c792e5c33af8c227',
                        'first_name'    => 'Administrador',
                        'last_name'    => 'do Sistema',
                        'email'    => 'admin@lojavirual.com.br',
                        'email_verified'    => 1,
                        'scope'    => 'acessoExterno'
                ];

                // Using Query Builder
                $this->db->table('oauth_clients')->insert($oauth_clients);
                $this->db->table('oauth_users')->insert($oauth_users);
        }
}