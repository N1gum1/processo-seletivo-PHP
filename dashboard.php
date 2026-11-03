<?php

require 'includes/auth.php';

verificarLogin();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Painel - Processo Seletivo</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <h1>Sistema de Processo Seletivo</h1>

    <h2>
        Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!
    </h2>

    <p>
        Você está logado no sistema.
    </p>

    <p>
        Seu perfil:
        <strong>
            <?= htmlspecialchars($_SESSION['usuario_perfil']) ?>
        </strong>
    </p>

    <hr>

    <h3>Menu</h3>

    <div class="menu">

        <p>
            <a href="candidatos/listar.php">
                📋 Candidatos
            </a>
        </p>

        <?php if ($_SESSION['usuario_perfil'] === 'ADMIN'): ?>

            <p>
                <a href="usuarios/listar.php">
                    👥 Usuários
                </a>
            </p>

        <?php endif; ?>

        <p>
            <a href="logout.php">
                🚪 Sair
            </a>
        </p>

    </div>

</body>

</html>

