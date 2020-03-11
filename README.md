# Projeto QI

Projeto desenvolvido com o framework Laravel 6.2 (LTS) e PHP 7.2+.

Para ser executado é necessário um ambiente com PHP 7.2 ou superior, MySQL e Apache.
DICA: Se o ambiente a ser instalado for no Windows indico a instalação do pacote Laragon ou Xampp. Para executar os comandos no console é indicado a instalação do Git Bash (Vem incluso no Git).
O Laragon já vem com todo ambiente mínimo incluindo GIT e Composer. Se for utilizado, uma dica é adicionar os binários no PATH do sistema (http://prntscr.com/revt9n).

### Requisítos mínimos
- GIT
- Composer
- Console para executar os comandos (Git Bash ou nativo)
- Apache 2
- PHP 7.2 ou superior
- MySQL 5.7 ou superior
- Extensões PHP: OpenSSL, PDO, Tokenizer e XML

### Instalação

Para instalar, acesse via terminal a pasta root dos projetos e execute:

```sh
git clone https://github.com/jgustavo99/projeto-qi.git
```

### Composer

Após ser realizado o clone do projeto, acesse a pasta criada (projeto-qi) e execute:

```sh
composer install
```

Esse comando irá instalar todas as dependências necessárias para a execução da aplicação.

Todos os passos posteriores devem ser executados DENTRO da pasta do projeto via console.

### Configurações variáves de ambiente
Após instalar todas as dependências com o Composer, temos que copiar o arquivo .env.example para configurar as variaveis de ambiente. Após isso executar um comando para gerar a chave KEY da aplicação Laravel.

```sh
cp .env.example .env && php artisan key:generate
```

Após isso, edite o arquivo `.env` usando algum editor de código (Indicado Sublime Text ou Visual Studio Code).
- `DB_DATABASE` substitua `laravel` pelo nome do banco de dados;
- `DB_USERNAME` substitua `root` pelo usuário do banco de dados;
- `DB_PASSWORD` digite a senha de acesso ao banco de dados.
-
### Banco de dados

Após ser feito toda a configuração da aplicação no ambiente é necessário rodar as `migrations` e `seeds`. 
`Migrations` são classes que contém a estrutra das tabelas e ao serem executadas fazem a criação na base de dados
`Seeds` são classes que contém inserções de dados para testes ou para produção.

Executar:

```sh
php artisan migrate && php artisan db:seed
```

### Execução
Após ser realizado todos os passos anteriores é só acessar a pasta do projeto utilizando algum navegador. LEMBRANDO que deve ser acessado na pasta pública do projeto. Por exemplo:
`http://localhost/projeto-qi/public`

Qualquer dúvida na execução do ambiente/configuração da aplicação pode me contatar pelos canais:
- E-mail: joaogustavo.b@hotmail.com
- WhatsApp: (51) 98297-6373
