<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['email'])) {
    echo 'erro'; exit;
}

$email = trim($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'erro'; exit;
}

$sql = "INSERT IGNORE INTO newsletter (email) VALUES (?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo 'erro'; exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
echo 'ok';
?>