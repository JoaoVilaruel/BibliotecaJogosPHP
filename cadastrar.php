<?php
require_once 'includes/funcoes.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $senha = trim($_POST['senha']);
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

    if ($usuario === '' || $senha === '' || $email === '') {
        $erro = 'Preencha todos os campos!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido!';
    } else {
        require_once 'includes/conexao.php';
        $conn = conectar_banco();

        // Verifica se usuário já existe
        $query = "SELECT id FROM tb_usuarios WHERE usuario = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $erro = 'Usuário já cadastrado!';
        } else {
            // Insere novo usuário com senha hash
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $query = "INSERT INTO tb_usuarios (usuario, senha, email) VALUES (?, ?, ?)";
            $stmt2 = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt2, 'sss', $usuario, $senha_hash, $email);
            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_close($stmt2);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header('Location: index.php?code=5');
                exit;
            } else {
                $erro = 'Erro ao cadastrar usuário!';
                mysqli_stmt_close($stmt2);
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body class="container">
    <h1 style="color: #111;">Cadastro de Novo Usuário</h1>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário</label>
            <input type="text" class="form-control" name="usuario" id="usuario" value="<?= isset($usuario) ? htmlspecialchars($usuario) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" name="senha" id="senha" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color: #1976d2; border-color: #1976d2;">Cadastrar</button>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </form>
</body>
</html>
