<?php
include 'connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick = $_POST['nickname'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO utenti (nickname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nick, $email, $pass);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="centered-layout">
    <main class="auth-box">
        <h1>Crea Account</h1>
        <p style="color: var(--text-dim); margin-bottom: 2rem;">Entra a far parte della nostra piattaforma.</p>

        <form action="signup.php" method="POST">
            <div class="form-group">
                <label>Nickname</label>
                <input type="text" name="nickname" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary full-width">Registrati</button>
            <p class="alt-action">Hai già un account? <a href="login.php">Accedi</a></p>
        </form>
    </main>
</body>
</html>