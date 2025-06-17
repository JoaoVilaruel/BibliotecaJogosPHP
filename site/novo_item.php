<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php?code=0');
    exit;
}
require_once '../includes/conexao.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim(filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING));
    $descricao = trim(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING));
    $usuario_id = $_SESSION['id'];

    if ($titulo === '' || $descricao === '') {
        $erro = 'Preencha todos os campos!';
    } else {
        $conn = conectar_banco();
        $query = "INSERT INTO tb_itens (usuario_id, titulo, descricao) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iss', $usuario_id, $titulo, $descricao);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: itens.php?msg=1');
            exit;
        } else {
            $erro = 'Erro ao cadastrar item!';
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Jogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body class="container">
    <h1 style="color: #111;">Cadastrar Novo Jogo</h1>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="titulo" class="form-label" style="font-size:1.35rem;">Título do Jogo</label>
            <input type="text" class="form-control" name="titulo" id="titulo" value="<?= isset($titulo) ? htmlspecialchars($titulo) : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label" style="font-size:1.35rem;">Descrição</label>
            <textarea class="form-control" name="descricao" id="descricao" required><?= isset($descricao) ? htmlspecialchars($descricao) : '' ?></textarea>
        </div>
        <button type="submit" class="btn btn-cadastrar-jogo">Cadastrar</button>
        <a href="home.php" class="btn btn-outline-secondary" style="border: 2px solid #6c757d; color: #fff; background: #6c757d;">Voltar</a>
    </form>
</body>
</html>
