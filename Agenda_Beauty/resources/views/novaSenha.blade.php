<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        padding: 40px 90px 90px;
        background-color: #3d405b;
        flex: 1;
    }

  h2 {
        color: white;
        font-size: 24px;
        margin-bottom: 70px;
        text-align: center;
    }

    .form-cadastro {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
    }

     .input-wrapper {
      display: flex;
      align-items: center;
      position: relative;
      width: 100%;
      max-width: 500px;
      margin-bottom: 20px;
      
    }

    .input-wrapper input {
      display: block;
      width: 100%;
      padding: 8px 5px;
      padding-right: 40px;
      border: none;
      border-bottom:2px solid white;
    }

    .toggle-senha {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: white;
      font-size: 15px;
    }
    
    

</style>

<body>
  <div class="container">
    <div class="left-side">
      <img src="/frontEnd/imagens/AgendaBeauty.png" alt="Logo" class="AgendaBeauty">
    </div>
    <div class="right-side">
      <img src="/frontEnd/imagens/florLotus.png" alt="Flor de Lótus" class="logo-lotus">
      <h2>Nova Senha</h2>
      <form class="form-cadastro" action="/confirmarSenhaNova" method="POST">
        <input type="hidden" name="token" value="{{token}}">

        <div class="input-wrapper">
          <input type="password" id="novaSenha" name="novaSenha" placeholder="Digite sua nova senha" required>
          <i class="fa-solid fa-eye toggle-senha" onclick="toggleSenha('novaSenha', this)"></i>
        </div>

        <div class="input-wrapper">
          <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua nova senha" required>
          <i class="fa-solid fa-eye toggle-senha" onclick="toggleSenha('confirmarSenha', this)"></i>
        </div>

        <button type="submit" class="btn">Confirmar</button>
      </form>
    </div>
  </div>

  <script>
    function toggleSenha(idInput, icon) {
      const input = document.getElementById(idInput);
      const isVisible = input.type === "text";
      input.type = isVisible ? "password" : "text";
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
    }
  </script>
</body>
</html>
