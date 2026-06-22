<?php
session_start();
require '../php/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM admins WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$admin = $resultado->fetch_assoc();

if ($admin && password_verify($senha, $admin['senha'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_email'] = $admin['email'];
    header("Location: dashboard.php");
} else {
    header("Location: login-admin.php?erro=1");
}
exit;
?>