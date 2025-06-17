<?php
function conectar_banco()
{
    $servidor = 'localhost:3306';
    $usuario = 'root';
    $senha = '';
    $banco = 'bd_login';

    $conn = mysqli_connect($servidor, $usuario, $senha, $banco);

    if (!$conn) {
        error_log("Erro na conexão: " . mysqli_connect_error());
        exit("Erro ao conectar ao banco de dados. Tente novamente mais tarde.");
    }

    mysqli_set_charset($conn, "utf8mb4");
    return $conn;
}
