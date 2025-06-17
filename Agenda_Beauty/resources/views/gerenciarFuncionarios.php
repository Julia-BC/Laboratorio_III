<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Funcionários</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body {
      background-color: #3d405b;
      color: white;
    }
    .container {
      display: flex;
      min-height: 100vh;
    }
    .left-side {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #7f91aa;
    }
    .right-side {
      flex: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: #3d405b;
      padding: 40px 20px;
    }
    h2 {
      color: white;
      margin-bottom: 30px;
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
      margin: 10px 5px 10px 0;
      text-decoration: none;
      text-align: center;
      min-width: 100px;
    }
    .btn.danger {
      background: red;
      color: white;
      border: none;
    }
    .btn.danger:hover {
      background-color: darkred;
    }
    table {
      width: 100%;
      max-width: 700px;
      border-collapse: collapse;
      margin-top: 20px;
      background: #4a4e69;
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 10px;
      text-align: left;
    }
    th {
      background: #7f91aa;
      color: #fff;
    }
    tr:nth-child(even) {
      background: #3d405b;
    }
    tr:nth-child(odd) {
      background: #4a4e69;
    }
    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.5);
      align-items: center;
      justify-content: center;
    }
    .modal.active {
      display: flex;
    }
    .modal-content {
      background: #fff;
      color: #3d405b;
      padding: 30px 20px;
      border-radius: 12px;
      min-width: 300px;
      max-width: 90vw;
      box-shadow: 0 2px 16px rgba(0,0,0,0.2);
      display: flex;
      flex-direction: column;
      gap: 16px;
      position: relative;
    }
    .modal-content label {
      color: #3d405b;
      font-weight: bold;
      margin-top: 0;
    }
    .modal-content input[type="text"],
    .modal-content input[type="email"] {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #7f91aa;
      font-size: 1rem;
      margin-bottom: 10px;
      color: #3d405b;
      background: #f5f6fa;
    }
    .checkbox-group {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 10px;
    }
    .checkbox-group label {
      font-weight: normal;
      color: #3d405b;
      margin: 0;
    }
    .close-modal {
      position: absolute;
      top: 10px; right: 15px;
      background: none;
      border: none;
      font-size: 22px;
      color: #3d405b;
      cursor: pointer;
    }
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
      }
      .left-side, .right-side {
        width: 100%;
      }
      .right-side {
        padding: 20px 5px;
      }
      table {
        font-size: 14px;
      }
    }

  </style>
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
      <h2>Gerenciar Funcionários</h2>
      <button class="btn" onclick="abrirModal()">Adicionar Funcionário</button>
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Cargos</th>
            <th>Email</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="lista-funcionarios">
          @forelse($funcionarios as $funcionario)
            <tr>
              <td>{{ $funcionario->nome }}</td>
              <td>{{ $funcionario->especialidade }}</td>
              <td>{{ $funcionario->email }}</td>
              <td>
                <button class="btn" onclick="editarFuncionario('{{ $funcionario->id }}', '{{ $funcionario->nome }}', '{{ $funcionario->especialidade }}', '{{ $funcionario->email }}')">Editar</button>
                <form action="{{ route('empresa.funcionarios.excluir', $funcionario->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn danger">Excluir</button>
                </form>
              </td>
            </tr>
          @empty
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal" id="modal-funcionario">
    <div class="modal-content">
      <button class="close-modal" onclick="fecharModal()">×</button>
      <h3 id="titulo-modal">Cadastrar Funcionário</h3>
      <form id="form-funcionario" action="{{ route('empresa.funcionarios.cadastrar') }}" method="POST">
        @csrf
        <input type="hidden" id="edit-id" name="id">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label>Cargos:</label>
        <div class="checkbox-group" id="cargos-checkboxes">
          <label><input type="checkbox" name="cargo[]" value="Cabeleireira"> Cabeleireira</label>
          <label><input type="checkbox" name="cargo[]" value="Manicure"> Manicure</label>
          <label><input type="checkbox" name="cargo[]" value="Pedicure"> Pedicure</label>
          <label><input type="checkbox" name="cargo[]" value="Depiladora"> Depiladora</label>
          <label><input type="checkbox" name="cargo[]" value="Maquiadora"> Maquiadora</label>
          <label><input type="checkbox" name="cargo[]" value="Esteticista"> Esteticista</label>
        </div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div style="display: flex; gap: 10px; margin-top: 10px;">
          <button type="submit" class="btn">Salvar</button>
          <button type="button" class="btn danger" onclick="fecharModal()">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
  <script>
    function abrirModal() {
      document.getElementById('modal-funcionario').classList.add('active');
      document.getElementById('form-funcionario').reset();
      document.getElementById('edit-id').value = '';
      document.getElementById('titulo-modal').innerText = 'Cadastrar Funcionário';
      document.querySelectorAll('#cargos-checkboxes input[type="checkbox"]').forEach(cb => cb.checked = false);
    }

    function editarFuncionario(id, nome, especialidade, email) {
      document.getElementById('modal-funcionario').classList.add('active');
      document.getElementById('nome').value = nome;
      document.getElementById('email').value = email;
      const especialidades = especialidade.split(',').map(e => e.trim());
      document.querySelectorAll('#cargos-checkboxes input[type="checkbox"]').forEach(cb => {
        cb.checked = especialidades.includes(cb.value);
      });
      document.getElementById('titulo-modal').innerText = 'Editar Funcionário';
      document.getElementById('form-funcionario').action = `{{ route('empresa.funcionarios.atualizar', ['id' => ':id']) }}`.replace(':id', id);
      document.getElementById('edit-id').value = id;
      let methodInput = document.querySelector('input[name="_method"]');
      if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        document.getElementById('form-funcionario').appendChild(methodInput);
      }
    }

    function fecharModal() {
      document.getElementById('modal-funcionario').classList.remove('active');
    }

    document.querySelectorAll('.btn.danger[type="submit"]').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Tem certeza?',
          text: 'Deseja realmente excluir este funcionário?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#7f91aa',
          confirmButtonText: 'Sim, excluir!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            this.form.submit();
          }
        });
      });
    });
  </script>

  @include('components.alerts') <!-- Incluindo o componente de alertas -->

</body>
</html>