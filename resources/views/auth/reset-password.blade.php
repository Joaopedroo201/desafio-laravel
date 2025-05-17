<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; }
        .container {
            max-width: 400px; margin: 80px auto; padding: 30px;
            background: #fff; border-radius: 6px; box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 25px; }
        label { font-weight: bold; display: block; margin-top: 12px; }
        input { width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 20px; width: 100%; background: #007bff; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .message, .error { margin-top: 15px; text-align: center; font-weight: bold; }
        .message { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
<div class="container">
    <h2>Redefinir Senha</h2>
    <form id="reset-form">
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email">E-mail</label>
        <input type="email" name="email" required>

        <label for="password">Nova Senha</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Confirmar Nova Senha</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Alterar Senha</button>
        <div id="response" class="message"></div>
    </form>
</div>

<script>
document.getElementById('reset-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const body = Object.fromEntries(formData.entries());

    const res = await fetch('/api/reset-password', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    });

    const responseEl = document.getElementById('response');
    const data = await res.json();

    responseEl.className = res.ok ? 'message' : 'error';
    responseEl.textContent = data.message || 'Erro ao redefinir a senha.';
});
</script>
</body>
</html>
