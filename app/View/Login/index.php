<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/Assets/css/style.css" />
</head>

<body class="login-page">

    <form method="POST" action="<?= BASE_URL ?>/?url=login">
        <div class="form-container">
            <h2>Bem-vindo</h2>
            <p class="subtitle">Faça login para continuar</p>

            <?php if (!empty($erro)): ?>
                <div class="erro"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <div class="input-box">
                <input type="email" name="user" placeholder="Digite seu E-mail" required />
                <span>E-mail</span>
            </div>

            <div class="input-box">
                <input type="password" name="senha" placeholder="Digite sua senha" required />
                <span>Senha</span>
            </div>

            <button class="submit-btn" type="submit">Entrar</button>
        </div>
    </form>

</body>

</html>