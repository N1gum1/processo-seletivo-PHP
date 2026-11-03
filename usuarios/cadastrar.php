<?php

require '../config.php';
require '../includes/auth.php';

verificarAdmin();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {

        $erro = 'Preencha todos os campos obrigatórios.';

    } else {

        try {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            /*
             * Novos usuários cadastrados pelo administrador
             * serão sempre recrutadores.
             */
            $perfil = 'RECRUTADOR';

            $sql = "INSERT INTO usuarios
                    (nome, email, senha, perfil)
                    VALUES (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $nome,
                $email,
                $senhaHash,
                $perfil
            ]);

            $sucesso = 'Recrutador cadastrado com sucesso!';

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {

                $erro = 'Este e-mail já está cadastrado.';

            } else {

                $erro = 'Erro ao cadastrar o recrutador.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Cadastrar recrutador - Processo Seletivo</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <h1>Cadastrar recrutador</h1>

    <p>

        <a href="listar.php">
            ← Voltar para usuários
        </a>

        |

        <a href="../dashboard.php">
            Voltar para o painel
        </a>

    </p>

    <?php if ($erro): ?>

        <p class="mensagem-erro">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>

    <?php if ($sucesso): ?>

        <p class="mensagem-sucesso">
            <?= htmlspecialchars($sucesso) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label>Nome:</label><br>

        <input
            type="text"
            name="nome"
            required
        >

        <br><br>

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
            Cadastrar recrutador
        </button>

    </form>

</body>

</html>
