<?php
session_start();
include 'connect_db.php';
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}
$id_u = $_SESSION['id_utente'];
$ris = $conn->query("SELECT * FROM utenti WHERE id = $id_u");
$u = $ris->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-shell">
    <header class="site-header">
        <div class="header-inner">
            <div class="nav-left">
                <a href="index.php" class="brand-mark">
                    <span class="brand-orb"></span>
                    <span class="brand-copy">
                        <strong>STEAM_2026</strong>
                        <span>Dark glass storefront</span>
                    </span>
                </a>
            </div>

            <div class="nav-right">
                <a href="index.php" class="btn">Home</a>
                <a href="catalogue.php" class="btn">Catalogo</a>
                <a href="library.php" class="btn">Libreria</a>
                <a href="profile.php" class="btn active">Profilo</a>
            </div>
        </div>
    </header>

    <main class="shell-container">
        <section class="profile-card">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Profile</span>
                    <h2>Il tuo profilo</h2>
                    <p>Pagina alleggerita: dati account, stato sessione e sole azioni realmente pertinenti, senza duplicare la navigazione che e gia nella navbar.</p>
                </div>
            </div>

            <div class="profile-grid">
                <div class="profile-stat">
                    <strong>Nickname</strong>
                    <span><?php echo htmlspecialchars($u['nickname']); ?></span>
                </div>
                <div class="profile-stat">
                    <strong>Email</strong>
                    <span><?php echo htmlspecialchars($u['email']); ?></span>
                </div>
                <div class="profile-stat">
                    <strong>Session</strong>
                    <span>attiva</span>
                </div>
                <div class="profile-stat">
                    <strong>UI mode</strong>
                    <span>dark glass responsive</span>
                </div>
            </div>

            <div class="profile-actions">
                <a href="logout.php" class="btn">Logout</a>
                <a href="delete_account.php" class="btn btn-danger">Elimina account</a>
            </div>
        </section>
    </main>
</body>
</html>
