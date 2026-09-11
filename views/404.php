<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Página não encontrada</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;

            display: flex;
            align-items: center;
            justify-content: center;

            min-height: 100vh;
        }

        .erro-404 {
            text-align: center;
            padding: 30px;
        }

        .erro-404 img {
            width: 100%;
            max-width: 500px;
            margin-bottom: 20px;
        }

        .erro-404 h2 {
            margin-bottom: 10px;
        }

        .erro-404 p {
            color: #666;
            margin-bottom: 20px;
        }

        .erro-404 a {
            display: inline-block;
            padding: 10px 20px;

            background-color: #0d6efd;
            color: white;

            text-decoration: none;
            border-radius: 5px;
        }

        .erro-404 a:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>

<body>

    <div class="erro-404">

        <img
            src="assets/img/erro-404.png"
            alt="Erro 404"
        >

        <h2>Página não encontrada</h2>

        <p>
            A página que você tentou acessar não existe.
        </p>

        <a href="index.php?page=home">
            Voltar para o início
        </a>

    </div>

</body>

</html>