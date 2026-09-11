<!-- CSS da página -->
<link rel="stylesheet" href="assets/css/evento.css">

<!-- Formulário de Cadastro -->
<section class="conteudo-cadastro container-fluid p-4">

    <h2 class="titulo-pagina mb-4">
        Cadastrar Novo Evento
    </h2>

    <form
        class="form-evento-clean"
        id="formEvento"
        enctype="multipart/form-data"
    >

        <!-- =====================================
             CAMPOS OCULTOS DO CRUD
        ====================================== -->

        <input
            type="hidden"
            id="id"
            name="id"
        >

        <input
            type="hidden"
            id="acao"
            name="acao"
            value="cadastrar"
        >


        <!-- =====================================
             CAMPOS BÁSICOS
        ====================================== -->

        <div class="row mb-3">

            <div class="col-md-8">

                <label
                    for="titulo"
                    class="form-label"
                >
                    Título do Evento
                </label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    class="form-control"
                    placeholder="Ex: Workshop de Tecnologia"
                >

            </div>


            <div class="col-md-4">

                <label
                    for="data"
                    class="form-label"
                >
                    Data do Evento
                </label>

                <input
                    type="date"
                    id="data"
                    name="data"
                    class="form-control"
                >

            </div>

        </div>


        <div class="mb-3">

            <label
                for="descricao"
                class="form-label"
            >
                Descrição
            </label>

            <textarea
                id="descricao"
                name="descricao"
                class="form-control"
                rows="3"
                placeholder="Insira os detalhes do evento..."
            ></textarea>

        </div>


        <!-- =====================================
             ENDEREÇO
        ====================================== -->

        <div class="row mb-3">

            <div class="col-md-9">

                <label
                    for="rua"
                    class="form-label"
                >
                    Rua
                </label>

                <input
                    type="text"
                    id="rua"
                    name="rua"
                    class="form-control"
                    placeholder="Ex: Avenida João César de Oliveira"
                >

            </div>


            <div class="col-md-3">

                <label
                    for="numero"
                    class="form-label"
                >
                    Número
                </label>

                <input
                    type="text"
                    id="numero"
                    name="numero"
                    class="form-control"
                    placeholder="Ex: 123"
                >

            </div>

        </div>


        <div class="row mb-3">

            <div class="col-md-8">

                <label
                    for="cidade"
                    class="form-label"
                >
                    Cidade
                </label>

                <input
                    type="text"
                    id="cidade"
                    name="cidade"
                    class="form-control"
                    placeholder="Ex: Contagem"
                >

            </div>


            <div class="col-md-4">

                <label
                    for="cep"
                    class="form-label"
                >
                    CEP
                </label>

                <input
                    type="text"
                    id="cep"
                    name="cep"
                    class="form-control"
                    placeholder="Ex: 32310-000"
                >

            </div>

        </div>


        <!-- =====================================
             UPLOAD DA IMAGEM
        ====================================== -->

        <div class="mb-4">

            <label class="form-label">
                Imagem de Capa do Evento
            </label>

            <div class="image-upload-zone">

                <input
                    type="file"
                    id="imagem-evento"
                    name="imagem"
                    accept="image/*"
                    hidden
                >

                <label
                    for="imagem-evento"
                    class="upload-label w-100"
                >

                    <i class="bi bi-cloud-arrow-up display-6 text-primary-conecta"></i>

                    <span class="d-block fw-bold my-1">
                        Clique aqui para selecionar a imagem
                    </span>

                    <small class="text-muted">
                        Formatos: JPG, PNG (Máx. 2MB)
                    </small>

                </label>

            </div>

        </div>


        <!-- =====================================
             COORDENADAS GEOGRÁFICAS
        ====================================== -->

        <div class="geo-section pt-3 border-top">

            <h5 class="text-muted mb-3 small fw-bold text-uppercase">
                Coordenadas Geográficas
            </h5>

            <div class="row mb-4">

                <div class="col-md-6">

                    <label
                        for="latitude"
                        class="form-label"
                    >
                        Latitude
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-geo-alt"></i>
                        </span>

                        <input
                            type="number"
                            id="latitude"
                            name="latitude"
                            step="any"
                            class="form-control"
                            placeholder="Ex: -19.9318"
                        >

                    </div>

                </div>


                <div class="col-md-6">

                    <label
                        for="longitude"
                        class="form-label"
                    >
                        Longitude
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-geo"></i>
                        </span>

                        <input
                            type="number"
                            id="longitude"
                            name="longitude"
                            step="any"
                            class="form-control"
                            placeholder="Ex: -44.0531"
                        >

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================
             BOTÕES
        ====================================== -->

        <div class="d-flex justify-content-end gap-2">

            <button
                type="reset"
                class="btn btn-outline-conecta"
                id="btnCancelar"
            >
                Cancelar
            </button>

            <button
                type="submit"
                class="btn btn-conecta"
                id="btnSalvar"
            >
                Salvar Evento
            </button>

        </div>


        <!-- =====================================
             MENSAGENS
        ====================================== -->

        <div
            id="mensagem"
            class="alert d-none mt-3"
            role="alert"
        ></div>

    </form>

</section>


<!-- =========================================
     LISTAGEM DOS EVENTOS
========================================= -->

<section class="container-fluid px-4 pb-4">

    <h3 class="mb-3">
        Eventos Cadastrados
    </h3>

    <div class="table-responsive">

        <table class="table table-striped table-hover">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Data</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>

            </thead>

            <tbody id="tabelaEventos">

                <!-- Eventos serão inseridos pelo JavaScript -->

            </tbody>

        </table>

    </div>

</section>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- Script da página -->
<script src="assets/js/eventos.js"></script>