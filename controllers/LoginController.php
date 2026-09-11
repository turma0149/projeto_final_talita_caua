<?php

// =========================================
// INICIA A SESSÃO
// =========================================

session_start();


// =========================================
// RESPOSTA DO CONTROLLER SERÁ JSON
// =========================================

header(
    "Content-Type: application/json; charset=utf-8"
);


// =========================================
// ARQUIVOS NECESSÁRIOS
// =========================================

require __DIR__ . "/../config/database.php";
require __DIR__ . "/../models/UsuarioModel.php";
require __DIR__ . "/../models/LogModel.php";


// =========================================
// CONEXÃO COM O BANCO
// =========================================

$pdo = conectarBanco();


// =========================================
// RECEBE OS DADOS DO FORMULÁRIO
// =========================================

$email = trim($_POST["email"] ?? "");

$senha = $_POST["senha"] ?? "";


// =========================================
// VERIFICA CAMPOS OBRIGATÓRIOS
// =========================================

if (
    $email === ""
    || $senha === ""
) {

    http_response_code(422);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Informe e-mail e senha.",
        "dados" => null
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================================
// VALIDA O E-MAIL
// =========================================

if (
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )
) {

    http_response_code(422);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Informe um e-mail válido.",
        "dados" => null
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================================
// BUSCA USUÁRIO NO BANCO
// =========================================

$usuario = buscarUsuarioPorEmail(
    $pdo,
    $email
);

// =========================================
// USUÁRIO NÃO ENCONTRADO
// =========================================


if (!$usuario) {

    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "E-mail ou senha inválidos.",
        "dados" => null
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================================
// VERIFICA A SENHA
// =========================================

if (
    !password_verify(
        $senha,
        $usuario["senha"]
    )
) {

    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "E-mail ou senha inválidos.",
        "dados" => null
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================================
// LOGIN CORRETO
// =========================================

// Gera um novo ID para a sessão
session_regenerate_id(true);


// =========================================
// SALVA DADOS NA SESSÃO
// =========================================

$_SESSION["usuario_id"] = $usuario["id"];

$_SESSION["usuario_nome"] = $usuario["nome"];

$_SESSION["usuario_email"] = $usuario["email"];


// =========================================
// REGISTRA O LOGIN
// =========================================

registrarLog(
    $pdo,
    $_SESSION["usuario_id"],
    "LOGIN"
);


// =========================================
// RETORNA SUCESSO
// =========================================

echo json_encode([
    "sucesso" => true,
    "mensagem" => "Login realizado com sucesso.",
    "dados" => null
], JSON_UNESCAPED_UNICODE);