<?php
require_once __DIR__ . '/funcoes.php';

if (form_nao_enviado()) {
    header('Location: ../index.php?code=4');
    exit;
}

if (login_em_branco()) {
    header('Location: ../index.php?code=2');
    exit;
}

$usuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
$senha = trim($_POST['senha']);

require_once __DIR__ . '/conexao.php';
$conn = conectar_banco();

$query = "SELECT id, usuario, senha, email FROM tb_usuarios WHERE usuario = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    mysqli_close($conn);
    header('Location: ../index.php?code=3');
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $usuario);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: ../index.php?code=3');
    exit;
}

mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) <= 0) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: ../index.php?code=1');
    exit;
}

mysqli_stmt_bind_result($stmt, $id, $usuario_db, $senha_hash, $email);
mysqli_stmt_fetch($stmt);

if (!password_verify($senha, $senha_hash)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header('Location: ../index.php?code=1');
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

session_start();
$_SESSION['id'] = $id;
$_SESSION['usuario'] = $usuario_db;
$_SESSION['email'] = $email;

header('Location: ../site/home.php');
exit;