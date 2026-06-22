<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login-admin.php");
    exit;
}

require '../php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['tipo'])) {
    $id = intval($_POST['id']);
    $tipo = $_POST['tipo'];

    switch ($tipo) {
        case 'usuario':
            $tabela = 'usuarios';
            $coluna_id = 'id';
            break;
        case 'newsletter':
            $tabela = 'newsletter';
            $coluna_id = 'id';
            break;
        case 'agendamento':
            $tabela = 'agendamentos';
            $coluna_id = 'id';
            break;
        default:
            header("Location: dashboard.php?erro=tipo_invalido");
            exit;
    }

    $stmt = $conn->prepare("DELETE FROM $tabela WHERE $coluna_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: dashboard.php?sucesso=deletado&aba=" . $tipo);
    } else {
        header("Location: dashboard.php?erro=falha_deletar");
    }
    
    $stmt->close();
    exit;
}

header("Location: dashboard.php");
exit;