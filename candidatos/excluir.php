<?php

require '../config.php';
require '../includes/auth.php';

verificarAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Acesso inválido.');
}

$id = $_POST['id'] ?? null;

if (!$id) {
    die('Candidato não informado.');
}

try {

    $sql = "DELETE FROM candidatos WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$id]);

    header('Location: listar.php');
    exit;

} catch (PDOException $e) {

    die('Erro ao excluir o candidato.');
}
