<p>Olá,</p>
<p>Você solicitou recuperação de senha. Clique no link abaixo para redefinir sua senha:</p>
<p><a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}">Redefinir senha</a></p>
<p>Se você não solicitou, ignore este email.</p>
