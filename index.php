<?php

// =========================================
// INICIA A SESSÃO
// =========================================

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


// =========================================
// DEFINE A PÁGINA INICIAL
// =========================================

if (isset($_SESSION["usuario_id"])) {

    // Usuário logado vai para HOME
    $page = $_GET["page"] ?? "home";

} else {

    // Usuário não logado vai para LANDING
    $page = $_GET["page"] ?? "landing";
}


// =========================================
// TODAS AS PÁGINAS VÁLIDAS
// =========================================

$paginasValidas = [
    "landing",
    "login",
    "home",
    "eventos",
    "usuarios"
];


// =========================================
// VERIFICA SE A PÁGINA EXISTE
// =========================================

if (!in_array($page, $paginasValidas)) {

    http_response_code(404);

    require __DIR__ . "/views/404.php";

    exit;
}


// =========================================
// PÁGINAS PÚBLICAS
// =========================================

$paginasPublicas = [
    "landing",
    "login"
];  


// =========================================
// PROTEGE SOMENTE PÁGINAS PRIVADAS VÁLIDAS
// =========================================

if (!in_array($page, $paginasPublicas)) {

    require __DIR__ . "/proteger.php";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Conecta Contagem</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <?php
    // Captura a página atual informada na URL
    $page = $_GET["page"] ?? "landing";

    // Páginas que possuem HTML próprio
    $paginasPublicas = [
        "landing" => __DIR__ . "/views/landing.php",
        "login" => __DIR__ . "/views/login.php",
    ];

    // Verifica se é uma página independente
    if (array_key_exists($page, $paginasPublicas)) {
        require $paginasPublicas[$page];
        exit;
    }

    ?>

    <header>

    <div class="logo">
        <img
            src="assets/img/logo123.png"
            alt="Logo da Conecta Contagem"
        >
    </div>

    <nav>
        <ul>

            <li>
                <a href="index.php?page=eventos">
                    Eventos
                </a>
            </li>

            <li>
                <a href="index.php?page=usuarios">
                    Usuários
                </a>
            </li>

        </ul>
    </nav>

    <div class="menu-direita">

        <a
            href="logout.php"
            class="botaoSair"
        >
            <i class="bi bi-box-arrow-right"></i>
            Sair
        </a>

    </div>

</header>

    <!-- Conteúdo carregado pelas rotas -->
    <main class="flex-grow-1">

        <?php
        // Carrega o arquivo que controla as páginas do sistema
        require __DIR__ . "/routes.php";
        ?>

    </main>

    <!-- ---------------------------------------- Footer  ----------------------------- -->
    <footer class="rodape">

        <!-- Container principal -->
        <div class="containerRodape">

            <!-- ================= Logo ================= -->
            <div class="footer-col">

                <!-- Logo -->
                <img src="assets/img/logo 04.png" alt="Logo Conecta Contagem" class="logo-footer">

                <!-- Texto -->
                <p>
                    Informação que conecta você ao que
                    Contagem tem de melhor.
                </p>

                <!-- Redes sociais -->

                <div class="redes">

                    <a href="#" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="#" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a href="#" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>

                </div>

            </div>

            <!-- ================= Navegue ================= -->

            <div class="footer-col">

                <h3>Navegue</h3>

                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Eventos</a></li>
                    <li><a href="#">Comércio</a></li>
                    <li><a href="#">Serviços</a></li>
                    <li><a href="#">Notícias</a></li>
                </ul>

            </div>

            <!-- ================= Institucional ================= -->

            <div class="footer-col">

                <h3>Institucional</h3>

                <ul>
                    <li><a href="#">Sobre o projeto</a></li>
                    <li><a href="#">Como funciona</a></li>
                    <li><a href="#">Perguntas frequentes</a></li>
                    <li><a href="#">Fale conosco</a></li>
                </ul>

            </div>

            <!-- ================= Legal ================= -->

            <div class="footer-col">

                <h3>Legal</h3>

                <ul>
                    <li><a href="#">Termos de uso</a></li>
                    <li><a href="#">Política de privacidade</a></li>
                    <li><a href="#">Acessibilidade</a></li>
                </ul>

            </div>

            <!-- ================= Newsletter ================= -->

            <div class="footer-col newsletter-col">

                <h3>Receba novidades</h3>

                <div class="newsletter">

                    <input type="email" placeholder="Digite seu e-mail">

                    <button>
                        ➜
                    </button>

                </div>

                <p>
                    Fique por dentro das novidades da cidade.
                </p>

            </div>

        </div>

        <!-- Copyright -->

        <div class="footer-copy">

            © 2025 Conecta Contagem. Todos os direitos reservados.

        </div>

    </footer>

    <!-- JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Constantes do sistema -->
    <script src="config/constants.js"></script>

    <!-- Funções auxiliares -->
    <script src="libs/js/helpers.js"></script>

</body>

</html>