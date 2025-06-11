<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu Senha</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Georgia, 'Times New Roman', Times, serif, sans-serif;
    }

    body {
        height: auto;
        background-color: #3d405b;
        color: white;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    .right-side {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 40px 90px  90px;
        background-color: #3d405b;
        flex: 1;
    }


    .form-cadastro {
    margin-top: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
   }

    .login-form input[type="email"]::placeholder{
        color: white;
        opacity: 0.6;

    }

    h2 {
        color: white;
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
    }

    p {
        color: white;
        font-size: 15px;
        text-align: center;
        margin-top: 10px;  
    }

    p a {
        color: #b7c3d6;
        text-decoration: none;
        transition: color 0.2s;
    }

    p a:hover {
        color: white;
    }

</style>

<body>
  <div class="container">
    <div class="left-side">
      <img src="/frontEnd/imagens/AgendaBeauty.png" alt="Logo" class="AgendaBeauty">
    </div>
    <div class="right-side">
      <img src="/frontEnd/imagens/florLotus.png" alt="Flor de Lótus" class="logo-lotus">
      <h2>Recuperação de Senha</h2>
      <form class="form-cadastro" action="/esqueci-senha" method="POST">
        <input type="email" name="email" placeholder="Digite seu e-mail" required>
        <button type="submit" class="btn">Enviar</button>
      </form>
    </div>
  </div>
</body>
</html>
