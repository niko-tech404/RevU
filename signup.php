<?php
include 'connect_db.php';

$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick = $conn->real_escape_string($_POST['nickname']);
    $email = $conn->real_escape_string($_POST['email']);
    // Criptiamo la password
    $pass_criptata = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO utenti (nickname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nick, $email, $pass_criptata);

    if ($stmt->execute()) {
        header("Location: login.php?msg=registrato");
        exit();
    } else {
        $messaggio = "Errore durante la registrazione.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrati - Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">

    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">RevU</a>
            <nav class="nav-group">
                <a href="catalogue.php" class="nav-link">Catalogo</a>
            </nav>
        </div>
    </header>

    <main class="container auth-wrapper">
        <div class="auth-card">
            <h2>Crea Account</h2>
            <p class="auth-subtitle">Unisciti alla community di Vault</p>

            <?php if ($messaggio): ?>
                <p class="error-msg"><?= $messaggio ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>NICKNAME</label>
                    <input type="text" name="nickname" placeholder="Scegli un nick" required>
                </div>
                <div class="form-group">
                    <label>EMAIL</label>
                    <input type="email" name="email" placeholder="esempio@mail.com" required>
                </div>
                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" placeholder="Minimo 8 caratteri" required>
                </div>
                <button type="submit" class="btn-buy btn-full btn-no-border">Registrati</button>
                <div class="auth-footer">
                    <span>Hai già un account?</span> <a href="login.php">Accedi</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
