<?php

session_start();

require 'config.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];

        header('Location: dashboard.php');
        exit;

    } else {

        $erro = 'E-mail ou senha incorretos.';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Login - Processo Seletivo</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <h1>Sistema de Processo Seletivo</h1>

    <h2>Login</h2>

    <?php if ($erro): ?>

        <p style="color: red;">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label>E-mail:</label><br>

        <input
            type="email"
            name="email"
            required
        >

        <br><br>

        <label>Senha:</label><br>

        <input
            type="password"
            name="senha"
            required
        >

        <br><br>

        <button type="submit">
            Entrar
        </button>

    </form>

</body>

</html>
