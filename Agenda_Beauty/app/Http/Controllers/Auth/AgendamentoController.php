<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\Servicos;

class AgendamentoController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        $servicos = Servicos::all();
        $funcionarios = Funcionario::all();

        return view('agendamentos', compact('empresas', 'servicos', 'funcionarios'));
    }

    public function store(Request $request)
{
     $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'servico_nome' => 'required|string',
            'funcionario_nome' => 'nullable|string',
            'data' => 'required|date',
            'hora' => 'required',
        ]);

    // Buscar o serviço pelo nome
        $servico = Servicos::where('nome', $request->servico_nome)->firstOrFail();

        // Buscar o funcionário pelo nome (se não for "Sem preferência")
        $funcionario = null;
        if ($request->funcionario_nome && $request->funcionario_nome !== 'Sem preferência') {
            $funcionario = Funcionario::where('nome', $request->funcionario_nome)->first();
        }

        // Montar data e hora
        $dataHora = $request->data . ' ' . $request->hora;

    Agendamento::create([
            'cliente_id' => Auth::guard('cliente')->id(), // ou outro guard conforme o login
            'servico_id' => $servico->id,
            'funcionario_id' => $funcionario?->id,
            'empresa_id' => $request->empresa_id,
            'data_hora' => $dataHora,
            'status' => 'confirmado',
        ]);

    return redirect()->back()->with('success', 'Agendamento realizado com sucesso!');

    }

   public function mostrarAtendimentos()
    {
        $clienteId = auth()->id(); // ou auth('cliente')->id(); se estiver usando guard específico

        $agendamentos = Agendamento::with(['cliente', 'empresa', 'funcionario', 'servico'])
        ->where('cliente_id', $clienteId)
        ->get();

        return view('atendimentosClientes', compact('agendamentos'));
    }

    public function edit($id)
{
    $agendamento = Agendamento::findOrFail($id);
    $empresas = Empresa::all();
    $servicos = Servicos::all();
    $funcionarios = Funcionario::all();

    return view('editarAgendamento', compact('agendamento', 'empresas', 'servicos', 'funcionarios'));
}

public function update(Request $request, $id)
{
    // Validação dos dados recebidos
    $request->validate([
        'data' => 'required|date',
        'hora' => 'required|date_format:H:i',
        'servico_nome' => 'required|string|max:255',
        'funcionario_nome' => 'nullable|string|max:255',
    ]);

    // Recupera o agendamento
    $agendamento = Agendamento::findOrFail($id);

    // Atualiza o campo data_hora juntando os dois
    $dataHora = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->data . ' ' . $request->hora);
    $agendamento->data_hora = $dataHora;

    // Atualiza o serviço pelo nome (opcional: adaptar para ID se quiser mais robustez)
    if ($request->servico_nome) {
        $servico = Servicos::where('nome', $request->servico_nome)->first();
        if ($servico) {
            $agendamento->servico_id = $servico->id;
        }
    }

    // Atualiza o funcionário pelo nome (pode ser null)
    if ($request->funcionario_nome) {
        $funcionario = Funcionario::where('nome', $request->funcionario_nome)->first();
        if ($funcionario) {
            $agendamento->funcionario_id = $funcionario->id;
        } else {
            $agendamento->funcionario_id = null;
        }
    }

    $agendamento->save();

    return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
}

public function destroy($id)
{
    $agendamento = Agendamento::findOrFail($id);
    $agendamento->delete();

    return redirect()->route('agendamentos.index')->with('success', 'Agendamento excluído com sucesso.');
}
    
}
