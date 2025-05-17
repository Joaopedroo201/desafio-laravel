<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recuperação de Senha</title>
</head>
<body>
    <h2>Olá {{ $user->name }},</h2>
    <p>Recebemos uma solicitação para redefinir sua senha.</p>
    <p>
        Clique no link abaixo para redefinir:
        <br>
        <a href="{{ url('/reset-password/'.$token) }}">Redefinir senha</a>
    </p>
    <p>Se você não solicitou, ignore este e-mail.</p>
</body>
</html>
