<?php
/*

// =========================================
// CONEXÃO COM O BANCO DE DADOS
// =========================================

function conectarBanco()
{

    // =====================================
    // DADOS DA CONEXÃO
    // =====================================

    $host = "localhost";
$banco = "conecta_contagem";

    $usuario = "root";

    $senha = "";


    // =====================================
    // CRIA A CONEXÃO PDO
    // =====================================

    try {

        $pdo = new PDO(
            "mysql:host=$host;dbname=$banco;charset=utf8mb4",
            $usuario,
            $senha
        );


        // =================================
        // CONFIGURA O PDO PARA EXIBIR ERROS
        // =================================

        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );


        // =================================
        // RETORNA A CONEXÃO
        // =================================

        return $pdo;


    } catch (PDOException $erro) {

        die(
            "Erro ao conectar ao banco de dados: "
            . $erro->getMessage()
        );
    }
}

*/

// TODO: APAGAR ESSE EMBAIXO:

// Função responsável por criar e retornar a conexão com o banco
function conectarBanco()
{
    // Dados de conexão com o banco
    $host = "127.0.0.1";
    $porta = "3307"; // Se necessário, troque para 3306
    $banco = "conecta_contagem";
    $usuario = "root";
    $senha = "";

    try {
        $pdo = new PDO(
            "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8mb4",
            $usuario,
            $senha
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;

    } catch (PDOException $e) {
        die("Erro ao conectar: " . $e->getMessage());
    }
}