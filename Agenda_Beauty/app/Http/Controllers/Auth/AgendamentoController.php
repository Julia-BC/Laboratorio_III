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
}
