<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php?code=0');
    exit;
}
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Bem-vindo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>

<body class="container">
    <h1 style="color: #111;">Bem-vindo, <?= htmlspecialchars($usuario) ?>!</h1>
    <p>
        <a href="novo_item.php" class="btn btn-cadastrar-jogo">Cadastrar Novo Jogo</a>
        <a href="itens.php" class="btn btn-info" style="background-color: #38bdf8 !important; color: #fff !important; border: none !important;">Meus Jogos</a>
        <a href="../logout.php" class="btn btn-danger" style="background-color: #dc3545 !important; color: #fff !important; border: none !important;">Logout</a>
    </p>
</body>

</html>