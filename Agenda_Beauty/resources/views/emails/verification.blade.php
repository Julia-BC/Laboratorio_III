<h1>Olá, {{ $user->nome ?? $user->nomeEmpresa }}!</h1>

<p>Para confirmar seu cadastro, clique no link abaixo:</p>

<p>
    <a href="{{ route('verify.email', ['token' => $user->verification_token]) }}">
        Confirmar meu e-mail
    </a>
</p>

<p>Se não foi você, ignore este e-mail.</p>