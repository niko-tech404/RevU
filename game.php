<?php
session_start();
include 'connect_db.php';

$id = (int)($_GET['id'] ?? 0);
$query = "SELECT * FROM giochi WHERE id = $id";
$risultato = $conn->query($query);
$gioco = $risultato->fetch_assoc();

if (!$gioco) { header("Location: catalogue.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?= $gioco['titolo'] ?> - Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">VAULT</a>
            <nav class="nav-group">
                <a href="catalogue.php" class="nav-link">Store</a>
                <a href="cart.php" class="nav-link">Carrello (<?= count($_SESSION['carrello'] ?? []) ?>)</a>
            </nav>
        </div>
    </header>

    <main class="container" style="margin-top: 120px; display: flex; gap: 40px;">
        <div class="game-cover">
            <img src="<?= $gioco['immagine'] ?>" style="width: 300px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        </div>
        
        <div class="game-info">
            <h1><?= htmlspecialchars($gioco['titolo']) ?></h1>
            <p style="color: var(--text-dim); margin-top: 20px;"><?= nl2br(htmlspecialchars($gioco['descrizione'])) ?></p>
            
            <div class="purchase-card" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 20px; margin-top: 30px;">
                <span style="font-size: 2rem; font-weight: 800;"><?= number_format($gioco['prezzo'], 2) ?> €</span>
                <div style="margin-top: 20px; display: flex; gap: 15px;">
                    <a href="add_to_cart.php?id=<?= $gioco['id'] ?>" class="btn-buy" style="background: #323232; border: 1px solid #444;">Aggiungi al Carrello</a>
                    <a href="checkout.php?direct_id=<?= $gioco['id'] ?>" class="btn-buy">Acquista Ora</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>