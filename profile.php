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
    <title>Vault - Profilo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">RevU</a>
            <nav class="nav-group">
                <a href="index.php" class="nav-link">Home</a>
                <a href="catalogue.php" class="nav-link">Catalogo</a>
                <a href="library.php" class="nav-link">Libreria</a>
                <a href="profile.php" class="nav-link"><img class='pfp' src="assets/pfp.png" alt="pfpimg" height="25px" width="25px"></a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="card profile-info">
            <div class="section-head section-head-tight">
                <div>
                    <p class="eyebrow">Area personale</p>
                    <h1>Profilo utente</h1>
                </div>
            </div>
            <div class="data-row">
                <strong>Nickname:</strong>
                <span><?php echo htmlspecialchars($u['nickname']); ?></span>
            </div>
            <div class="data-row">
                <strong>Email:</strong>
                <span><?php echo htmlspecialchars($u['email']); ?></span>
            </div>
            <div class="profile-actions">
                <a href="logout.php" class="btn">Logout</a>
                <a href="delete_account.php" class="btn btn-danger">Elimina Account</a>
            </div>
        </section>
    </main>
</body>
</html>
