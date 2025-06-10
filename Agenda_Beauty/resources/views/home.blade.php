<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOME AGENDA BEAUTY</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<style>

p {
  color: white;
  font-size: 25px;
  margin-top: 10px;
}

</style>

<body>
  <div class="container">
    <div class="left-side">
      <img src="{{ asset('imagens/AgendaBeauty.png') }}" alt="Logo Agenda Beauty" class="logo-ab">
    </div>
    <div class="right-side">
  <div class="lotus-wrapper">
    <img src="{{ asset('imagens/florLotus.png') }}" alt="Flor de Lótus" class="logo-lotus">
  </div>
  <p>Bem-vinda ao Agenda Beauty.</p>
  <p>Agende seu horário com facilidade</p>
  <p>e aproveite nossos serviços!</p>

  <div class="botoes">
    <a href="{{ route('login') }}"><button class="btn">Fazer login</button></a>
    <a href="{{ route('cadastro') }}"><button class="btn">Cadastre-se</button></a>
  </div>
</div>
    </div>
  </div>
</body>
</html>
