document.addEventListener("DOMContentLoaded", function () {

    // =========================================
    // ELEMENTOS DA PÁGINA
    // =========================================

    const formUsuario =
        document.getElementById("formUsuario");

    const btnCancelar =
        document.getElementById("btnCancelar");

    const mensagem =
        document.getElementById("mensagem");

    const listaUsuarios =
        document.getElementById("listaUsuarios");


    // =========================================
    // LISTAR USUÁRIOS
    // =========================================

    async function listarUsuarios() {

        try {

            const resposta = await fetch(
                "controllers/UsuarioController.php?acao=listar"
            );

            const retorno = await resposta.json();


            // Se ocorreu algum erro no Controller
            if (!retorno.sucesso) {

                console.error(retorno.mensagem);

                return;
            }


            // Limpa a tabela
            listaUsuarios.innerHTML = "";


            // =====================================
            // NENHUM USUÁRIO CADASTRADO
            // =====================================

            if (retorno.dados.length === 0) {

                listaUsuarios.innerHTML = `
                    <tr>

                        <td
                            colspan="4"
                            class="text-center text-muted"
                        >
                            Nenhum usuário cadastrado.
                        </td>

                    </tr>
                `;

                return;
            }


            // =====================================
            // MONTA AS LINHAS DA TABELA
            // =====================================

            retorno.dados.forEach(function (usuario) {

                const linha =
                    document.createElement("tr");


                linha.innerHTML = `

                    <td>
                        ${usuario.id}
                    </td>


                    <td>
                        ${usuario.nome}
                    </td>


                    <td>
                        ${usuario.email}
                    </td>


                    <td>

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-primary"
                            title="Editar"
                        >

                            <i class="bi bi-pencil"></i>

                        </button>


                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger"
                            title="Excluir"
                        >

                            <i class="bi bi-trash"></i>

                        </button>

                    </td>

                `;


                listaUsuarios.appendChild(linha);

            });


        } catch (erro) {

            console.error(
                "Erro ao carregar usuários:",
                erro
            );

        }

    }


    // =========================================
    // CADASTRAR USUÁRIO
    // =========================================

    formUsuario.addEventListener(
        "submit",
        async function (event) {

            // Impede o formulário de
            // recarregar a página
            event.preventDefault();


            // Pega os dados do formulário
            const dados =
                new FormData(formUsuario);


            try {

                // Envia para o Controller
                const resposta = await fetch(
                    "controllers/UsuarioController.php",
                    {
                        method: "POST",
                        body: dados
                    }
                );


                // Converte a resposta para JSON
                const retorno =
                    await resposta.json();


                // =================================
                // ERRO
                // =================================

                if (!retorno.sucesso) {

                    mostrarMensagem(
                        retorno.mensagem,
                        "danger"
                    );

                    return;
                }


                // =================================
                // SUCESSO
                // =================================

                mostrarMensagem(
                    retorno.mensagem,
                    "success"
                );


                // Limpa o formulário
                formUsuario.reset();


                // Volta para modo cadastrar
                document.getElementById("acao").value =
                    "cadastrar";

                document.getElementById("id").value =
                    "";


                // =================================
                // ATUALIZA A TABELA
                // =================================

                listarUsuarios();

            } catch (erro) {

                console.error(erro);

                mostrarMensagem(
                    "Erro ao cadastrar usuário.",
                    "danger"
                );

            }

        }
    );


    // =========================================
    // BOTÃO CANCELAR
    // =========================================

    btnCancelar.addEventListener(
        "click",
        function () {

            // Limpa o formulário
            formUsuario.reset();


            // Volta para cadastrar
            document.getElementById("acao").value =
                "cadastrar";

            document.getElementById("id").value =
                "";


            // Esconde mensagem anterior
            mensagem.className =
                "alert d-none mt-3";

            mensagem.textContent = "";

        }
    );


    // =========================================
    // MOSTRAR MENSAGEM
    // =========================================

    function mostrarMensagem(texto, tipo) {

        mensagem.className =
            "alert alert-" + tipo + " mt-3";

        mensagem.textContent =
            texto;

    }


    // =========================================
    // CARREGA OS USUÁRIOS AO ABRIR A PÁGINA
    // =========================================

    listarUsuarios();

});