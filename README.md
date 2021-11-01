# API LOJAVITUAL

## Recursos utilizados

PHP / Codeigniter 4 / MySQL / Phpmyadmin /  Docker / API ViaCep

O Codeigniter implementa os PSRs 1, 2, 3, 4, 6, 7 e 16. A métodologia mvc implementa um nível ideal de clareza e limpeza de código.

### Inicialização
    
    $ docker-container up

 Entrar no container web para executar migrate e seed oauth admin
    
    $ docker exec -it <conteiner web> bash
    
    # php spark migrate
    # php spark db:seed OAuthSeeder
    
 Para resgatar o token de autenticação:
 
    requesição POST
    url: https://localhost:8000/
    autorization: basic auth
       username: admin
       password: admin123
    body: x-www-form-urlencoded
      params:
        grant_type:password
        username:admin
        password:admin123
        
 
 É esperado um response json no formato abaixo
 
     {
      "code": 200,
      "data": {
          "access_token": "c9521b62f0a569c819aed3eefa643728f7c699c5",
          "expires_in": 3600,
          "token_type": "Bearer",
          "scope": "acessoExterno",
          "refresh_token": "6b2ffeed38afdca485d5c07350980b0753f883fb"
        },
      "authorized": 200
     }
 
 O "access_token" deve ser usado como Bearer Token para acessar os recursos da api. O "token_refresh" também está descrito do retorno.

### Cadastos
#### Inserir cadastro

    post para https://localhost:8000/user

    {
        "nome":"Nome Completo",         #obrigatorio, somente alfanumerios
        "email":"email@email.com",      #obrigatorio, email valido
        "telefone":"9999999999999",     #obrigatorio, somente numeros
        "data_nascimento":"yyyy-mm-dd", #obrigatorio, formado date válido
        "cpf":"999999999999",            #obrigatorio, somente numeros
        "cep":"99999999"                #obrigatorio, somente numeros
    }

#### Editar cadastro
  Diferentemente da insersão, o update aceita o envio de apenas um campo para alteração, porém o id do usuário é obrigatório.
    
    put para https://localhost:8000/user
    
    {
        "id": 1                  #obrigatorio, numero inteiro
        "nome":"Nome Completo"   ...
    }
### Listar
  
  Pode listar todos os cadastros ou listar apenas um passando o id por url
    
    get para https://localhost:8000/user[/id]

    
    
#### Spoofing de método HTTP
O protocolo http utilizado nos browsers só implementa get e post. Mas é possível utilizar um campo input em um form html para determinar o uso da rota para update (put).
https://codeigniter.com/user_guide/incoming/methodspoofing.html


      
 
