<?php
session_start();
include 'connect_db.php';

$id_gioco = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM giochi WHERE id = ?");
$stmt->bind_param("i", $id_gioco);
$stmt->execute();
$ris = $stmt->get_result();
$g = $ris->fetch_assoc();

if (!$g) {
    header("Location: catalogue.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($g['titolo']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">STORE</a>
            <nav class="nav-right">
                <a href="index.php" class="nav-link">Home</a>
                <a href="catalogue.php" class="nav-link">Catalogo</a>
                <?php if (isset($_SESSION['id_utente'])): ?>
                    <a href="library.php" class="nav-link">Libreria</a>
                    <a href="profile.php" class="nav-link">Profilo</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="detail-layout">
            <div class="detail-main">
                <h1><?php echo htmlspecialchars($g['titolo']); ?></h1>
                <p><?php echo htmlspecialchars($g['descrizione'] ?? 'Acquista ora la versione digitale completa per un accesso immediato.'); ?></p>
            </div>

            <aside class="purchase-box">
                <span class="price-large"><?php echo number_format($g['prezzo'], 2, ',', '.'); ?> €</span>
                <?php if (isset($_SESSION['id_utente'])): ?>
                    <a href="buy.php?id=<?php echo $g['id']; ?>" class="btn btn-primary full-width">Acquista Ora</a>
                <?php else: ?>
                    <p class="notice" style="margin-bottom: 1rem; color: var(--text-dim);">Accedi per aggiungere il titolo alla tua libreria.</p>
                    <a href="login.php" class="btn btn-primary full-width">Accedi</a>
                <?php endif; ?>
            </aside>
        </div>
    </main>
</body>
</html>