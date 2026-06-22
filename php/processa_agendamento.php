<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php?erro=necessario_login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conn, $_POST['sobrenome']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $servico = mysqli_real_escape_string($conn, $_POST['servico']);
    $data = mysqli_real_escape_string($conn, $_POST['data']);
    $horario = mysqli_real_escape_string($conn, $_POST['horario']);

    $check = $conn->prepare("SELECT id FROM agendamentos WHERE data_agendamento = ? AND horario_agendamento = ?");
    $check->bind_param("ss", $data, $horario);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        die("Desculpe, esse horário acabou de ser preenchido por outro cliente. Volte e selecione outro.");
    }
    $check->close();

    $stmt = $conn->prepare("INSERT INTO agendamentos (usuario_id, nome, sobrenome, telefone, servico, data_agendamento, horario_agendamento) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("issssss", $usuario_id, $nome, $sobrenome, $telefone, $servico, $data, $horario);

    if ($stmt->execute()) {
        header("Location: ../pages/meus-agendamentos.php?status=sucesso");
        exit;
    } else {
        echo "Erro ao processar agendamento no banco de dados: " . $conn->error;
    }
    $stmt->close();
}
?>