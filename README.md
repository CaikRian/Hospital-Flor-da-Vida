# Hospital Flor da Vida

## Logo

  <img src="assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" alt="Logo do Hospital" width="50%"/>

# Sistema de Gestão de Consultas Médicas - HOSPITAL FLOR DA VIDA

Este é um sistema de gestão de consultas médicas, desenvolvido para realizar o agendamento de consultas, cadastro de pacientes, médicos e administradores, utilizando PHP e MySQL. O projeto foi configurado para ser rodado localmente em um servidor Apache com o XAMPP.

## Descrição
Trabalho feito para a materia de: *Desenvolvimento de Software para Web*

Período: Noturno

Professor: Gerson Gazola

Aluno: Caik Rian Gadelha Vieira

R.A: 2110810

Este é um site fictício criado para demonstrar um sistema de cadastro de pacientes para um hospital. O site é focado em fornecer uma interface intuitiva para que os médicos possam registrar e gerenciar informações dos pacientes, agendamentos, exames e diagnósticos.


## Tecnologias Utilizadas

- PHP
- MySQL
- XAMPP (Apache + MySQL)
- phpMyAdmin (para gerenciamento do banco de dados)

## Requisitos

Antes de iniciar, é necessário ter as seguintes ferramentas instaladas:

- [XAMPP](https://www.apachefriends.org/pt_br/index.html) (Apache + MySQL)
- Navegador de sua preferência (Chrome, Firefox, etc.)

## Passos para Configuração Local

### 1. Baixar e Instalar o XAMPP

- Acesse o site oficial do [XAMPP](https://www.apachefriends.org/pt_br/index.html).
- Baixe a versão compatível com seu sistema operacional (Windows, Linux ou macOS).
- Siga as instruções de instalação para configurar o Apache e o MySQL.

### 2. Baixar o Projeto

- Clone o repositório ou baixe os arquivos do projeto em formato ZIP.
- Extraia os arquivos para o diretório do XAMPP, geralmente em `C:\xampp\htdocs\` (Windows) ou `/opt/lampp/htdocs/` (Linux).
- O caminho completo pode ser algo como: `C:\xampp\htdocs\gestao_consultas\`.

### 3. Configurar o Banco de Dados

- Abra o XAMPP e inicie os serviços **Apache** e **MySQL**.
- Acesse o [phpMyAdmin](http://localhost/phpmyadmin/) no navegador.
- Na aba de Banco de Dados, Clique em "Novo", e coloque o arquivo "[text](hospitalflordavida.sql)"
- Importe o arquivo SQL fornecido para popular as tabelas com os dados fictícios. 

### 4. Configurar o Arquivo de Conexão (Opcional)

Se você precisar ajustar as configurações do banco de dados no seu ambiente, edite o arquivo de configuração de conexão com o banco de dados (por exemplo, `config.php` ou `db.php`). Certifique-se de que as credenciais de banco de dados estão corretas para sua instalação local:

```php
$host = 'localhost'; // servidor
$user = 'root'; // usuário do MySQL
$password = ''; // senha do MySQL (por padrão, não há senha)
$dbname = 'hospitalflordavida'; // nome do banco de dados

## Tecnologias Utilizadas

- **HTML**: Estrutura do site.
- **CSS**: Estilo e design do site.
- **JavaScript**: Funcionalidades dinâmicas, como máscaras de CPF e telefone.
- **Bootstrap**: Framework para criação do layout responsivo.

## Estrutura do Projeto

- **`index.html`**: Página principal do formulário de registro de pacientes.
- **`styles.css`**: Arquivo CSS para customização e estilos.
- **`scripts.js`**: Arquivo JavaScript para funcionalidades adicionais.
- **`pasta controller`**: Aqui está toda a conexão necessária com o Banco de dados que utilizei

## Criador

Este site foi desenvolvido por [Caik Rian](https://meu-portfolio-pi-opal.vercel.app).

© Todos os direitos reservados. Este site é fictício e criado apenas para fins demonstrativos.

## OBSERVAÇÕES

- É possivel encontrar alguns bugs de direcionamento na hora de clicar no link, principalmente se for na aba de 'medicos'. Caso isto ocorra, voltar a página para a sessão anterior. Esse bug ainda está sendo tratado.




