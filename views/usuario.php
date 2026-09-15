<!-- CSS da página -->
<link rel="stylesheet" href="assets/css/usuario.css">


<div class="container mt-5 mb-5">

    <!-- =========================================
         TÍTULO
    ========================================= -->

    <div class="mb-4">

        <h2>Gerenciar Usuários</h2>

        <p class="text-muted">
            Cadastre os usuários que terão acesso ao sistema.
        </p>

    </div>


    <!-- =========================================
         CARD DO FORMULÁRIO
    ========================================= -->

    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            <h5 class="card-title mb-4">
                Cadastro de Usuário
            </h5>


            <form id="formUsuario">

                <!-- ID -->
                <input
                    type="hidden"
                    id="id"
                    name="id"
                >

                <!-- AÇÃO -->
                <input
                    type="hidden"
                    id="acao"
                    name="acao"
                    value="cadastrar"
                >


                <div class="row g-3">

                    <!-- NOME -->
                    <div class="col-md-6">

                        <label
                            for="nome"
                            class="form-label"
                        >
                            Nome
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="nome"
                            name="nome"
                            placeholder="Digite o nome"
                        >

                    </div>


                    <!-- E-MAIL -->
                    <div class="col-md-6">

                        <label
                            for="email"
                            class="form-label"
                        >
                            E-mail
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="email@email.com"
                        >

                    </div>


                    <!-- SENHA -->
                    <div class="col-md-6">

                        <label
                            for="senha"
                            class="form-label"
                        >
                            Senha
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="senha"
                            name="senha"
                            placeholder="Digite a senha"
                        >

                    </div>

                </div>


                <!-- BOTÕES -->
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <button
                        type="button"
                        id="btnCancelar"
                        class="btn btn-outline-secondary"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-person-plus me-1"></i>

                        Salvar Usuário

                    </button>

                </div>


                <!-- MENSAGEM -->
                <div
                    id="mensagem"
                    class="alert d-none mt-3"
                >
                </div>

            </form>

        </div>

    </div>


    <!-- =========================================
         LISTA DE USUÁRIOS
    ========================================= -->

    <div class="mt-5">

        <h4 class="mb-4">
            Usuários Cadastrados
        </h4>


        <div class="card shadow-sm border-0">

            <div class="card-body p-4">

                <div class="table-responsive">

                    <table class="table table-hover align-middle tabela-usuarios">

                        <thead>

                            <tr>

                                <th class="col-id">
                                    ID
                                </th>

                                <th class="col-nome">
                                    Nome
                                </th>

                                <th class="col-email">
                                    E-mail
                                </th>

                                <th class="col-acoes">
                                    Ações
                                </th>

                            </tr>

                        </thead>


                        <tbody id="listaUsuarios">

                            <!--
                                Usuários serão carregados
                                pelo JavaScript
                            -->

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================
     JAVASCRIPT DA PÁGINA
========================================= -->

<script src="assets/js/usuarios.js"></script>