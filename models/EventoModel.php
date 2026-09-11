<?php

// =========================================
// LISTA TODOS OS EVENTOS
// =========================================

function listarEventos($pdo)
{
    $stmt = $pdo->prepare(
        "SELECT *
         FROM eventos
         ORDER BY id DESC"
    );

    $stmt->execute();

    return $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );
}


// =========================================
// BUSCA UM EVENTO PELO ID
// =========================================

function buscarEventoPorId(
    $pdo,
    $id
) {

    $stmt = $pdo->prepare(
        "SELECT *
         FROM eventos
         WHERE id = ?"
    );

    $stmt->execute([
        $id
    ]);

    return $stmt->fetch(
        PDO::FETCH_ASSOC
    );
}


// =========================================
// CADASTRA EVENTO
// =========================================

function cadastrarEvento(
    $pdo,
    $titulo,
    $data,
    $descricao,
    $rua,
    $numero,
    $cidade,
    $cep,
    $imagem,
    $latitude,
    $longitude
) {

    $stmt = $pdo->prepare(
        "INSERT INTO eventos
        (
            titulo,
            data,
            descricao,
            rua,
            numero,
            cidade,
            cep,
            imagem,
            latitude,
            longitude
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->execute([
        $titulo,
        $data,
        $descricao,
        $rua,
        $numero,
        $cidade,
        $cep,
        $imagem,
        $latitude,
        $longitude
    ]);

    return $pdo->lastInsertId();
}


// =========================================
// EDITA EVENTO
// =========================================

function editarEvento(
    $pdo,
    $id,
    $titulo,
    $data,
    $descricao,
    $rua,
    $numero,
    $cidade,
    $cep,
    $imagem,
    $latitude,
    $longitude
) {

    $stmt = $pdo->prepare(
        "UPDATE eventos
         SET
            titulo = ?,
            data = ?,
            descricao = ?,
            rua = ?,
            numero = ?,
            cidade = ?,
            cep = ?,
            imagem = ?,
            latitude = ?,
            longitude = ?
         WHERE id = ?"
    );

    return $stmt->execute([
        $titulo,
        $data,
        $descricao,
        $rua,
        $numero,
        $cidade,
        $cep,
        $imagem,
        $latitude,
        $longitude,
        $id
    ]);
}


// =========================================
// EXCLUI EVENTO
// =========================================

function excluirEvento(
    $pdo,
    $id
) {

    $stmt = $pdo->prepare(
        "DELETE FROM eventos
         WHERE id = ?"
    );

    return $stmt->execute([
        $id
    ]);
}