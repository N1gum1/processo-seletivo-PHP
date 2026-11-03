# Sistema de Processo Seletivo em PHP

Sistema web desenvolvido para cadastro e gerenciamento de candidatos em processos seletivos.

O projeto foi desenvolvido a partir de um sistema de cadastro feito anteriormente em Java. Nesta versão, a proposta foi transformar o sistema em uma aplicação web utilizando PHP, banco de dados e controle de acesso para diferentes tipos de usuários.

## Tecnologias utilizadas

- PHP 8.3
- MariaDB
- HTML5
- CSS3
- PDO
- Git e GitHub

## Funcionalidades

### Candidatos

O sistema permite:

- Cadastrar candidatos
- Listar candidatos
- Consultar informações dos candidatos
- Editar candidatos
- Excluir candidatos
- Ordenar candidatos por peso
- Definir situação do candidato
- Informar escolaridade, vaga pretendida e demais dados pessoais

Os candidatos possuem os seguintes dados:

- Nome completo
- CPF
- Data de nascimento
- E-mail
- Telefone
- Cidade
- Vaga pretendida
- Escolaridade
- Situação
- Peso

### Controle de usuários

O sistema possui dois níveis de acesso:

**Administrador**

Possui acesso completo ao sistema, podendo:

- Cadastrar candidatos
- Visualizar candidatos
- Editar candidatos
- Excluir candidatos
- Cadastrar recrutadores
- Editar recrutadores
- Excluir recrutadores
- Visualizar os usuários cadastrados

**Recrutador**

Possui acesso às funções relacionadas aos candidatos, podendo:

- Cadastrar candidatos
- Visualizar candidatos

O recrutador não possui permissão para editar ou excluir candidatos e também não possui acesso ao gerenciamento de usuários.

As permissões são verificadas tanto na interface quanto no código PHP, evitando que uma função restrita seja acessada simplesmente digitando a URL diretamente no navegador.

## Login e segurança

O acesso ao sistema é feito através de login com e-mail e senha.

As senhas não são armazenadas diretamente no banco de dados. O sistema utiliza `password_hash()` para gerar o hash da senha e `password_verify()` para validar o acesso durante o login.

As sessões do PHP são utilizadas para manter o usuário autenticado e identificar seu nível de acesso.

Além disso, as operações realizadas no banco utilizam consultas preparadas através do PDO.

## Banco de dados

O sistema utiliza MariaDB para armazenar os dados.

As principais tabelas são:

### `usuarios`

Armazena os usuários que podem acessar o sistema.

Entre os dados estão:

- ID
- Nome
- E-mail
- Senha armazenada em hash
- Perfil (`ADMIN` ou `RECRUTADOR`)
- Data de criação

### `candidatos`

Armazena os candidatos cadastrados no processo seletivo.

A estrutura possui campos para dados pessoais, informações profissionais, escolaridade, situação e peso do candidato.

## Estrutura do projeto

```text
processo-seletivo/
│
├── candidatos/
│   ├── cadastrar.php
│   ├── editar.php
│   ├── excluir.php
│   └── listar.php
│
├── usuarios/
│   ├── cadastrar.php
│   ├── editar.php
│   ├── excluir.php
│   └── listar.php
│
├── includes/
│   └── auth.php
│
├── css/
│   └── style.css
│
├── config.php
├── config.local.php
├── dashboard.php
├── index.php
├── login.php
└── logout.php
```

O arquivo `config.local.php` contém as informações de conexão com o banco de dados e não deve ser enviado para o repositório. Por isso, ele está incluído no `.gitignore`.

## Controle de permissões

| Função | Administrador | Recrutador |
|---|:---:|:---:|
| Visualizar candidatos | ✓ | ✓ |
| Cadastrar candidatos | ✓ | ✓ |
| Editar candidatos | ✓ | — |
| Excluir candidatos | ✓ | — |
| Visualizar usuários | ✓ | — |
| Cadastrar recrutadores | ✓ | — |
| Editar recrutadores | ✓ | — |
| Excluir recrutadores | ✓ | — |

## Como executar o projeto localmente

O projeto está disponível no GitHub como código-fonte e não está hospedado em um servidor público. Para executar o sistema, é necessário configurar o ambiente localmente.

Isso significa que o `localhost` utilizado durante a execução representa o computador onde o projeto foi instalado. Portanto, outra pessoa não consegue acessar o meu `localhost` pela internet.

### Requisitos

Para executar o projeto, é necessário ter:

- PHP 8.3 ou superior
- MariaDB
- Extensão PDO para MySQL
- Git (opcional, caso o projeto seja baixado pelo GitHub)

### Baixando o projeto

É possível clonar o repositório utilizando:

```bash
git clone https://github.com/N1gum1/processo-seletivo-PHP.git
```

Depois:

```bash
cd processo-seletivo-PHP
```

Também é possível baixar o projeto diretamente pelo botão **Code → Download ZIP** no GitHub.

### Configuração do banco de dados

Depois de instalar e iniciar o MariaDB, é necessário criar o banco de dados e as tabelas utilizadas pelo sistema.

Também é necessário configurar o arquivo:

```text
config.local.php
```

Exemplo:

```php
<?php

$host = '127.0.0.1';
$dbname = 'processo_seletivo';
$user = 'processo_app';
$password = 'SUA_SENHA';
```

Esse arquivo é utilizado para armazenar as informações de acesso ao banco e não deve ser enviado ao GitHub.

### Executando o sistema

Dentro da pasta do projeto, execute:

```bash
php -S localhost:8000
```

Depois, abra o navegador e acesse:

```text
http://localhost:8000/login.php
```

O sistema será executado localmente através do servidor embutido do PHP.

Cada pessoa que baixar o projeto deverá configurar seu próprio PHP, MariaDB, banco de dados e arquivo `config.local.php`. Nesse caso, o `localhost` será o computador dessa pessoa.

## Projeto

Este projeto foi desenvolvido com foco em praticar o desenvolvimento de aplicações web em PHP, integração com banco de dados, autenticação, controle de permissões e organização de um sistema CRUD.

A ideia também foi evoluir um projeto anterior feito em Java para uma aplicação web mais completa, mantendo as funcionalidades principais e adicionando novos recursos de acesso e gerenciamento.

## Autora

**N1gum1**

Projeto desenvolvido como parte do processo de desenvolvimento e aprendizado em programação.
