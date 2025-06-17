<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php?code=0');
    exit;
}
require_once '../includes/conexao.php';
$usuario_id = $_SESSION['id'];
$conn = conectar_banco();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$erro = '';
$titulo = '';
$descricao = '';

// Buscar dados do item
if ($id > 0) {
    $query = "SELECT titulo, descricao FROM tb_itens WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $id, $usuario_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $titulo, $descricao);
    if (!mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: itens.php');
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    mysqli_close($conn);
    header('Location: itens.php');
    exit;
}

// Atualizar dados do item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_titulo = trim(filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING));
    $nova_descricao = trim(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING));
    if ($novo_titulo === '' || $nova_descricao === '') {
        $erro = 'Preencha todos os campos!';
    } else {
        $query = "UPDATE tb_itens SET titulo = ?, descricao = ? WHERE id = ? AND usuario_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssii', $novo_titulo, $nova_descricao, $id, $usuario_id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: itens.php?msg=3');
            exit;
        } else {
            $erro = 'Erro ao atualizar o jogo!';
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }
}
// Não fechar a conexão aqui, pois pode ser usada após POST
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Jogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body class="container">
    <h1 style="color: #111;">Editar Jogo</h1>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="titulo" class="form-label" style="font-size:1.35rem;">Título do Jogo</label>
            <input type="text" class="form-control" name="titulo" id="titulo" value="<?= isset($novo_titulo) ? htmlspecialchars($novo_titulo) : htmlspecialchars($titulo) ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label" style="font-size:1.35rem;">Descrição</label>
            <textarea class="form-control" name="descricao" id="descricao" required><?= isset($nova_descricao) ? htmlspecialchars($nova_descricao) : htmlspecialchars($descricao) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success" style="background-color: #198754 !important; color: #fff !important; border: none !important;">Salvar</button>
        <a href="itens.php" class="btn btn-danger" style="background-color: #dc3545 !important; color: #fff !important; border: none !important;">Cancelar</a>
    </form>
</body>
</html>
