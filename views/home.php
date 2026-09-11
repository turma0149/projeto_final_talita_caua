<!-- CSS da página -->
<link rel="stylesheet" href="assets/css/evento.css">

<div class="container mt-5">

    <!-- Título -->
    <div class="mb-5">
        <h2>Conecta Contagem</h2>

        <p class="text-muted">
           Olá <?= $_SESSION["usuario_nome"] ?>, bem-vindo(a) ao Sistema Administrativo
        </p>
    </div>


    <!-- Cards -->
    <div class="row g-4">

        <!-- Eventos -->
        <div class="col-md-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body text-center p-4">

                    <i class="bi bi-box-seam fs-1 text-primary"></i>

                    <h5 class="card-title mt-3">
                        Gerenciar Eventos
                    </h5>

                    <p class="card-text text-muted">
                        Vizualize seus eventos.
                    </p>

                    <a href="index.php?page=eventos"
                        class="btn btn-primary">
                        Acessar Eventos
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>