<?php

// =========================================
// BUSCA USUÁRIO PELO E-MAIL
// =========================================

function buscarUsuarioPorEmail(
    $pdo,
    $email
) {

    $stmt = $pdo->prepare(
        "SELECT *
         FROM usuarios
         WHERE email = ?"
    );

    $stmt->execute([
        $email
    ]);

    return $stmt->fetch(
        PDO::FETCH_ASSOC
    );
}


// =========================================
// CADASTRA USUÁRIO
// =========================================

function cadastrarUsuario(
    $pdo,
    $nome,
    $email,
    $senha
) {

    // Cria o hash da senha
    $senhaHash = password_hash(
        $senha,
        PASSWORD_DEFAULT
    );


    $stmt = $pdo->prepare(
        "INSERT INTO usuarios
        (
            nome,
            email,
            senha
        )
        VALUES (?, ?, ?)"
    );


    $stmt->execute([
        $nome,
        $email,
        $senhaHash
    ]);


    return $pdo->lastInsertId();
}

// =========================================
// LISTAR USUÁRIOS
// =========================================

function listarUsuarios($pdo)
{
    $stmt = $pdo->prepare(
        "SELECT
            id,
            nome,
            email
         FROM usuarios
         ORDER BY id DESC"
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}