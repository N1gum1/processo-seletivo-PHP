<?php

require '../config.php';
require '../includes/auth.php';

verificarAdmin();

$id = $_GET['id'] ?? null;

if (!$id) {
    die('Usuário não informado.');
}

$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die('Usuário não encontrado.');
}

if ($usuario['perfil'] !== 'RECRUTADOR') {
    die('Este usuário não pode ser editado.');
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '') {

        $erro = 'Nome e e-mail são obrigatórios.';

    } else {

        try {

            if ($senha !== '') {

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                $sql = "UPDATE usuarios
                        SET nome = ?, email = ?, senha = ?
                        WHERE id = ?
                        AND perfil = 'RECRUTADOR'";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    $nome,
                    $email,
                    $senhaHash,
                    $id
                ]);

            } else {

                $sql = "UPDATE usuarios
                        SET nome = ?, email = ?
                        WHERE id = ?
                        AND perfil = 'RECRUTADOR'";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    $nome,
                    $email,
                    $id
                ]);
            }

            $sucesso = 'Recrutador atualizado com sucesso!';

            $sql = "SELECT * FROM usuarios WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {

                $erro = 'Este e-mail já está cadastrado.';

            } else {

                $erro = 'Erro ao atualizar o recrutador.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Editar recrutador - Processo Seletivo</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <h1>Editar recrutador</h1>

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
            value="<?= htmlspecialchars($usuario['nome']) ?>"
            required
        >

        <br><br>

        <label>E-mail:</label><br>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($usuario['email']) ?>"
            required
        >

        <br><br>

        <label>Nova senha:</label><br>

        <input
            type="password"
            name="senha"
        >

        <p>
            Deixe em branco para manter a senha atual.
        </p>

        <button type="submit">
            Salvar alterações
        </button>

    </form>

</body>

</html>
