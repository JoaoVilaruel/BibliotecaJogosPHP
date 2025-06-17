# Biblioteca de Jogos

Este projeto é uma aplicação web simples para cadastro e gerenciamento de jogos pessoais, desenvolvida em PHP com MySQL e Bootstrap.

## Funcionalidades

- Cadastro de usuários
- Login e logout
- Cadastro, edição e exclusão de jogos (itens) por usuário
- Interface responsiva com Bootstrap

## Requisitos

- PHP 7.4 ou superior
- MySQL
- Servidor web (Apache, Nginx, etc.)

## Instalação

1. **Clone ou copie os arquivos do projeto para seu servidor web.**

2. **Crie o banco de dados e as tabelas:**

   - Importe o arquivo `sql/bd_login.sql` no seu MySQL.

3. **Configure a conexão com o banco de dados:**

   - Edite `includes/conexao.php` se necessário (usuário, senha, host, porta).

4. **Acesse o sistema:**
   - Abra `index.php` no navegador para acessar a tela de login/cadastro.

## Estrutura de Pastas

- `includes/` - Funções auxiliares, conexão e scripts SQL
- `css/` - Arquivos de estilo
- `site/` - Páginas protegidas (após login)
- `index.php` - Tela de login
- `cadastrar.php` - Cadastro de novo usuário
- `logout.php` - Logout

## Observação

- As senhas são armazenadas de forma segura usando hashing (`password_hash`).
- O sistema utiliza sessões para autenticação.
- Cada usuário só pode ver e gerenciar seus próprios jogos.
- A execução do projeto foi feita por 3 alunos.
- A função de edição foi adicionado ao projeto devido ao aumento de integrantes

## Licença

Uso livre para fins acadêmicos e de aprendizado.

---

**Autor:** João Alexandre Vilaruel Dos Santos , Caio Voitena Roupa e Silvio Gabriel Felix de Souza
📅 Projeto desenvolvido em 2025
