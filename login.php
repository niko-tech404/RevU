<?php
session_start();
include 'connect_db.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nick = $_POST['nickname'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM utenti WHERE nickname = ?");
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $ris = $stmt->get_result();

    if ($ris->num_rows > 0) {
        $utente = $ris->fetch_assoc();
        if (password_verify($pass, $utente['password'])) {
            $_SESSION['id_utente'] = $utente['id'];
            $_SESSION['nick'] = $utente['nickname'];
            header("Location: catalogue.php");
            exit();
        }
    }
    $error = "Credenziali non valide.";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="centered-layout">
    <main class="auth-box">
        <h1>Accedi</h1>
        <p style="color: var(--text-dim); margin-bottom: 2rem;">Bentornato. Inserisci i tuoi dati.</p>
        
        <?php if ($error): ?>
            <div class="error-msg" style="color: var(--danger); margin-bottom: 1rem;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Nickname</label>
                <input type="text" name="nickname" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary full-width">Login</button>
            <p class="alt-action">Non hai un account? <a href="signup.php">Registrati</a></p>
        </form>
    </main>
</body>
</html>