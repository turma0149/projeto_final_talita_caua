<?php

// =========================================
// INICIA A SESSÃO
// =========================================

session_start();


// =========================================
// RESPOSTA SERÁ JSON
// =========================================

header(
    "Content-Type: application/json; charset=utf-8"
);


// =========================================
// ARQUIVOS NECESSÁRIOS
// =========================================

require __DIR__ . "/../config/database.php";
require __DIR__ . "/../models/UsuarioModel.php";


// =========================================
// CONEXÃO COM O BANCO
// =========================================

$pdo = conectarBanco();


// =========================================
// VERIFICA SE ESTÁ LOGADO
// =========================================

if (!isset($_SESSION["usuario_id"])) {

    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não autenticado.",
        "dados" => null
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================================
// RECEBE A AÇÃO
// =========================================

$acao = $_POST["acao"] ?? $_GET["acao"] ?? "";


// =========================================
// CADASTRAR USUÁRIO
// =========================================

if ($acao === "cadastrar") {

    // Recebe os dados
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";


    // =====================================
    // VALIDA CAMPOS OBRIGATÓRIOS
    // =====================================

    if (
        $nome === ""
        || $email === ""
        || $senha === ""
    ) {

        http_response_code(422);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Preencha todos os campos.",
            "dados" => null
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }


    // =====================================
    // VALIDA E-MAIL
    // =====================================

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        http_response_code(422);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Informe um e-mail válido.",
            "dados" => null
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }


    // =====================================
    // CADASTRA NO BANCO
    // =====================================

    try {

        cadastrarUsuario(
            $pdo,
            $nome,
            $email,
            $senha
        );


        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Usuário cadastrado com sucesso.",
            "dados" => null
        ], JSON_UNESCAPED_UNICODE);


    } catch (PDOException $erro) {

        http_response_code(500);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Erro ao cadastrar usuário.",
            "dados" => null
        ], JSON_UNESCAPED_UNICODE);
    }

    exit;
} else if ($acao === "listar") {

 // =========================================
// LISTAR USUÁRIOS
// =========================================


    try {

        $usuarios = listarUsuarios($pdo);

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Usuários carregados com sucesso.",
            "dados" => $usuarios
        ], JSON_UNESCAPED_UNICODE);

    } catch (PDOException $erro) {

        http_response_code(500);

        echo json_encode([
            "sucesso" => false,
            "mensagem" => "Erro ao listar usuários.",
            "dados" => null
        ], JSON_UNESCAPED_UNICODE);
    }

    exit;
}


// =========================================
// AÇÃO INVÁLIDA
// =========================================

http_response_code(400);

echo json_encode([
    "sucesso" => false,
    "mensagem" => "Ação inválida.",
    "dados" => null
], JSON_UNESCAPED_UNICODE);