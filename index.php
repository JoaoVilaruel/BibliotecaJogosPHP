<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Jogos - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body class="container">
    <h1 style="color: #111;">Biblioteca de Jogos</h1>
    <h2>Informe os dados para login:</h2>
    <?php
    require_once 'includes/funcoes.php';
    tratar_erros();
    // Mensagem de sucesso após cadastro
    if (isset($_GET['code']) && $_GET['code'] == 5) {
        echo '<div class="alert alert-success">Usuário cadastrado com sucesso! Faça login.</div>';
    }
    ?>
    <form action="includes/verifica.php" method="post">
        <div class="login-form-row">
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <input type="text" name="usuario" id="usuario" class="form-control">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control">
            </div>
        </div>
        <div class="login-actions">
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="cadastrar.php" class="btn btn-cadastrar-usuario no-underline">Cadastrar novo usuário</a>
        </div>
    </form>
</body>

</html>