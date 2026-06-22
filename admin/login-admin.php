<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura Bela - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=3">
</head>
<body class="admin-login-body">

    <div class="logo-text">Aura Bela</div>

    <div class="auth-card">
        <h1 class="auth-title">Área Admin</h1>
        <p class="auth-subtitle">Acesso restrito à equipe Aura Bela</p>

        <?php if (isset($_GET['erro'])): ?>
            <div class="error-msg">E-mail ou senha incorretos.</div>
        <?php endif; ?>

        <form action="auth-admin.php" method="POST">
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="admin@aurabela.com" required>
            </div>
            <div class="input-group">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Digite sua senha" required>
            </div>
            <button type="submit" class="btn-submit">Entrar</button>
        </form>

        <a href="../index.php" class="back-link">← Voltar ao site</a>
    </div>

</body>
</html>