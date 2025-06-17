<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php?code=0');
    exit;
}
require_once '../includes/conexao.php';
$usuario_id = $_SESSION['id'];
$conn = conectar_banco();

// Exclusão de item via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['del'])) {
    $item_id = (int)$_POST['del'];
    $query = "DELETE FROM tb_itens WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $item_id, $usuario_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Location: itens.php?msg=2');
    exit;
}

// Mensagem de feedback
$msg = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 1) $msg = '<div class="alert alert-success">Jogo cadastrado com sucesso!</div>';
    if ($_GET['msg'] == 2) $msg = '<div class="alert alert-success">Jogo excluído com sucesso!</div>';
    if ($_GET['msg'] == 3) $msg = '<div class="alert alert-success">Jogo editado com sucesso!</div>';
}

// Buscar itens do usuário
$query = "SELECT id, titulo, descricao FROM tb_itens WHERE usuario_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $usuario_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $titulo, $descricao);

$itens = [];
while (mysqli_stmt_fetch($stmt)) {
    $itens[] = ['id' => $id, 'titulo' => $titulo, 'descricao' => $descricao];
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Jogos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body class="container">
    <h1 style="color: #111;">Meus Jogos</h1>
    <?= $msg ?>
    <a href="novo_item.php" class="btn btn-cadastrar-jogo mb-3">Cadastrar Novo Jogo</a>
    <a href="home.php" class="btn btn-secondary mb-3" style="background-color: #6c757d !important; color: #fff !important; border: none !important;">Voltar</a>
    <?php if (count($itens) === 0): ?>
        <div class="alert alert-info">Nenhum jogo cadastrado.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th style="font-size:1.15rem;">Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['titulo']) ?></td>
                        <td><?= htmlspecialchars($item['descricao']) ?></td>
                        <td>
                            <a href="editar_item.php?id=<?= $item['id'] ?>" class="btn btn-warning btn-sm" style="background-color: #ffc107 !important; color: #111 !important; border: none !important;">Editar</a>
                            <form method="post" action="itens.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este jogo?');">
                                <input type="hidden" name="del" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" style="background-color: #dc3545 !important; color: #fff !important; border: none !important;">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
