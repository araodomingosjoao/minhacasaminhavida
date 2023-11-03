<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Seu Código de Verificação</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-top: 0;
        }
        .greeting {
            color: #777;
            font-size: 18px;
        }
        .instructions {
            color: #555;
            font-size: 16px;
            margin-top: 30px;
        }
        .verification-code {
            color: #0066cc;
            font-size: 40px;
            margin-top: 10px;
        }
        .note {
            color: #777;
            font-size: 16px;
            margin-top: 20px;
        }
        .thanks {
            color: #333;
            font-size: 18px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recebemos o seu pedido para verificar o seu email</h1>
        <p class="greeting">Olá,</p>
        <p class="instructions">Seu codigo de confirmação MinhaCasaMinhaVida:</p>
        <h2 class="verification-code">{{ $code }}</h2>
        <p class="note">Utilize este código para realizar a verificação.</p>
        <p class="thanks">Obrigado!</p>
    </div>
</body>
</html>
