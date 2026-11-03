<?php

require '../config.php';
require '../includes/auth.php';

verificarAdmin();

$id = $_GET['id'] ?? null;

if (!$id) {
    die('Candidato não informado.');
}

$sql = "SELECT * FROM candidatos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$candidato = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$candidato) {
    die('Candidato não encontrado.');
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome_completo'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $dataNascimento = $_POST['data_nascimento'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $vaga = trim($_POST['vaga_pretendida'] ?? '');
    $escolaridade = $_POST['escolaridade'] ?? '';
    $situacao = $_POST['situacao'] ?? 'INSCRITO';
    $peso = $_POST['peso'] ?? 0;

    if (
        $nome === '' ||
        $cpf === '' ||
        $dataNascimento === '' ||
        $email === '' ||
        $escolaridade === ''
    ) {

        $erro = 'Preencha todos os campos obrigatórios.';

    } else {

        try {

            $sql = "UPDATE candidatos
                    SET nome_completo = ?,
                        cpf = ?,
                        data_nascimento = ?,
                        email = ?,
                        telefone = ?,
                        cidade = ?,
                        vaga_pretendida = ?,
                        escolaridade = ?,
                        situacao = ?,
                        peso = ?
                    WHERE id = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $nome,
                $cpf,
                $dataNascimento,
                $email,
                $telefone,
                $cidade,
                $vaga,
                $escolaridade,
                $situacao,
                $peso,
                $id
            ]);

            $sucesso = 'Candidato atualizado com sucesso!';

            $sql = "SELECT * FROM candidatos WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $candidato = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {

                $erro = 'Este CPF já está cadastrado.';

            } else {

                $erro = 'Erro ao atualizar o candidato.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Editar candidato - Processo Seletivo</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <h1>Editar candidato</h1>

    <p>
        <a href="listar.php">
            ← Voltar para candidatos
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

        <label>Nome completo:</label><br>

        <input
            type="text"
            name="nome_completo"
            value="<?= htmlspecialchars($candidato['nome_completo']) ?>"
            required
        >

        <br><br>

        <label>CPF:</label><br>

        <input
            type="text"
            name="cpf"
            value="<?= htmlspecialchars($candidato['cpf']) ?>"
            required
        >

        <br><br>

        <label>Data de nascimento:</label><br>

        <input
            type="date"
            name="data_nascimento"
            value="<?= htmlspecialchars($candidato['data_nascimento']) ?>"
            required
        >

        <br><br>

        <label>E-mail:</label><br>

        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($candidato['email']) ?>"
            required
        >

        <br><br>

        <label>Telefone:</label><br>

        <input
            type="text"
            name="telefone"
            value="<?= htmlspecialchars($candidato['telefone'] ?? '') ?>"
        >

        <br><br>

        <label>Cidade:</label><br>

        <input
            type="text"
            name="cidade"
            value="<?= htmlspecialchars($candidato['cidade'] ?? '') ?>"
        >

        <br><br>

        <label>Vaga pretendida:</label><br>

        <input
            type="text"
            name="vaga_pretendida"
            value="<?= htmlspecialchars($candidato['vaga_pretendida'] ?? '') ?>"
        >

        <br><br>

        <label>Escolaridade:</label><br>

        <select name="escolaridade" required>

            <option value="FUNDAMENTAL" <?= $candidato['escolaridade'] === 'FUNDAMENTAL' ? 'selected' : '' ?>>
                Fundamental
            </option>

            <option value="MEDIO" <?= $candidato['escolaridade'] === 'MEDIO' ? 'selected' : '' ?>>
                Médio
            </option>

            <option value="TECNICO" <?= $candidato['escolaridade'] === 'TECNICO' ? 'selected' : '' ?>>
                Técnico
            </option>

            <option value="SUPERIOR" <?= $candidato['escolaridade'] === 'SUPERIOR' ? 'selected' : '' ?>>
                Superior
            </option>

            <option value="POS_GRADUACAO" <?= $candidato['escolaridade'] === 'POS_GRADUACAO' ? 'selected' : '' ?>>
                Pós-graduação
            </option>

            <option value="MESTRADO" <?= $candidato['escolaridade'] === 'MESTRADO' ? 'selected' : '' ?>>
                Mestrado
            </option>

            <option value="DOUTORADO" <?= $candidato['escolaridade'] === 'DOUTORADO' ? 'selected' : '' ?>>
                Doutorado
            </option>

        </select>

        <br><br>

        <label>Situação:</label><br>

        <select name="situacao">

            <option value="INSCRITO" <?= $candidato['situacao'] === 'INSCRITO' ? 'selected' : '' ?>>
                Inscrito
            </option>

            <option value="EM_ANALISE" <?= $candidato['situacao'] === 'EM_ANALISE' ? 'selected' : '' ?>>
                Em análise
            </option>

            <option value="APROVADO" <?= $candidato['situacao'] === 'APROVADO' ? 'selected' : '' ?>>
                Aprovado
            </option>

            <option value="REPROVADO" <?= $candidato['situacao'] === 'REPROVADO' ? 'selected' : '' ?>>
                Reprovado
            </option>

        </select>

        <br><br>

        <label>Peso da candidatura:</label><br>

        <input
            type="number"
            name="peso"
            step="0.01"
            min="0"
            value="<?= htmlspecialchars($candidato['peso']) ?>"
        >

        <br><br>

        <button type="submit">
            Salvar alterações
        </button>

    </form>

</body>

</html>
