<?php
include 'connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick = $_POST['nickname'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO utenti (nickname, email, password) VALUES ('$nick', '$email', '$pass')";

    if ($conn->query($sql)) {
        header("Location: login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-shell auth-page">
    <main class="auth-card">
        <section class="auth-intro">
            <span class="eyebrow">Account creation</span>
            <h1>Crea un account dentro una UI scura coerente con tutto lo store.</h1>
            <p>Signup, catalogo, libreria e pagina gioco ora usano la stessa lingua visiva: glassmorphism scuro, pill flottanti, spacing piu largo e migliore fluidita tra desktop e mobile.</p>

            <div class="auth-preview">
                <div class="stat-chip">
                    <strong>Fast onboarding</strong>
                    <span>flusso diretto verso il login</span>
                </div>
                <div class="stat-chip">
                    <strong>Readable forms</strong>
                    <span>contrasto e focus puliti</span>
                </div>
                <div class="stat-chip">
                    <strong>Glass layers</strong>
                    <span>blur, bordi e ombre consistenti</span>
                </div>
                <div class="stat-chip">
                    <strong>Responsive shell</strong>
                    <span>stack fluido su mobile</span>
                </div>
            </div>
        </section>

        <section class="auth-form">
            <form action="signup.php" method="POST">
                <div class="form-field">
                    <label for="nickname">Nickname</label>
                    <input id="nickname" type="text" name="nickname" placeholder="scegli un nickname" required>
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="nome@dominio.it" required>
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="crea una password" required>
                </div>
                <div class="auth-actions">
                    <button class="btn btn-primary" type="submit">Crea account</button>
                    <a href="login.php" class="btn">Ho gia un account</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
