<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $empresaId = auth()->id(); // ou auth('empresa')->id() se for guard separado
        $funcionarios = Funcionario::where('empresa_id', $empresaId)->get();
        return view('gerenciarFuncionarios', compact('funcionarios'));
    }

    public function create()
    {
        return view('empresa.funcionarios.cadastrar');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nome' => 'required|string|max:100',
            'cpf' => 'required|unique:funcionarios,cpf',
            'telefone' => 'required',
            'especialidade' => 'nullable|string',
        ]);

        Funcionario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'especialidade' => $request->especialidade,
            'empresa_id' => auth('empresa')->id(),
        ]);

        return redirect()->route('funcionario.conta')->with('success', 'Funcionário cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $funcionarioEditar = Funcionario::findOrFail($id);
        $funcionarios = Funcionario::where('empresa_id', auth('empresa')->id())->get();
        return view('gerenciarFuncionarios', compact('funcionarios', 'funcionarioEditar'));
    }

    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:100',
            'telefone' => 'required',
            'especialidade' => 'nullable|string',
        ]);

        $funcionario->update($request->only(['nome', 'telefone', 'especialidade']));

        return redirect()->route('funcionario.conta')->with('success', 'Funcionário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        Funcionario::destroy($id);
        return redirect()->back()->with('success', 'Funcionário excluído com sucesso.');
    }
}
