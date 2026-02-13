<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="/GSWP/assets/style.css">
</head>
<body class="login-body">

<div class="login-container">

    <div class="login-left">
        <h1>Sistema de Vendas</h1>
        <p>Gestão de vendedores e produtos</p>
    </div>

    <div class="login-right">
        <form class="login-form" method="POST" action="/GSWP/controller/AuthController.php">
            <h2>Login</h2>

            <?php if(!empty($erro)): ?>
                <div class="erro"><?= $erro ?></div>
            <?php endif; ?>

            <div class="input-box">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>

            <div class="input-box">
                <input type="password" name="senha" required>
                <label>Senha</label>
            </div>

            <button class="btn-login">Entrar</button>
        </form>
    </div>
</div>
</body>
</html>
