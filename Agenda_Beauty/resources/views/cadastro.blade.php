<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Cadastro Cliente e Empresa</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>

  
    .form-cadastro {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px; /* Espaço entre os inputs */
      width: 100%;
      max-width: 400px;
    }

    .form-cadastro label {
      color: white;
      font-size: 15px;
      margin-bottom: 8px;
    }


    .botoes {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .btn {
      background-color: white;
      color: #3d405b;
      border: #7f91aa 2px solid;
      padding: 15px 10px;
      font-size: 20px;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background-color: #7f91aa;
      color: white;
    }

</style>

<script>
  const clienteRegisterRoute = "{{ route('cliente.register.submit') }}";
  const empresaRegisterRoute = "{{ route('empresa.register.submit') }}";

  function mostrarFormulario() {
    const tipo = document.getElementById('tipo').value;
    const clienteFields = document.querySelectorAll('#form-cliente input');
    const empresaFields = document.querySelectorAll('#form-empresa input');
    const form = document.getElementById('formCadastro');

    if (tipo === 'cliente') {
      document.getElementById('form-cliente').style.display = 'block';
      document.getElementById('form-empresa').style.display = 'none';
      clienteFields.forEach(input => input.required = true);
      empresaFields.forEach(input => input.required = false);
      form.action = clienteRegisterRoute;
    } else if (tipo === 'empresa') {
      document.getElementById('form-cliente').style.display = 'none';
      document.getElementById('form-empresa').style.display = 'block';
      clienteFields.forEach(input => input.required = false);
      empresaFields.forEach(input => input.required = true);
      form.action = empresaRegisterRoute;
    }
  }
  window.onload = mostrarFormulario;
</script>


<!-- Adicionando o SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
   <link rel="shortcut icon" href="{{ asset('imagens/favicon.ico') }}" type="image/x-icon">
</head>


<body>
  <div class="container">
    <div class="left-side">
      <img src="{{ asset('imagens/AgendaBeauty.png') }}" alt="Logo" class="AgendaBeauty">
    </div>

    <div class="right-side">
      <img src="{{ asset('imagens/florLotus.png') }}" alt="Flor de Lótus" class="logo-lotus">
      <h2>Cadastre-se</h2>
      
      <form class="form-cadastro" id="formCadastro" action="{{ route('cliente.register.submit') }}" method="POST">
        @csrf
        <div>
          <label for="tipo">Selecione o tipo de cadastro:</label>
          <select id="tipo" name="tipo" required onchange="mostrarFormulario()">
            <option value="cliente">Cliente</option>
            <option value="empresa">Empresa</option>
          </select>
        </div>
        
  <!-- FORMULÁRIO DO CLIENTE -->
  <div id="form-cliente">
    <input type="text" name="nome" placeholder="Digite seu nome" required>
    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF: 000.000.000-00" required>
    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
    <input type="text" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
    <input type="password" id="senha_confirmation" name="senha_confirmation" placeholder="Confirme sua senha" required>
  </div>
  
  <!-- FORMULÁRIO EMPRESA -->
  <div id="form-empresa" style="display: none;">
    <input type="text" id="nomeEmpresa" name="nomeEmpresa" placeholder="Digite a Razão Social / nome" required>
    <input type="text" id="cnpj" name="cnpj" placeholder="Digite o CNPJ: 00.000.000/0000-00" required>
    <input type="email" id="emailEmpresa" name="emailEmpresa" placeholder="Digite o e-mail da empresa" required>
    <input type="text" id="telefoneEmpresa" name="telefoneEmpresa" placeholder="Digite o telefone da empresa" required>
    <input type="text" id="cep" name="cepEmpresa" placeholder="Digite o CEP" required>
    <input type="text" id="cidade" name="cidadeEmpresa" placeholder="Digite a cidade" required>
    <input type="text" id="bairro" name="bairroEmpresa" placeholder="Digite o bairro" required>
    <input type="text" id="complemento" name="complementoEmpresa" placeholder="Digite o complemento">
    <input type="password" id="senhaEmpresa" name="senhaEmpresa" placeholder="Digite sua senha da empresa" required>
    <input type="password" id="senhaEmpresa_confirmation" name="senhaEmpresa_confirmation" placeholder="Confirme sua senha da empresa" required>
  </div>
  
  <div class="botoes">
    <button type="submit" class="btn">Cadastrar</button>
  </div>
</form>
</div>
</div>

@include('components.alerts') <!-- Incluindo o componente de alertas -->

</body>
</html>
