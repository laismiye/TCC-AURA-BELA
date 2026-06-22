<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['email'])) {
    header("Location: ../index.php?newsletter=erro");
    exit;
}

$email = trim($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../index.php?newsletter=erro");
    exit;
}

$sql = "INSERT IGNORE INTO newsletter (email) VALUES (?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header("Location: ../index.php?newsletter=erro");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();

header("Location: ../index.php?newsletter=ok");
exit;
?>