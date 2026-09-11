// LOGIN USANDO JQUERY

$(document).ready(function () {

    // Não se aplica nesta página
    // aplicarMascaras();

    // Configura a validação do formulário
    validarFormulario();

});


function validarFormulario() {

    // Seleciona a div responsável pelas mensagens
    const mensagem = document.getElementById("mensagem");


    // Configura o jQuery Validation
    $("#formLogin").validate({

        // =====================================
        // REGRAS DE VALIDAÇÃO
        // =====================================

        rules: {

            email: {
                required: true,
                email: true,
            },

            senha: {
                required: true,
                minlength: 6,
            },

        },


        // =====================================
        // MENSAGENS DE VALIDAÇÃO
        // =====================================

        messages: {

            email: {
                required: "Informe o e-mail.",
                email: "Informe um e-mail válido.",
            },

            senha: {
                required: "Informe a senha.",
                minlength: "A senha deve possuir no mínimo 6 caracteres.",
            },

        },


        // =====================================
        // POSICIONA A MENSAGEM DE ERRO
        // =====================================

        errorPlacement: function (error, element) {

            element
                .closest(".mb-3")
                .find(".invalid-feedback")
                .text(error.text());

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
        // ENVIA O FORMULÁRIO
        // =====================================

        submitHandler: async function (formulario) {

             event.preventDefault();

            // Captura os dados
            const dados = new FormData(formulario);


            // Exibe mensagem enquanto verifica
            mensagem.className =
                "alert alert-info mt-3";

            mensagem.textContent =
                "Verificando dados...";


            try {

                // =================================
                // ENVIA PARA O CONTROLLER
                // =================================

                const resposta = await fetch(
                    "controllers/LoginController.php",
                    {
                        method: "POST",
                        body: dados,
                    }
                );


                // =================================
                // CONVERTE A RESPOSTA PARA JSON
                // =================================

                const retorno =
                    await resposta.json();


                // =================================
                // LOGIN REALIZADO
                // =================================

                if (retorno.sucesso) {

                    mensagem.className =
                        "alert alert-success mt-3";

                    mensagem.textContent =
                        retorno.mensagem;


                    // Redireciona para a home
                    window.location.href =
                        "index.php?page=home";

                    return;
                }


                // =================================
                // LOGIN INVÁLIDO
                // =================================

                mensagem.className =
                    "alert alert-danger mt-3";

                mensagem.textContent =
                    retorno.mensagem;


            } catch (erro) {

                // =================================
                // ERRO NA REQUISIÇÃO
                // =================================

                console.error(erro);

                mensagem.className =
                    "alert alert-danger mt-3";

                mensagem.textContent =
                    "Erro ao realizar o login.";
            }

        },

    });

}