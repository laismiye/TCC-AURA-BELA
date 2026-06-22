<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['confirmar_senha'])) {
    header("Location: ../pages/login.php");
    exit;
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmarSenha = $_POST['confirmar_senha'];

if ($senha !== $confirmarSenha) {
    header("Location: ../pages/login.php?erro=1");
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $senhaHash);

if ($stmt->execute()) {
    header("Location: ../pages/login.php?cadastro=sucesso");
    exit;
} else {
    echo "Erro: " . $conn->error;
}
?>