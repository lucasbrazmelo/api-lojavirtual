<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOAuth extends Migration {

  public function up() {
    $this->forge->addField([    
      'client_id'=>['type'=>'VARCHAR','constraint'=>'127', 'null'=>false],
      'client_secret'=>['type'=>'VARCHAR','constraint'=>'127'],
      'redirect_uri'=>['type'=>'VARCHAR','constraint'=>'2000'],
      'grant_types'=>['type'=>'VARCHAR','constraint'=>'80'],
      'scope'=>['type'=>'VARCHAR','constraint'=>'4000'],
      'user_id'=>['type'=>'VARCHAR','constraint'=>'80']
    ]);
    $this->forge->addKey('client_id', true);
    $this->forge->createTable('oauth_clients');
    
    #oauth_access_tokens
    $this->forge->addField([
      'access_token'=>['type'=>'VARCHAR' ,'constraint'=>'40','null'=>false],
      'client_id'=>['type'=>'VARCHAR','constraint'=>'80','null'=>false],
      'user_id'=>['type'=>'VARCHAR','constraint'=>'80'],
      'expires'=>['type'=>'TIMESTAMP', 'null'=>false],
      'scope'=>['type'=>'VARCHAR','constraint'=>'4095','null' => true]
    ]);
    $this->forge->addKey('access_token', true);
    $this->forge->createTable('oauth_access_tokens');

    #oauth_authorization_codes
    $this->forge->addField([
      'authorization_code'=>['type'=>'VARCHAR', 'constraint'=>'40','null'=>false],
      'client_id'=>['type'=>'VARCHAR', 'constraint'=>'80','null'=>false],
      'user_id'=>['type'=>'VARCHAR', 'constraint'=>'80'],
      'redirect_uri'=>['type'=>'VARCHAR', 'constraint'=>'2000'],
      'expires'=>['type'=>'TIMESTAMP','null'=>false],
      'scope'=>['type'=>'VARCHAR', 'constraint'=>'4000'],
      'id_token'=>['type'=>'VARCHAR', 'constraint'=>'1000'],
    ]);
    $this->forge->addKey('authorization_code', true);
    $this->forge->createTable('oauth_authorization_codes');

    $this->forge->addField([
      'refresh_token'=>['type'=>'VARCHAR','constraint'=>'40','null'=>false],
      'client_id'=>['type'=>'VARCHAR', 'constraint'=>'80','null'=>false],
      'user_id'=>['type'=>'VARCHAR', 'constraint'=>'80'],
      'expires'=>['type'=>'TIMESTAMP','null'=>false],
      'scope'=>['type'=>'VARCHAR', 'constraint'=>'4000']
    ]);
    $this->forge->addKey('refresh_token', true);
    $this->forge->createTable('oauth_refresh_tokens');

    #oauth_users
    $this->forge->addField([
      'username'=>['type'=>'VARCHAR', 'constraint' => '80'],
      'password'=>['type'=>'VARCHAR', 'constraint' => '80'],
      'first_name'=>['type'=>'VARCHAR', 'constraint' => '80'],
      'last_name'=>['type'=>'VARCHAR', 'constraint' => '80'],
      'email'=>['type'=>'VARCHAR', 'constraint' => '80'],
      'email_verified'=>['type'=>'BOOLEAN'],
      'scope'=>['type'=>'VARCHAR', 'constraint' => '4000']
    ]);
    $this->forge->addKey('username', true);
    $this->forge->createTable('oauth_users');
    
    #oauth_scopes
    $this->forge->addField([
      'scope'=>['type'=>'VARCHAR','constraint' =>'80','null'=>false],
      'is_default'=>['type'=>'BOOLEAN']
    ]);
    $this->forge->addKey('scope', true);
    $this->forge->createTable('oauth_scopes');

    $this->forge->addField([
      'client_id'=>['type'=>'VARCHAR','constraint'=>'80','null'=>false],
      'subject'=>['type'=>'VARCHAR','constraint'=>'80'],
      'public_key'=>['type'=>'VARCHAR','constraint'=>'2000','null'=>false]
    ]);
    $this->forge->addKey('client_id', true);
    $this->forge->createTable('oauth_jwt');
  }

  public function down() {
    $this->forge->dropTable('users');
    $this->forge->dropTable('oauth_clients');
    $this->forge->dropTable('oauth_access_tokens');
    $this->forge->dropTable('oauth_authorization_codes');
    $this->forge->dropTable('oauth_refresh_tokens');
    $this->forge->dropTable('oauth_scopes');
    $this->forge->dropTable('oauth_jwt');
    $this->forge->dropTable('oauth_public_keys');
  }
  
}