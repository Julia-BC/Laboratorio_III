<p>Olá,</p>
<p>Você solicitou recuperação de senha. Clique no link abaixo para redefinir sua senha:</p>
<p><a href="{{ url('/resetar-senha/' . $token . '?email=' . urlencode($email)) }}">Redefinir senha</a></p>
<p>Se você não solicitou, ignore este email.</p>
