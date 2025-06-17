<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home Cliente</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<style>
    .flor-lotus {
      width: 100px;
      height: 100px;
      margin-bottom: 20px;
    }
    .container {
      display: flex;
      height: 100vh;
    }

    .left-side {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .right-side {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background-color: #3d405b;
      color: white;
      padding: 20px;
    }

    p {
      font-size: 20px;
      margin-bottom: 10px;
    }

    h2 {
      font-size: 18px;
      margin-bottom: 20px;
    }

    .btn {
      background-color: white;
      color: #3d405b;
      border: #7f91aa 2px solid;
      padding: 15px 10px;
      font-size: 18px;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 200px;

    }

    .foto-perfil {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: contain;
      padding: 15px;
      background: #fff;
      border: 3px solid #7f91aa;
      cursor: pointer; /* opcional para indicar que é clicável */
}

</style>
</head>
<body>
  <div class="container">
    <div class="left-side">
      <img src=" {{ asset('imagens/AgendaBeauty.png') }}" alt="Logo" class="AgendaBeauty" />
    </div>

    <div class="right-side">
      <img src="{{ asset('imagens/florLotus.png') }}" alt="Flor de Lótus" class="logo-lotus" />
      <p>Bem-vinda ao Agenda Beauty</p>
      <h2>Olá, {{ $Cliente->nome }}</h2>

      <div class="foto-perfil">
        <form action="{{ route('cliente.uploadFoto') }}" method="post" enctype="multipart/form-data">
          @csrf
          <label for="fotoInput">
            <img src="{{ $Cliente->foto_perfil ? asset('storage/' . $Cliente->foto_perfil) : asset('imagens/cameraFotoPerfil.png') }}" alt="Foto de perfil" class="foto-perfil" />
          </label>
          <input type="file" name="nova_foto" id="fotoInput" style="display: none;" onchange="this.form.submit()"/>
        </form>
      </div>
      <div class="botoes">
         <a href="{{ route('cliente.conta') }}"><button class="btn"> Minha Conta</button></a>
        <a href="{{ route('agendamentos') }}"><button class="btn">Agendar Atendimento</button></a>
        <button class="btn">Meus Atendimentos</button>
        <a href="{{ route('login') }}"><button class="btn">Sair</button></a>
        </div>
    </div>
  </div>
</body>
</html>
