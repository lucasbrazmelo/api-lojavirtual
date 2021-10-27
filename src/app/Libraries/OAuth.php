<?php

namespace App\Libraries;

use OAuth2\GrantType\UserCredentials;
use OAuth2\Server;
use OAuth2\Storage\Pdo;

class OAuth {
    public $server;
    protected $storage;
    protected $dsn;

    protected $db_username;
    protected $db_password;

    public function __construct()
    {
        $this->dsn = 'mysql:host='.getenv('database.default.hostname').';dbname='.getenv('database.default.database').'';
        $this->db_username = getenv('database.default.username');
        $this->db_password = getenv('database.default.password');
        $this->init();
    }

    public function init(){
        $this->storage = new Pdo([
            'dsn' => $this->dsn,
            'username' => $this->db_username,
            'password' => $this->db_password
        ]);
        $this->server = new Server($this->storage);

        $this->server->addGrantType(new UserCredentials($this->storage));
    }
}