<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; margin-bottom: 25px; }
        label { font-weight: bold; display: block; margin-top: 12px; }
        input { width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 20px; width: 100%; background: #28a745; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; margin-top: 10px; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2>Cadastro</h2>

    <form id="register-form">
        <label>Nome</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Senha</label>
        <input type="password" name="password" required>

        <label>Confirmar senha</label>
        <input type="password" name="password_confirmation" required>

        <label>CEP</label>
        <input type="text" name="cep" id="cep" required>

        <label>Número</label>
        <input type="text" name="number" required>

        <button type="submit">Cadastrar</button>

        <div class="error" id="error-msg"></div>
    </form>

    <div style="text-align: center; margin-top: 15px;">
        <a href="/login">Já tem conta? Entrar</a>
    </div>
</div>

<script>
document.getElementById('register-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const body = Object.fromEntries(formData.entries());

    const res = await fetch('/api/register', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
    });

    const data = await res.json();

    if (res.ok) {
        localStorage.setItem('token', data.token);
        window.location.href = '/dashboard';
    } else {
        const msg = data?.message || 'Erro ao cadastrar.';
        document.getElementById('error-msg').textContent = msg;
    }
});
</script>
</body>
</html>
