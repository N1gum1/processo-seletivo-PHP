<?php

require '../config.php';
require '../includes/auth.php';

verificarLogin();

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

            $sql = "INSERT INTO candidatos
                    (
                        nome_completo,
                        cpf,
                        data_nascimento,
                        email,
                        telefone,
                        cidade,
                        vaga_pretendida,
                        escolaridade,
                        situacao,
                        peso
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
                $peso
            ]);

            $sucesso = 'Candidato cadastrado com sucesso!';

        } catch (PDOException $e) {

            if ($e->getCode() === '23000') {

                $erro = 'Este CPF já está cadastrado.';

            } else {

                $erro = 'Erro ao cadastrar o candidato.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Cadastrar candidato - Processo Seletivo</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <h1>Cadastrar candidato</h1>

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
            required
        >

        <br><br>

        <label>CPF:</label><br>

        <input
            type="text"
            name="cpf"
            required
        >

        <br><br>

        <label>Data de nascimento:</label><br>

        <input
            type="date"
            name="data_nascimento"
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

        <label>Telefone:</label><br>

        <input
            type="text"
            name="telefone"
        >

        <br><br>

        <label>Cidade:</label><br>

        <input
            type="text"
            name="cidade"
        >

        <br><br>

        <label>Vaga pretendida:</label><br>

        <input
            type="text"
            name="vaga_pretendida"
        >

        <br><br>

        <label>Escolaridade:</label><br>

        <select name="escolaridade" required>

            <option value="">
                Selecione
            </option>

            <option value="FUNDAMENTAL">
                Fundamental
            </option>

            <option value="MEDIO">
                Médio
            </option>

            <option value="TECNICO">
                Técnico
            </option>

            <option value="SUPERIOR">
                Superior
            </option>

            <option value="POS_GRADUACAO">
                Pós-graduação
            </option>

            <option value="MESTRADO">
                Mestrado
            </option>

            <option value="DOUTORADO">
                Doutorado
            </option>

        </select>

        <br><br>

        <label>Situação:</label><br>

        <select name="situacao">

            <option value="INSCRITO">
                Inscrito
            </option>

            <option value="EM_ANALISE">
                Em análise
            </option>

            <option value="APROVADO">
                Aprovado
            </option>

            <option value="REPROVADO">
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
            value="0"
        >

        <br><br>

        <button type="submit">
            Cadastrar candidato
        </button>

    </form>

</body>

</html>
