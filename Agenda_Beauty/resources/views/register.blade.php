<h2>Cadastro</h2>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('register.form') }}" method="POST">
    @csrf

    <label>Tipo:</label>
    <select name="tipo" id="tipo" onchange="toggleCampos()" required>
        <option value="">Selecione...</option>
        <option value="cliente">Cliente</option>
        <option value="empresa">Empresa</option>
    </select><br><br>

    <div id="clienteCampos" style="display: none;">
        <label>Nome:</label>
        <input type="text" name="nome_cliente"><br>
        <label>CPF:</label>
        <input type="text" name="cpf"><br>
    </div>

    <div id="empresaCampos" style="display: none;">
        <label>Razão Social:</label>
        <input type="text" name="razao_social"><br>
        <label>CNPJ:</label>
        <input type="text" name="cnpj"><br>
    </div>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Senha:</label>
    <input type="password" name="password" required><br>

    <label>Confirmar senha:</label>
    <input type="password" name="password_confirmation" required><br>

    <button type="submit">Cadastrar</button>
</form>

<script>
function toggleCampos() {
    const tipo = document.getElementById('tipo').value;
    document.getElementById('clienteCampos').style.display = tipo === 'cliente' ? 'block' : 'none';
    document.getElementById('empresaCampos').style.display = tipo === 'empresa' ? 'block' : 'none';
}
</script>
