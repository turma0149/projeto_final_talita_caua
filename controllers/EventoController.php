<?php

// =========================================
// INICIA A SESSÃO
// =========================================

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


// =========================================
// RESPOSTA EM JSON
// =========================================

header(
    "Content-Type: application/json; charset=utf-8"
);


// =========================================
// ARQUIVOS NECESSÁRIOS
// =========================================

require __DIR__ . "/../config/database.php";
require __DIR__ . "/../models/EventoModel.php";
require __DIR__ . "/../models/LogModel.php";


// =========================================
// VERIFICA SE ESTÁ LOGADO
// =========================================

if (!isset($_SESSION["usuario_id"])) {

    http_response_code(401);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Usuário não autenticado."
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// =========================================
// CONEXÃO COM O BANCO
// =========================================

$pdo = conectarBanco();


// =========================================
// RECEBE A AÇÃO
// =========================================

$acao = $_POST["acao"] ?? $_GET["acao"] ?? "";


// =========================================
// ESCOLHE A OPERAÇÃO
// =========================================

switch ($acao) {

    // =====================================
    // LISTAR EVENTOS
    // =====================================

    case "listar":

        $eventos = listarEventos($pdo);

        echo json_encode([
            "sucesso" => true,
            "dados" => $eventos
        ], JSON_UNESCAPED_UNICODE);

        break;


    // =====================================
    // BUSCAR EVENTO PELO ID
    // =====================================

    case "buscar":

        $id = $_GET["id"] ?? 0;

        $evento = buscarEventoPorId(
            $pdo,
            $id
        );

        if (!$evento) {

            http_response_code(404);

            echo json_encode([
                "sucesso" => false,
                "mensagem" => "Evento não encontrado."
            ], JSON_UNESCAPED_UNICODE);

            break;
        }

        echo json_encode([
            "sucesso" => true,
            "dados" => $evento
        ], JSON_UNESCAPED_UNICODE);

        break;


    // =====================================
    // CADASTRAR EVENTO
    // =====================================

    case "cadastrar":

        $titulo = trim(
            $_POST["titulo"] ?? ""
        );

        $data = $_POST["data"] ?? "";

        $descricao = trim(
            $_POST["descricao"] ?? ""
        );

        $rua = trim(
            $_POST["rua"] ?? ""
        );

        $numero = trim(
            $_POST["numero"] ?? ""
        );

        $cidade = trim(
            $_POST["cidade"] ?? ""
        );

        $cep = preg_replace(
            "/\D/",
            "",
            $_POST["cep"] ?? ""
        );

        $latitude =
            $_POST["latitude"] ?? null;

        $longitude =
            $_POST["longitude"] ?? null;


        // =================================
        // VALIDAÇÃO BÁSICA
        // =================================

        if (
            $titulo === ""
            || $data === ""
            || $descricao === ""
            || $rua === ""
            || $numero === ""
            || $cidade === ""
            || $cep === ""
        ) {

            http_response_code(422);

            echo json_encode([
                "sucesso" => false,
                "mensagem" =>
                    "Preencha os campos obrigatórios."
            ], JSON_UNESCAPED_UNICODE);

            break;
        }


        // =================================
        // IMAGEM
        // =================================

        $imagem = null;

        if (
            isset($_FILES["imagem"])
            && $_FILES["imagem"]["error"]
                === UPLOAD_ERR_OK
        ) {

            $pasta =
                __DIR__
                . "/../assets/img/eventos/";

            if (!is_dir($pasta)) {
                mkdir(
                    $pasta,
                    0777,
                    true
                );
            }

            $extensao =
                pathinfo(
                    $_FILES["imagem"]["name"],
                    PATHINFO_EXTENSION
                );

            $nomeImagem =
                uniqid("evento_")
                . "."
                . $extensao;

            move_uploaded_file(
                $_FILES["imagem"]["tmp_name"],
                $pasta . $nomeImagem
            );

            $imagem =
                "assets/img/eventos/"
                . $nomeImagem;
        }


        // =================================
        // CADASTRA NO BANCO
        // =================================

        $idEvento = cadastrarEvento(
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
        );


        // =================================
        // REGISTRA LOG
        // =================================

        registrarLog(
            $pdo,
            $_SESSION["usuario_id"],
            "CADASTROU EVENTO",
            $idEvento
        );


        echo json_encode([
            "sucesso" => true,
            "mensagem" =>
                "Evento cadastrado com sucesso.",
            "id" => $idEvento
        ], JSON_UNESCAPED_UNICODE);

        break;


    // =====================================
    // EDITAR EVENTO
    // =====================================

    case "editar":

        $id = $_POST["id"] ?? 0;

        $eventoAtual =
            buscarEventoPorId(
                $pdo,
                $id
            );

        if (!$eventoAtual) {

            http_response_code(404);

            echo json_encode([
                "sucesso" => false,
                "mensagem" =>
                    "Evento não encontrado."
            ], JSON_UNESCAPED_UNICODE);

            break;
        }


        $titulo = trim(
            $_POST["titulo"] ?? ""
        );

        $data =
            $_POST["data"] ?? "";

        $descricao = trim(
            $_POST["descricao"] ?? ""
        );

        $rua = trim(
            $_POST["rua"] ?? ""
        );

        $numero = trim(
            $_POST["numero"] ?? ""
        );

        $cidade = trim(
            $_POST["cidade"] ?? ""
        );

        $cep = preg_replace(
            "/\D/",
            "",
            $_POST["cep"] ?? ""
        );

        $latitude =
            $_POST["latitude"] ?? null;

        $longitude =
            $_POST["longitude"] ?? null;


        // =================================
        // MANTÉM A IMAGEM ANTIGA
        // =================================

        $imagem =
            $eventoAtual["imagem"];


        // =================================
        // SE ENVIOU NOVA IMAGEM
        // =================================

        if (
            isset($_FILES["imagem"])
            && $_FILES["imagem"]["error"]
                === UPLOAD_ERR_OK
        ) {

            $pasta =
                __DIR__
                . "/../assets/img/eventos/";

            if (!is_dir($pasta)) {

                mkdir(
                    $pasta,
                    0777,
                    true
                );
            }

            $extensao =
                pathinfo(
                    $_FILES["imagem"]["name"],
                    PATHINFO_EXTENSION
                );

            $nomeImagem =
                uniqid("evento_")
                . "."
                . $extensao;

            move_uploaded_file(
                $_FILES["imagem"]["tmp_name"],
                $pasta . $nomeImagem
            );

            $imagem =
                "assets/img/eventos/"
                . $nomeImagem;
        }


        // =================================
        // ATUALIZA NO BANCO
        // =================================

        editarEvento(
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
        );


        // =================================
        // REGISTRA LOG
        // =================================

        registrarLog(
            $pdo,
            $_SESSION["usuario_id"],
            "EDITOU EVENTO",
            $id
        );


        echo json_encode([
            "sucesso" => true,
            "mensagem" =>
                "Evento atualizado com sucesso."
        ], JSON_UNESCAPED_UNICODE);

        break;


    // =====================================
    // EXCLUIR EVENTO
    // =====================================

    case "excluir":

        $id = $_POST["id"] ?? 0;


        // Registra antes de excluir
        registrarLog(
            $pdo,
            $_SESSION["usuario_id"],
            "EXCLUIU EVENTO",
            $id
        );


        excluirEvento(
            $pdo,
            $id
        );


        echo json_encode([
            "sucesso" => true,
            "mensagem" =>
                "Evento excluído com sucesso."
        ], JSON_UNESCAPED_UNICODE);

        break;


    // =====================================
    // AÇÃO INVÁLIDA
    // =====================================

    default:

        http_response_code(400);

        echo json_encode([
            "sucesso" => false,
            "mensagem" =>
                "Ação inválida."
        ], JSON_UNESCAPED_UNICODE);

        break;
}