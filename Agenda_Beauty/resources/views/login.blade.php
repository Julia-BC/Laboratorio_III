<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family:Georgia, 'Times New Roman', Times, serif, sans-serif;
    }

    body {
        height: auto;
    }

    .container {
        display: flex;
        height: 100vh;
    }

.login-form input[type="email"]::placeholder,
.login-form input[type="password"]::placeholder {
    color: white;
    opacity: 0.6;
}

h2.titulo-login {
    color: white;
    font-size: 24px;
    margin-bottom: 10px;
    text-align: center;
}

.login-form {
    display: flex;
    color: #7f91aa;
    flex-direction: column;
    align-items: center; ;
    justify-content: center;
    width: 100%;
    padding: 30px;
 }

.esqueceu_senha {
    color: #7f91aa;
    width: 320px;
    text-align: right;
    margin-top: -20px;   /* sobe o link */
    margin-bottom: 20px; /* espaço abaixo do link */
}

.esqueceu_senha a {
    color: #b7c3d6;
    text-decoration: none;
    font-size: 15px;
    transition: color 0.2s;
}

.esqueceu_senha a:hover {
    color: white;
    text-decoration: underline;
}

p {
    color: white;
    font-size: 15px;
    text-align: center;
    margin-top: 20px;
}

p a{
    color: #b7c3d6;
    text-decoration: none;
    transition: color 0.2s;
}

p a:hover {
    color: white;
    text-decoration: underline;
}

</style>

<body>
    <div class="container">
        <div class="left-side">
            <img src="imagens/AgendaBeauty.png" alt="Logo Agenda Beauty" class="logo-ab">
        </div>
        <div class="right-side">
            <div class="lotus-wrapper">
                <img src="imagens/florLotus.png" alt="Flor de Lótus" class="logo-lotus">
            </div>
            <h2 class="titulo-login">LOGIN</h2>
            <form action="#" method="post" class="login-form" action="BD/login.php">
                <div>
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                <div>
                <input type="password" name="password" placeholder="Digite sua senha" required>
                </div>
                <div class="esqueceu_senha">
                <a href="esqueceuSenha.html">Esqueceu sua senha?</a>
                </div>
                <div>
                <button type="submit" class="btn">Fazer login</button>
                </div>
            </form>
            <p>Não tem cadastro? <a href="cadastro.html">Clique aqui.</a></p>
        </div>
    </div>
</body>
</html>


