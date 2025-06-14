<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha conta-Cliente</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
</head>
<body>
  <div class="container">
    <div class="left-side">
      <img src="{{ asset('imagens/AgendaBeauty.png') }}" alt="Logo" class="AgendaBeauty">
    </div>
    <div class="right-side">
      <img src="{{ asset('imagens/florLotus.png') }}" alt="Flor de Lótus" class="logo-lotus">
      <h2>Gerenciar Minha Conta</h2>
      <div class="perfil">
        <label for="upload-foto">
          <img src="{{ $Cliente->foto_perfil ? asset('storage/' . $Cliente->foto_perfil) : asset('imagens/cameraFotoPerfil.png') }}" alt="Foto de perfil" class="foto-perfil" />
        </label>
        <input type="file" id="upload-foto" name="foto_perfil" accept="image/*" style="display: none;" />
        <span>{{ $Cliente->nome }}</span>
      </div>
      <form class="form-cadastro" action="{{ route('cliente.conta.atualizar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- CPF -->
        <div class="info-item">
          <label for="cpf-input">CPF:</label>
          <input type="text" name="cpf" id="cpf-input" class="info-input" value="{{ $Cliente->cpf }}" readonly>
        </div>

        <!-- Email -->
        <div class="info-item">
          <label for="email-input">Email:</label>
          <input type="email" name="email" id="email-input" class="info-input" value="{{ old('email', $Cliente->email) }}">
          @error('email')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <!-- Telefone -->
        <div class="info-item">
          <label for="telefone-input">Telefone:</label>
          <input type="text" name="telefone" id="telefone-input" class="info-input" value="{{ old('telefone', $Cliente->telefone) }}">
          @error('telefone')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <!-- Troca de senha segura -->
        <div class="info-item">
          <label for="senha-atual-input">Senha atual:</label>
          <input type="password" name="senha_atual" id="senha-atual-input" class="info-input" placeholder="******">
          @error('senha_atual')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="info-item">
          <label for="nova-senha-input">Nova senha:</label>
          <input type="password" name="nova_senha" id="nova-senha-input" class="info-input" placeholder="******">
          @error('nova_senha')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="info-item">
          <label for="confirma-senha-input">Confirmar nova senha:</label>
          <input type="password" name="confirma_senha" id="confirma-senha-input" class="info-input" placeholder="*****">
          @error('confirma_senha')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </form>

        <div class="action-buttons">
          <button type="submit" class="btn">Salvar</button>
          <form action="{{ route('cliente.conta.excluir') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn danger" ">Excluir Cadastro</button> <!-- Linexclusão de conta -->
          </form>
        </div>
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








