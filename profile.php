<?php
session_start();
include 'connect_db.php';
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}
$id_u = $_SESSION['id_utente'];
$stmt = $conn->prepare("SELECT * FROM utenti WHERE id = ?");
$stmt->bind_param("i", $id_u);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il tuo Profilo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">STORE</a>
            <nav class="nav-right">
                <a href="index.php" class="nav-link">Home</a>
                <a href="library.php" class="nav-link">Libreria</a>
                <a href="profile.php" class="nav-link active">Profilo</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="card profile-info" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
            <h1 style="margin-bottom: 2rem;">Profilo Utente</h1>
            <div class="data-row">
                <strong>Nickname:</strong>
                <span><?php echo htmlspecialchars($u['nickname']); ?></span>
            </div>
            <div class="data-row">
                <strong>Email:</strong>
                <span><?php echo htmlspecialchars($u['email']); ?></span>
            </div>
            <div class="profile-actions" style="margin-top: 3rem; display: flex; gap: 1rem;">
                <a href="logout.php" class="btn">Logout</a>
                <a href="delete_account.php" class="btn btn-danger">Elimina Account</a>
            </div>
        </section>
    </main>
</body>
</html>