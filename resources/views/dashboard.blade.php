<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 6px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .logout {
            text-align: right;
            margin-bottom: 20px;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th,
        .user-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .user-table th {
            background-color: #f8f8f8;
        }

        .tag-admin {
            background: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }

        .tag-user {
            background: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logout">
        <button onclick="logout()">Sair</button>
    </div>

    <h2>Usuários Cadastrados</h2>

    <div id="error-msg" class="error"></div>
    <table class="user-table" id="user-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Perfil</th>
            </tr>
        </thead>
        <tbody>
        <!-- usuários aqui -->
        </tbody>
    </table>
</div>

<script>
    const token = localStorage.getItem('token');
    const errorBox = document.getElementById('error-msg');
    const tbody = document.querySelector('#user-table tbody');

    if (!token) {
        window.location.href = '/login';
    }

    fetch('/api/users', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    }).then(async res => {
        const data = await res.json();

        if (!res.ok) {
            errorBox.textContent = data.message || 'Erro ao carregar dados.';
            return;
        }

        data.data.forEach(user => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.city || '-'}</td>
                <td>${user.state || '-'}</td>
                <td><span class="${user.role === 'admin' ? 'tag-admin' : 'tag-user'}">${user.role}</span></td>
            `;
            tbody.appendChild(tr);
        });
    }).catch(() => {
        errorBox.textContent = 'Erro ao carregar dados.';
    });

    function logout() {
        fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        }).finally(() => {
            localStorage.removeItem('token');
            window.location.href = '/login';
        });
    }
</script>
</body>
</html>
