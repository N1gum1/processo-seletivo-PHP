<?php

session_start();

function verificarLogin()
{
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /login.php');
        exit;
    }
}

function verificarAdmin()
{
    verificarLogin();

    if ($_SESSION['usuario_perfil'] !== 'ADMIN') {
        die('Acesso negado.');
    }
}

