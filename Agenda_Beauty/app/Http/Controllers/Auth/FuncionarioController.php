<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $empresaId = auth('empresa')->id(); // ou auth('empresa')->id() se for guard separado
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
            'cargo' => 'nullable|array',
            'email' => 'required|email|unique:funcionarios,email',
        ]);

        $especialidade = $request->cargo ? implode(', ', $request->cargo) : null;

        Funcionario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'especialidade' => $especialidade,
            'empresa_id' => auth('empresa')->id(),
        ]);

        return redirect()->route('funcionario.conta')->with('success', 'Funcionário cadastrado com sucesso.');
    }

    public function edit($id)
{
    $funcionario = Funcionario::where('id', $id)->where('empresa_id', auth('empresa')->id())->firstOrFail();
    return response()->json($funcionario);
}

    public function atualizar(Request $request, $id)
{
    $funcionario = Funcionario::findOrFail($id);
    $funcionario->nome = $request->nome;
    $funcionario->email = $request->email;
    $funcionario->especialidade = implode(', ', $request->input('cargo', []));
    $funcionario->save();

    return redirect()->back()->with('success', 'Funcionário atualizado com sucesso!');
}

    public function update(Request $request, $id)
{
    $funcionario = Funcionario::findOrFail($id);

    $request->validate([
        'nome' => 'required|string|max:100',
        'email' => 'required|email|unique:funcionarios,email,' . $id,
        'cargo' => 'nullable|array',
    ]);

    $funcionario->update([
        'nome' => $request->nome,
        'email' => $request->email,
        'especialidade' => $request->cargo ? implode(', ', $request->cargo) : $funcionario->especialidade,
    ]);

    return redirect()->back()->with('success', 'Funcionário atualizado com sucesso!');
}

    public function destroy($id)
{
    $funcionario = Funcionario::where('id', $id)->where('empresa_id', auth('empresa')->id())->firstOrFail();
    $funcionario->delete();
    return redirect()->back()->with('success', 'Funcionário excluído com sucesso.');
}
}
