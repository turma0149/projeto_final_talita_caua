$(document).ready(function () {

    // =========================================
    // MÁSCARA DO CEP
    // =========================================

    $("#cep").mask("00000-000");

    // =========================================
    // VALIDAÇÃO DO FORMULÁRIO
    // =========================================

    validarFormulario();


    // =========================================
    // CARREGA OS EVENTOS AO ABRIR A PÁGINA
    // =========================================

    listarEventos();

    // =========================================
    // BOTÃO CANCELAR
    // =========================================

    $("#btnCancelar").on("click", function () {

        limparFormulario();

    });

});


// =========================================
// LISTA OS EVENTOS
// =========================================

async function listarEventos() {

    try {

        const resposta = await fetch(
            "controllers/EventoController.php?acao=listar"
        );

        const retorno =
            await resposta.json();


        if (!retorno.sucesso) {

            mostrarMensagem(
                retorno.mensagem,
                "danger"
            );

            return;
        }


        const tabela =
            document.getElementById(
                "tabelaEventos"
            );


        tabela.innerHTML = "";


        // =====================================
        // NENHUM EVENTO CADASTRADO
        // =====================================

        if (retorno.dados.length === 0) {

            tabela.innerHTML = `
                <tr>
                    <td
                        colspan="5"
                        class="text-center text-muted"
                    >
                        Nenhum evento cadastrado.
                    </td>
                </tr>
            `;

            return;
        }


        // =====================================
        // CRIA AS LINHAS DA TABELA
        // =====================================

        retorno.dados.forEach(function (evento) {

            const linha =
                document.createElement("tr");


            linha.innerHTML = `

                <td>
                    ${evento.id}
                </td>

                <td>
                    ${evento.titulo}
                </td>

                <td>
                    ${formatarData(evento.data)}
                </td>

                <td>
                    ${evento.cidade}
                </td>

                <td>

                    <button
                        type="button"
                        class="btn btn-sm btn-warning me-1"
                        onclick="editarEvento(${evento.id})"
                    >
                        <i class="bi bi-pencil"></i>
                        Editar
                    </button>


                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        onclick="excluirEvento(${evento.id})"
                    >
                        <i class="bi bi-trash"></i>
                        Excluir
                    </button>

                </td>
            `;


            tabela.appendChild(linha);

        });


    } catch (erro) {

        console.error(erro);

        mostrarMensagem(
            "Erro ao carregar os eventos.",
            "danger"
        );
    }
}


// =========================================
// BUSCA EVENTO PARA EDIÇÃO
// =========================================

async function editarEvento(id) {

    try {

        const resposta = await fetch(
            "controllers/EventoController.php"
            + "?acao=buscar&id="
            + id
        );


        const retorno =
            await resposta.json();


        if (!retorno.sucesso) {

            mostrarMensagem(
                retorno.mensagem,
                "danger"
            );

            return;
        }


        const evento =
            retorno.dados;


        // =====================================
        // PREENCHE O FORMULÁRIO
        // =====================================

        $("#id").val(
            evento.id
        );

        $("#acao").val(
            "editar"
        );

        $("#titulo").val(
            evento.titulo
        );

        $("#data").val(
            evento.data
        );

        $("#descricao").val(
            evento.descricao
        );

        $("#rua").val(
            evento.rua
        );

        $("#numero").val(
            evento.numero
        );

        $("#cidade").val(
            evento.cidade
        );

        $("#cep").val(
            evento.cep
        );

        $("#latitude").val(
            evento.latitude
        );

        $("#longitude").val(
            evento.longitude
        );


        // =====================================
        // ALTERA TEXTO DO BOTÃO
        // =====================================

        $("#btnSalvar").text(
            "Atualizar Evento"
        );


        // =====================================
        // VOLTA PARA O FORMULÁRIO
        // =====================================

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });


    } catch (erro) {

        console.error(erro);

        mostrarMensagem(
            "Erro ao buscar o evento.",
            "danger"
        );
    }
}


// =========================================
// EXCLUI EVENTO
// =========================================

async function excluirEvento(id) {

    // =========================================
    // CONFIRMA A EXCLUSÃO
    // =========================================

    const confirmar = confirm(
        "Deseja realmente excluir este evento?"
    );


    if (!confirmar) {
        return;
    }


    const dados = new FormData();

    dados.append(
        "acao",
        "excluir"
    );

    dados.append(
        "id",
        id
    );


    try {

        const resposta = await fetch(
            "controllers/EventoController.php",
            {
                method: "POST",
                body: dados
            }
        );


        const retorno =
            await resposta.json();


        if (!retorno.sucesso) {

            mostrarMensagem(
                retorno.mensagem,
                "danger"
            );

            return;
        }


        mostrarMensagem(
            retorno.mensagem,
            "success"
        );


        listarEventos();


    } catch (erro) {

        console.error(erro);

        mostrarMensagem(
            "Erro ao excluir o evento.",
            "danger"
        );
    }
}


// =========================================
// LIMPA O FORMULÁRIO
// =========================================

function limparFormulario() {

    const formulario =
        document.getElementById(
            "formEvento"
        );


    formulario.reset();


    // =========================================
    // VOLTA PARA O MODO CADASTRAR
    // =========================================

    $("#id").val("");

    $("#acao").val(
        "cadastrar"
    );

    $("#btnSalvar").text(
        "Salvar Evento"
    );
}


// =========================================
// EXIBE MENSAGEM
// =========================================

function mostrarMensagem(
    texto,
    tipo
) {

    const mensagem =
        document.getElementById(
            "mensagem"
        );


    mensagem.className = "alert alert-" + tipo + " mt-3";


    mensagem.textContent =
        texto;
}


// =========================================
// FORMATA A DATA
// =========================================

function formatarData(data) {

    if (!data) {
        return "";
    }


    const partes =
        data.split("-");


    return (
        partes[2]
        + "/"
        + partes[1]
        + "/"
        + partes[0]
    );
}

// =========================================
// CONFIGURA JQUERY VALIDATE
// =========================================

function validarFormulario() {

    $("#formEvento").validate({

        // =====================================
        // REGRAS
        // =====================================

        rules: {

            titulo: {
                required: true,
                minlength: 3,
                maxlength: 150
            },

            data: {
                required: true
            },

            descricao: {
                required: true,
                minlength: 10
            },

            rua: {
                required: true,
                minlength: 3
            },

            numero: {
                required: true
            },

            cidade: {
                required: true,
                minlength: 3
            },

            cep: {
                required: true,
                minlength: 9,
                maxlength: 9
            },

            latitude: {
                number: true
            },

            longitude: {
                number: true
            }

        },


        // =====================================
        // MENSAGENS
        // =====================================

        messages: {

            titulo: {
                required: "Informe o título do evento.",
                minlength: "Informe pelo menos 3 caracteres.",
                maxlength: "O título deve possuir no máximo 150 caracteres."
            },

            data: {
                required: "Informe a data do evento."
            },

            descricao: {
                required: "Informe a descrição.",
                minlength: "A descrição deve possuir pelo menos 10 caracteres."
            },

            rua: {
                required: "Informe a rua.",
                minlength: "Informe pelo menos 3 caracteres."
            },

            numero: {
                required: "Informe o número."
            },

            cidade: {
                required: "Informe a cidade.",
                minlength: "Informe pelo menos 3 caracteres."
            },

            cep: {
                required: "Informe o CEP.",
                minlength: "Informe um CEP válido.",
                maxlength: "Informe um CEP válido."
            },

            latitude: {
                number: "Informe uma latitude válida."
            },

            longitude: {
                number: "Informe uma longitude válida."
            }

        },


        // =====================================
        // POSICIONA A MENSAGEM DE ERRO
        // =====================================

        errorPlacement: function (error, element) {

            error.addClass("text-danger small mt-1");

            error.insertAfter(element);

        },


        // =====================================
        // CAMPO INVÁLIDO
        // =====================================

        highlight: function (element) {

            $(element)
                .removeClass("is-valid")
                .addClass("is-invalid");

        },


        // =====================================
        // CAMPO VÁLIDO
        // =====================================

        unhighlight: function (element) {

            $(element)
                .removeClass("is-invalid")
                .addClass("is-valid");

        },


        // =====================================
        // FORMULÁRIO VÁLIDO
        // =====================================

        submitHandler: async function (formulario) {

            event.preventDefault();

            const dados =
                new FormData(formulario);


            // =================================
            // REMOVE A MÁSCARA DO CEP
            // =================================

            const cep = $("#cep")
                .val()
                .replace(/\D/g, "");

            dados.set(
                "cep",
                cep
            );


            try {

                const resposta =
                    await fetch(
                        "controllers/EventoController.php",
                        {
                            method: "POST",
                            body: dados
                        }
                    );


                const retorno =
                    await resposta.json();


                if (!retorno.sucesso) {

                    mostrarMensagem(
                        retorno.mensagem,
                        "danger"
                    );

                    return;
                }


                mostrarMensagem(
                    retorno.mensagem,
                    "success"
                );


                limparFormulario();

                listarEventos();


            } catch (erro) {

                console.error(erro);

                mostrarMensagem(
                    "Erro ao salvar o evento.",
                    "danger"
                );
            }

        }

    });

}