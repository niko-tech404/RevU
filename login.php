<?php
session_start();
include 'connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick = $_POST['nickname'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM utenti WHERE nickname = '$nick'";
    $ris = $conn->query($sql);

    if ($ris->num_rows > 0) {
        $utente = $ris->fetch_assoc();
        if (password_verify($pass, $utente['password'])) {
            $_SESSION['id_utente'] = $utente['id'];
            $_SESSION['nick'] = $utente['nickname'];
            header("Location: catalogue.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-shell auth-page">
    <main class="auth-card">
        <section class="auth-intro">
            <span class="eyebrow">Access gateway</span>
            <h1>Accedi dentro un’interfaccia scura, fluida e davvero leggibile.</h1>
            <p>Il form vive dentro una shell glass piu solida, con maggiore respiro laterale, palette multi-colore controllata e comportamento responsive piu credibile.</p>

            <div class="auth-preview">
                <div class="stat-chip">
                    <strong>Secure login</strong>
                    <span>sessione PHP invariata</span>
                </div>
                <div class="stat-chip">
                    <strong>Soft motion</strong>
                    <span>focus ring e floating panels</span>
                </div>
                <div class="stat-chip">
                    <strong>Desktop + mobile</strong>
                    <span>griglia che collassa bene</span>
                </div>
                <div class="stat-chip">
                    <strong>Store access</strong>
                    <span>catalogo e libreria unificati</span>
                </div>
            </div>
        </section>

        <section class="auth-form">
            <form action="login.php" method="POST">
                <div class="form-field">
                    <label for="nickname">Nickname</label>
                    <input id="nickname" type="text" name="nickname" placeholder="inserisci il nickname" required>
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="inserisci la password" required>
                </div>
                <div class="auth-actions">
                    <button class="btn btn-primary" type="submit">Accedi</button>
                    <a href="signup.php" class="btn">Crea account</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
