<?php

// =========================================
// INICIA A SESSÃO
// =========================================

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


// =========================================
// ARQUIVOS NECESSÁRIOS
// =========================================

require __DIR__ . "/config/database.php";
require __DIR__ . "/models/LogModel.php";


// =========================================
// CONECTA COM O BANCO DE DADOS
// =========================================

$pdo = conectarBanco();


// =========================================
// REGISTRA O LOGOUT
// =========================================

if (isset($_SESSION["usuario_id"])) {

    registrarLog(
        $pdo,
        $_SESSION["usuario_id"],
        "LOGOUT"
    );
}


// =========================================
// LIMPA OS DADOS DA SESSÃO
// =========================================

$_SESSION = [];


// =========================================
// DESTRÓI A SESSÃO
// =========================================

session_destroy();


// =========================================
// REDIRECIONA PARA A TELA DE LOGIN
// =========================================

header(
    "Location: index.php?page=login"
);

exit;