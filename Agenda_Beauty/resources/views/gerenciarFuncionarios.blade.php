<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Funcionários</title>
  <link rel="stylesheet" href="style.css">
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
</head>
<body>
  <div class="container">
    <h2>Gerenciar Funcionários</h2>
    
    <a href="cadastrar_funcionario.php" class="btn add-btn">+ Cadastrar Funcionário</a>

    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Telefone</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Conexão com banco de dados
        include('conexao.php');

        $sql = "SELECT * FROM funcionarios";
        $resultado = mysqli_query($conn, $sql);

        while ($linha = mysqli_fetch_assoc($resultado)) {
          echo "<tr>";
          echo "<td>" . $linha['nome'] . "</td>";
          echo "<td>" . $linha['email'] . "</td>";
          echo "<td>" . $linha['telefone'] . "</td>";
          echo "<td>
                  <a href='editar_funcionario.php?id=" . $linha['id'] . "' class='btn'>Editar</a>
                </td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
