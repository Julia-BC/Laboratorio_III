<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Conta Empresa</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
      .right-side {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 40px 90px 90px;
        background-color: #3d405b;
        flex: 1;
      }
      .perfil {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px;
      }
      .foto-perfil {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: contain;
        padding: 15px;
        background: #fff;
        border: 3px solid #7f91aa;
      }
      .perfil span {
        color: white;
        font-size: 20px;
        margin-bottom: 10px;
      }
      .form-cadastro {
        width: 100%;
        max-width: 400px;
        display: flex;
        flex-direction: column;
        gap: 24px;
      }
      .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
        color: white;
      }
      .info-item label {
        font-size: 16px;
        color: #b7c3d6;
      }
      .info-input {
        background: transparent;
        color: white;
        border: none;
        border-bottom: 2px solid #7f91aa;
        font-size: 16px;
        padding: 8px 5px;
        outline: none;
        width: 100%;
        box-sizing: border-box;
      }
      .btn {
        background-color: white;
        color: #3d405b;
        border: #7f91aa 2px solid;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
        text-decoration: none;
        text-align: center;
        min-width: 120px;
        width: 200px;
      }
      .btn.danger {
        background: red;
        color: white;
        border: none;
      }
      .btn.danger:hover {
        background-color: darkred;
        color: white;
        border: none;
        transition: all 0.5s ease;
        text-decoration: none;
      }
      .action-buttons {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: 50px;
      }
    </style>
<body>
    <body>
  <div class="container">
    <div class="left-side">
      <img src="/frontEnd/imagens/AgendaBeauty.png" alt="Logo" class="AgendaBeauty">
    </div>
    <div class="right-side">
      <img src="/frontEnd/imagens/florLotus.png" alt="Flor de Lótus" class="logo-lotus">
      <h2>Gerenciar Minha Conta Empresarial</h2>
      <div class="perfil">
        <label for="upload-foto">
          <img src="/frontEnd/imagens/cameraFotoPerfil.png" alt="Foto de perfil" class="foto-perfil" />
        </label>
        <input type="file" id="upload-foto" name="foto_perfil" accept="image/*" style="display: none;" />
        <span><?php echo $cliente['nome'];?>Nome Empresa</span>
      </div>
      <form class="form-cadastro" action="atualizar-conta.php" method="POST" enctype="multipart/form-data"> 
        <div class="info-item">
          <label for="email-input">Email:</label>
          <input type="email" name="email" id="email-input" class="info-input" value="<?php echo $cliente['email']; ?>">
        </div>
        <!-- Telefone -->
        <div class="info-item">
          <label for="telefone-input">Telefone:</label>
          <input type="text" name="telefone" id="telefone-input" class="info-input" value="<?php echo $cliente['telefone']; ?>">
        </div>
        <!-- CEP -->
        <div class="info-item">
          <label for="cepEmpresa-input">CEP:</label>
          <input type="text" name="endereco" id="endereco-input" class="info-input" value="<?php echo $cliente['endereco']; ?>">
        </div>
        <!--Cidade-->
        <div class="info-item">
          <label for="cidade-input">Cidade:</label>
          <input type="text" name="cidade" id="cidade-input" class="info-input" value="<?php echo $cliente['cidade']; ?>">
        </div>
        <!--Bairro-->
        <div class="info-item">
          <label for="bairro-input">Bairro:</label>
          <input type="text" name="bairro" id="bairro-input" class="info-input" value="<?php echo $cliente['bairro']; ?>">
        </div>
        <!--Complemeto (opcional)-->
        <div class="info-item">
          <label for="complemento-input">Complemento (opcional):</label>
          <input type="text" name="complemento" id="complemento-input" class="info-input" value="<?php echo $cliente['complemento']; ?>">
        <!-- Troca de senha segura -->
        <div class="info-item">
          <label for="senha-atual-input">Senha atual:</label>
          <input type="password" name="senha_atual" id="senha-atual-input" class="info-input" placeholder="******">
        </div>
        <div class="info-item">
          <label for="nova-senha-input">Nova senha:</label>
          <input type="password" name="nova_senha" id="nova-senha-input" class="info-input" placeholder="******">
        </div>
        <div class="info-item">
          <label for="confirma-senha-input">Confirmar nova senha:</label>
          <input type="password" name="confirma_senha" id="confirma-senha-input" class="info-input" placeholder="*****">
        </div>
        <div class="action-buttons">
          <button type="submit" class="btn">Salvar</button>
          <a href="excluir-conta.php" class="btn danger">Excluir Cadastro</a> <!-- Link para exclusão de conta -->
        </div>
      </form>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const inputFoto = document.getElementById('upload-foto');
      const imagemPerfil = document.querySelector('.foto-perfil');
      inputFoto.addEventListener('change', function () {
        const arquivo = this.files[0];
        if (arquivo) {
          const leitor = new FileReader();
          leitor.onload = function (e) {
            imagemPerfil.src = e.target.result;
          };
          leitor.readAsDataURL(arquivo);
        }
      });
    });
  </script>
</body>
</html>
