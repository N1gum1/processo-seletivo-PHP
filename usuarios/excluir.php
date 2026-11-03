k<?php

require '../config.php';
require '../includes/auth.php';

verificarAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    die('Acesso inválido.');
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die('Usuário não informado.');
}

try {

    $sql = "DELETE FROM usuarios
            WHERE id = ?
            AND perfil = 'RECRUTADOR'";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id]);

    header('Location: listar.php');
    exit;

} catch (PDOException $e) {

    die('Erro ao excluir o recrutador.');
}
