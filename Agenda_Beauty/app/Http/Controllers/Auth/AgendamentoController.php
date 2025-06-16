<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
}
