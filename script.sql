-- =========================================
-- BANCO DE DADOS
-- CONECTA CONTAGEM
-- =========================================

CREATE DATABASE IF NOT EXISTS conecta_contagem;

USE conecta_contagem;


-- =========================================
-- TABELA DE USUÁRIOS
-- =========================================

CREATE TABLE usuarios (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,

    senha VARCHAR(255) NOT NULL

);


-- =========================================
-- TABELA DE EVENTOS
-- =========================================

CREATE TABLE eventos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(150) NOT NULL,

    data DATE NOT NULL,

    descricao TEXT NOT NULL,

    rua VARCHAR(200) NOT NULL,

    numero VARCHAR(20) NOT NULL,

    cidade VARCHAR(100) NOT NULL,

    cep VARCHAR(8) NOT NULL,

    imagem VARCHAR(255) DEFAULT NULL,

    latitude DECIMAL(10,8) DEFAULT NULL,

    longitude DECIMAL(11,8) DEFAULT NULL

);


-- =========================================
-- TABELA DE LOGS
-- =========================================

CREATE TABLE logs (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    evento_id INT DEFAULT NULL,

    acao VARCHAR(255) NOT NULL,

    data_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_logs_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id),

    CONSTRAINT fk_logs_evento
        FOREIGN KEY (evento_id)
        REFERENCES eventos(id)
        ON DELETE SET NULL

);

-- =========================================
-- USUÁRIO INICIAL PARA TESTE
-- =========================================

INSERT INTO usuarios
(
    nome,
    email,
    senha
)
VALUES
(
    'Administrador',
    'admin@teste.com',
    '$2y$12$vdqNnjqdf1TznZGgYIni4eRgqQpdK/71owBsVtO5dTNerpXKOnfLu'
);