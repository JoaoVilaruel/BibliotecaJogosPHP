<?php
function form_nao_enviado() {
    return $_SERVER['REQUEST_METHOD'] !== 'POST';
}

// Verifica se algum campo do login está em branco
function login_em_branco() {
    return empty($_POST['usuario']) || empty($_POST['senha']);
}

function tratar_erros() {
    if (!isset($_GET['code'])) {
        return;
    }

    $code = (int)$_GET['code'];
    $erro = '';
    switch ($code) {
        case 0:
            $erro = '<div class="alert alert-warning">Você não tem permissão para acessar a página de destino.</div>';
            break;
        case 1:
            $erro = '<div class="alert alert-danger">Usuário ou senha inválidos. Tente novamente.</div>';
            break;
        case 2:
            $erro = '<div class="alert alert-warning">Por favor, preencha todos os campos do formulário.</div>';
            break;
        case 3:
            $erro = '<div class="alert alert-danger">Erro ao executar consulta ao banco de dados. Tente novamente mais tarde, ou contate o suporte.</div>';
            break;
        case 4:
            $erro = '<div class="alert alert-warning">Formulário não enviado corretamente.</div>';
            break;
        default:
            $erro = "";
            break;
    }
    echo $erro;
}
?>