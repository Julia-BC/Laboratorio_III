<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Funcionários</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }
    .container {
      background: white;
      padding: 20px;
      border-radius: 10px;
    }
    h2 {
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }
    .btn {
      padding: 8px 12px;
      border: none;
      background-color: #3d405b;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #5a5d78;
    }
    .add-btn {
      margin-bottom: 10px;
      display: inline-block;
    }
  </style>

  <!-- Adicionando o SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
   <link rel="shortcut icon" href="{{ asset('imagens/favicon.ico') }}" type="image/x-icon">
</head>
<body>
  <div class="container">
    <h2>Gerenciar Funcionários</h2>
    
    <button class="btn add-btn" onclick="document.getElementById('modal').style.display='block'">+ Cadastrar Funcionário</button>

    <div style="background:white; padding:20px; border-radius:10px; width:400px;">
      <h3>Cadastrar Funcionário</h3>
      <form action="{{ route('empresa.funcionarios.cadastrar') }}" method="POST">
        @csrf
        <input type="text" name="nome" placeholder="Nome" required class="info-input"><br><br>
        <input type="text" name="email" placeholder="Email" required class="info-input"><br><br>
        <input type="text" name="telefone" placeholder="Telefone" required class="info-input"><br><br>
        <input type="text" name="cpf" placeholder="CPF" required class="info-input"><br><br>
        <input type="text" name="especialidade" placeholder="Especialidade (opcional)" class="info-input"><br><br>
        <button type="submit" class="btn">Cadastrar</button>
        <button type="button" class="btn" onclick="document.getElementById('modal').style.display='none'">Fechar</button>
      </form>
    </div>

    {{-- Tabela de funcionários --}}
  <table>
    <thead>
      <tr>
        <th>CPF</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @foreach($funcionarios as $funcionario)
      <tr>
        <td>{{ $funcionario->cpf }}</td>
        <td>{{ $funcionario->nome }}</td>
        <td>{{ $funcionario->email }}</td>
        <td>{{ $funcionario->telefone }}</td>
        <td>{{ $funcionario->especialidade }}</td>
        <td>
          <a href="{{ route('empresa.funcionarios.editar', $funcionario->id) }}" class="btn">Editar</a>
        </td>
        <td
        <form action="{{ isset($funcionarioEditar) ? route('empresa.funcionarios.atualizar', $funcionarioEditar->id) : route('empresa.funcionarios.cadastrar') }}" method="POST">
    @csrf
    
          <form action="{{ route('empresa.funcionarios.excluir', $funcionario->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" onclick="return confirm('Deseja realmente excluir?')">Excluir</button>
          </form>
        </td>
        </tr>
      @endforeach
    </tbody>
  </table>
        <!-- <?php
        // Conexão com banco de dados
        // include('conexao.php');

        // $sql = "SELECT * FROM funcionarios";
        // $resultado = mysqli_query($conn, $sql);

        // while ($linha = mysqli_fetch_assoc($resultado)) {
        //   echo "<tr>";
        //   echo "<td>" . $linha['nome'] . "</td>";
        //   echo "<td>" . $linha['email'] . "</td>";
        //   echo "<td>" . $linha['telefone'] . "</td>";
        //   echo "<td>
        //           <a href='editar_funcionario.php?id=" . $linha['id'] . "' class='btn'>Editar</a>
        //         </td>";
        //   echo "</tr>";
        // }
        // ?> -->
      </tbody>
    </table>
  </div>

  @include('components.alerts') <!-- Incluindo o componente de alertas -->

</body>
</html>
