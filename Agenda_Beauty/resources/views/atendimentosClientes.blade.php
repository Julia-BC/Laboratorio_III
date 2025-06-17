<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Atendimentos</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
    
  <style>
  table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  color: white;
  font-size: 1rem;
  }

table th, table td {
  padding: 12px 15px;
  text-align: center;
  border-bottom: 1px solid #b7c3d6;
}

table th {
  background-color: #7f91aa;
  color: white;
}

table tr:nth-child(even) {
  background-color: #4a4e69;
}

table tr:hover {
  background-color: #6c708d;
}

td {
  vertical-align: middle;
}

.acoes {
  display: flex;
  gap: 8px;
  justify-content: center;
  align-items: center;
  padding: 38px;
}

.btn {
  padding: 6px 14px;
  font-size: 0.9rem;
  border-radius: 8px;
  border: none;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease, color 0.3s ease;
  text-decoration: none;
  display: inline-block;
}

.btn-editar {
  background-color: white;
  color: #3d405b;
  border: 2px solid #7f91aa;
}

.btn-editar:hover {
  background-color: #7f91aa;
  color: white;
}

.btn-excluir {
  background: #ff0000;
  color: white;
  border: none;
}

.btn-excluir:hover {
  background-color: #c0392b;
}

form .btn {
  padding: 6px 14px;
  background-color: #e74c3c;
  color: white;
  border: 2px solid #c0392b;
  border-radius: 8px;
}

form .btn:hover {
  background-color: #c0392b;
}

</style>
<body>
  <div class="container">
    <div class="left-side">
      <img src="{{ asset('imagens/AgendaBeauty.png') }}" alt="Logo" class="AgendaBeauty">
    </div>
    <div class="right-side">
      <img src="{{ asset('imagens/florLotus.png') }}" alt="Flor de Lótus" class="logo-lotus">
      <h2>Meus Atendimentos</h2>
      <div class="perfil"></div>
      <table>
        <thead>
          <tr>
            <th>Cliente</th>
                        <th>Funcionário</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td>{{ optional($agendamento->cliente)->nome ?? 'N/A' }}</td>
                            <td>{{ optional($agendamento->funcionario)->nome ?? 'Sem preferência' }}</td>
                            <td>{{ optional($agendamento->servico)->nome ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->data_hora)->format('H:i') }}</td>
                            
                            <td class="acoes">
                              <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="btn btn-editar">Editar</a>
                              
                              <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">Excluir</button>
                              </form>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>