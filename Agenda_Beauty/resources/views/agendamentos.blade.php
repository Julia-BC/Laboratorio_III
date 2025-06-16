<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Agendamento Completo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <style>
    body {
      background-color: #3d405b;
      color: white;
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
      background-color: #7f91aa;
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
    h2 {
      color: white;
      margin-bottom: 20px;
    }
    label {
      color: #b7c3d6;
      font-weight: bold;
      margin-top: 15px;
    }
    select, input[type="date"], input[type="time"] {
      width: 100%;
      padding: 10px;
      font-size: 1rem;
      margin-bottom: 15px;
      border-radius: 0px;
      border: none;
      border-bottom: 2px solid white;
      background: transparent;
      color: white;
      outline: none;
    }
    select option {
      color: #3d405b;
    }
    .btn, button {
      background-color: white;
      color: #3d405b;
      border: #7f91aa 2px solid;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      text-decoration: none;
      text-align: center;
      min-width: 120px;
    }
    button:hover, .btn:hover {
      background-color: #7f91aa;
      color: white;
      border: #3d405b 2px solid;
    }
    .summary {
      background: #7f91aa;
      padding: 15px;
      border-radius: 6px;
      font-size: 1rem;
      line-height: 1.4;
      color: white;
    }
    .buttons {
      display: flex;
      gap: 16px;
      justify-content: flex-end;
      width: 100%;
      margin-top: 10px;
    }
    .step {
      display: none;
      width: 100%;
      max-width: 400px;
    }
    .step.active {
      display: block;
    }
    .logo-lotus {
      width: 180px;
      margin-bottom: 20px;
    }
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
      }
      .left-side, .right-side {
        flex: none;
        width: 100%;
        min-height: unset;
      }
      .right-side {
        padding: 20px 10px;
      }
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
      <h2>Agendamento de Serviço</h2>
      <!-- Step 1: Selecionar salão -->
      <div class="step active" id="step-1">
        <label for="salao">Selecione o Salão:</label>
        <select id="salao">
          <option value="">escolha um salão:</option>
          @foreach ($empresas as $empresa)
          <option value="{{ $empresa->id }}" data-nome="{{ $empresa->nome }}">{{ $empresa->nome }}</option>
          @endforeach
        </select>
        <div class="buttons">
          <div></div>
          <button type="button" class="btn" onclick="nextStep()">Próximo</button>
        </div>
      </div>
      <!-- Step 2: Selecionar serviço -->
      <div class="step" id="step-2">
        <label for="servico">Escolha o Serviço:</label>
        <select id="servico">
          @foreach ($servicos as $servico)
            <option value="{{ $servico->nome }}" data-duracao="{{ $servico->duracao }} min" data-valor="R${{ $servico->preco }}">
            {{ $servico->nome }} - {{ $servico->duracao }} min - R${{ $servico->preco }}
            </option>
          @endforeach
        </select>
        <div class="buttons">
          <button type="button" class="btn" onclick="prevStep()">Voltar</button>
          <button type="button" class="btn" onclick="nextStep()">Próximo</button>
        </div>
      </div>
      <!-- Step 3: Selecionar profissional -->
      <div class="step" id="step-3">
        <label for="profissional">Escolha o Profissional:</label>
        <select id="profissional">
          <option value="">escolha um profissional*</option>
          <option value="Sem preferência">Sem preferência</option>
        @foreach ($funcionarios as $func)
          <option value="{{ $func->nome }}">{{ $func->nome }}</option>
        @endforeach
        </select>
        <div class="buttons">
          <button type="button" class="btn" onclick="prevStep()">Voltar</button>
          <button type="button" class="btn" onclick="nextStep()">Próximo</button>
        </div>
      </div>
      <!-- Step 4: Escolher data e hora -->
      <div class="step" id="step-4">
        <label for="data">Data:</label>
        <input type="date" id="data" min="" />
        <label for="hora">Hora:</label>
        <select id="hora">
          <option value="">escolha a hora</option>
          <option value="09:00">09:00</option>
          <option value="10:00">10:00</option>
          <option value="11:00">11:00</option>
          <option value="14:00">14:00</option>
          <option value="15:00">15:00</option>
          <option value="16:00">16:00</option>
        </select>
        <div class="buttons">
          <button type="button" class="btn" onclick="prevStep()">Voltar</button>
          <button type="button" class="btn" onclick="nextStep()">Próximo</button>
        </div>
      </div>
      <!-- Step 5: Confirmação -->
      <div class="step" id="step-5">
        <h3>Confirme seu agendamento:</h3>
        <div class="summary" id="resumo"></div>
        <div class="buttons">
          <button type="button" class="btn" onclick="prevStep()">Voltar</button>
          <button type="button" class="btn" onclick="confirmar()">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Controla o passo atual
    let currentStep = 1;

    // Define data mínima para hoje no campo data
    document.addEventListener('DOMContentLoaded', function () {
      const dataInput = document.getElementById('data');
      if (dataInput) {
        dataInput.min = new Date().toISOString().split('T')[0];
      }
      showStep(currentStep);
    });

    function showStep(step) {
      document.querySelectorAll('.step').forEach((div) => {
        div.classList.remove('active');
      });
      document.getElementById(`step-${step}`).classList.add('active');
    }

    function nextStep() {
      if (!validarStep(currentStep)) return;
      if (currentStep < 5) {
        currentStep++;
        if (currentStep === 5) {
          preencherResumo();
        }
        showStep(currentStep);
      }
    }

    function prevStep() {
      if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
      }
    }

    function validarStep(step) {
      if (step === 1) {
        const salao = document.getElementById('salao').value;
        if (!salao) {
          alert('Por favor, selecione um salão.');
          return false;
        }
      }
      if (step === 2) {
        const servico = document.getElementById('servico').value;
        if (!servico) {
          alert('Por favor, selecione um serviço.');
          return false;
        }
      }
      if (step === 3) {
        const profissional = document.getElementById('profissional').value;
        if (!profissional) {
          alert('Por favor, selecione um profissional.');
          return false;
        }
      }
      if (step === 4) {
        const data = document.getElementById('data').value;
        const hora = document.getElementById('hora').value;
        if (!data || !hora) {
          alert('Por favor, selecione data e hora.');
          return false;
        }
      }
      return true;
    }

    function preencherResumo() {
      const salaoSelect = document.getElementById('salao');
      const servicoSelect = document.getElementById('servico');
      const profissionalSelect = document.getElementById('profissional');
      const dataInput = document.getElementById('data');
      const horaSelect = document.getElementById('hora');

      const salaoNome = salaoSelect.options[salaoSelect.selectedIndex].dataset.nome;
      const servicoNome = servicoSelect.value;
      const duracao = servicoSelect.options[servicoSelect.selectedIndex].dataset.duracao;
      const valor = servicoSelect.options[servicoSelect.selectedIndex].dataset.valor;
      const profissional = profissionalSelect.value;
      const data = dataInput.value;
      const hora = horaSelect.value;

      document.getElementById('resumo').innerHTML = `
        <strong>Salão:</strong> ${salaoNome} <br/>
        <strong>Serviço:</strong> ${servicoNome} (${duracao}) - ${valor} <br/>
        <strong>Profissional:</strong> ${profissional} <br/>
        <strong>Data:</strong> ${data} <br/>
        <strong>Hora:</strong> ${hora}
      `;
    }

    function confirmar() {
      alert('Agendamento confirmado! Muito obrigado.');
      // Aqui você pode enviar os dados para o backend via fetch/ajax ou formulário
      // Para exemplo, só vamos resetar o formulário:
      currentStep = 1;
      showStep(currentStep);
      document.getElementById('salao').value = '';
      document.getElementById('servico').value = '';
      document.getElementById('profissional').value = '';
      document.getElementById('data').value = '';
      document.getElementById('hora').value = '';
    }
  </script>
</body>
</html>
