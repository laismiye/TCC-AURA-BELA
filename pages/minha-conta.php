<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?form=login');
    exit;
}

include '../php/conexao.php';

if (isset($conexao) && !isset($conn)) {
    $conn = $conexao;
}

$usuario_id = $_SESSION['usuario_id'];
$mensagem_sucesso = "";
$mensagem_erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $novo_telefone = mysqli_real_escape_string($conn, $_POST['telefone']);

    $stmt_update = $conn->prepare("UPDATE usuarios SET nome = ?, telefone = ? WHERE id = ?");
    $stmt_update->bind_param("ssi", $novo_nome, $novo_telefone, $usuario_id);
    
    if ($stmt_update->execute()) {
        $mensagem_sucesso = "🎉 Seus dados foram atualizados com sucesso e salvos no sistema!";
    } else {
        $mensagem_erro = "Erro ao atualizar os dados: " . $conn->error;
    }
    $stmt_update->close();
}

$stmt_select = $conn->prepare("SELECT nome, email, telefone FROM usuarios WHERE id = ?");
$stmt_select->bind_param("i", $usuario_id);
$stmt_select->execute();
$resultado = $stmt_select->get_result();
$usuario = $resultado->fetch_assoc();
$stmt_select->close();

if (!$usuario) {
    die("Usuário não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - Aura Bela</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=3">
</head>
<body class="account-body">

    <div class="account-card">
        <h1 class="account-title">Meus Dados</h1>

        <?php if ($mensagem_sucesso): ?>
            <p class="feedback-msg msg-sucesso"><?= $mensagem_sucesso ?></p>
        <?php endif; ?>
        <?php if ($mensagem_erro): ?>
            <p class="feedback-msg msg-erro"><?= $mensagem_erro ?></p>
        <?php endif; ?>

        <form method="POST" action="minha-conta.php">
            <div class="input-group">
                <label>Nome Completo</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            </div>

            <div class="input-group">
                <label>E-mail (Login)</label>
                <input type="email" value="<?= htmlspecialchars($usuario['email']) ?>" disabled style="background-color: #f5f5f5; color: #888; cursor: not-allowed;">
            </div>

            <div class="input-group">
                <label>Telefone / WhatsApp</label>
                <input type="text" name="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" placeholder="(00) 00000-0000">
            </div>

            <button type="submit" class="btn-save">Salvar Alterações</button>
        </form>

        <div class="back-link">
            <a href="../index.php">Voltar para o Início</a>
        </div>
    </div>

    <script src="../js/main.js?v=2"></script>
</body>
</html>