<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }
        .container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
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
    <h2>Recuperar Senha</h2>

    <form id="forgot-form">
        <label for="email">Digite seu e-mail cadastrado</label>
        <input type="email" name="email" required>

        <button type="submit">Enviar e-mail</button>

        <div id="response" class="message"></div>
    </form>
</div>

<script>
document.getElementById('forgot-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const body = Object.fromEntries(formData.entries());

    const res = await fetch('/api/forgot-password', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
    });

    const msgBox = document.getElementById('response');
    const data = await res.json();

    msgBox.className = res.ok ? 'message' : 'error';
    msgBox.textContent = data.message || 'Erro ao enviar.';
});
</script>
</body>
</html>
