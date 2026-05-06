<?php
session_start();
include 'connect_db.php';

$errore_login = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nick = $conn->real_escape_string($_POST['nickname']);
    $pass_inserita = $_POST['password'];

    $sql_utente = "SELECT id, password FROM utenti WHERE nickname = '$nick'";
    $risultato = $conn->query($sql_utente);

    if ($risultato->num_rows > 0) {
        $utente = $risultato->fetch_assoc();
        
        // CORREZIONE: Usiamo password_verify per le password criptate
        if (password_verify($pass_inserita, $utente['password'])) { 
            $_SESSION['id_utente'] = $utente['id'];
            $_SESSION['nickname'] = $nick;
            header("Location: catalogue.php");
            exit();
        } else {
            $errore_login = "Password errata.";
        }
    } else {
        $errore_login = "Utente non trovato.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accedi - Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">

    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">VAULT</a>
            <nav class="nav-group">
                <a href="catalogue.php" class="nav-link">Catalogo</a>
            </nav>
        </div>
    </header>

    <main class="container auth-wrapper">
        <div class="auth-card">
            <h2>Bentornato</h2>
            <p class="auth-subtitle">Accedi per gestire la tua libreria</p>

            <?php if ($errore_login): ?>
                <p class="error-msg"><?= $errore_login ?></p>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>NICKNAME</label>
                    <input type="text" name="nickname" placeholder="Il tuo nick" required>
                </div>
                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-buy btn-full btn-no-border">Accedi</button>
                <div class="auth-footer">
                    <span>Nuovo utente?</span> <a href="signup.php">Crea un account</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
