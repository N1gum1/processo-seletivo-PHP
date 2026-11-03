<?php

require '../config.php';
require '../includes/auth.php';

verificarAdmin();

$sql = "SELECT id, nome, email, perfil, criado_em
        FROM usuarios
        ORDER BY nome ASC";

$stmt = $pdo->query($sql);

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Usuários - Processo Seletivo</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <h1>Usuários do sistema</h1>

    <p>

        <a href="../dashboard.php">
            ← Voltar para o painel
        </a>

        |

        <a href="cadastrar.php">
            Cadastrar usuário
        </a>

    </p>

    <table>

        <thead>

            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>

        </thead>

        <tbody>

            <?php foreach ($usuarios as $usuario): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($usuario['nome']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($usuario['email']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($usuario['perfil']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($usuario['criado_em']) ?>
                    </td>

                    <td>

                        <?php if ($usuario['perfil'] === 'RECRUTADOR'): ?>

                            <a href="editar.php?id=<?= $usuario['id'] ?>">
                                Editar
                            </a>

                            |

                            <a
                                href="excluir.php?id=<?= $usuario['id'] ?>"
                                onclick="return confirm('Tem certeza que deseja excluir este recrutador?');"
                            >
                                Excluir
                            </a>

                        <?php else: ?>

                            <strong>Protegido</strong>

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</body>

</html>
