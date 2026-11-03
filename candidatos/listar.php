<?php

require '../config.php';
require '../includes/auth.php';

verificarLogin();

try {

    $sql = "SELECT *
            FROM candidatos
            ORDER BY peso DESC, nome_completo ASC";

    $stmt = $pdo->query($sql);

    $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    die("Erro ao carregar os candidatos: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Candidatos - Processo Seletivo</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>

        .botao-editar {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            margin-right: 5px;
        }

        .botao-editar:hover {
            background-color: #1d4ed8;
            text-decoration: none;
        }

        .botao-excluir {
            background-color: #dc2626;
            padding: 8px 12px;
        }

        .botao-excluir:hover {
            background-color: #b91c1c;
        }

        .acoes {
            white-space: nowrap;
        }

    </style>

</head>

<body>

    <h1>Candidatos</h1>

    <p>

        <a href="../dashboard.php">
            ← Voltar para o painel
        </a>

    </p>

    <?php if (count($candidatos) === 0): ?>

        <p>
            Nenhum candidato cadastrado.
        </p>

    <?php else: ?>

        <table>

            <thead>

                <tr>

                    <th>Nome</th>
                    <th>CPF</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Vaga</th>
                    <th>Escolaridade</th>
                    <th>Situação</th>
                    <th>Peso</th>

                    <?php if ($_SESSION['usuario_perfil'] === 'ADMIN'): ?>

                        <th>Ações</th>

                    <?php endif; ?>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($candidatos as $candidato): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($candidato['nome_completo']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['cpf']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['email']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['telefone'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['cidade'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['vaga_pretendida'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['escolaridade']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['situacao']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($candidato['peso']) ?>
                        </td>

                        <?php if ($_SESSION['usuario_perfil'] === 'ADMIN'): ?>

                            <td class="acoes">

                                <a
                                    href="editar.php?id=<?= $candidato['id'] ?>"
                                    class="botao-editar"
                                >
                                    Editar
                                </a>

                                <form
                                    method="POST"
                                    action="excluir.php"
                                    style="display: inline;"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este candidato?');"
                                >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= $candidato['id'] ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="botao-excluir"
                                    >
                                        Excluir
                                    </button>

                                </form>

                            </td>

                        <?php endif; ?>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</body>

</html>
