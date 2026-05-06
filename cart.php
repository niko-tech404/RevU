<?php
session_start();
include 'connect_db.php';

$prodotti = [];
$totale = 0;

if (!empty($_SESSION['carrello'])) {
    $ids = implode(',', array_map('intval', $_SESSION['carrello']));
    $res = $conn->query("SELECT * FROM giochi WHERE id IN ($ids)");
    while($row = $res->fetch_assoc()) {
        $prodotti[] = $row;
        $totale += $row['prezzo'];
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Carrello - Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">VAULT</a>
            <nav class="nav-group">
                <a href="catalogue.php" class="nav-link">Store</a>
                <a href="cart.php" class="nav-link active">Carrello (<?= count($prodotti) ?>)</a>
            </nav>
        </div>
    </header>

    <main class="container" style="margin-top: 120px;">
        <div class="catalogo-layout">
            <section>
                <h2>Il tuo Carrello</h2>
                <?php if (empty($prodotti)): ?>
                    <p style="margin-top: 20px; opacity: 0.5;">Carrello vuoto. <a href="catalogue.php" style="color: #0a84ff;">Esplora i giochi.</a></p>
                <?php else: ?>
                    <?php foreach ($prodotti as $p): ?>
                        <div class="cart-item" style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.03); padding: 20px; border-radius: 15px; margin-bottom: 10px;">
                            <span><?= htmlspecialchars($p['titolo']) ?></span>
                            <strong><?= number_format($p['prezzo'], 2) ?> €</strong>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <aside class="sidebar-filtri">
                <div class="auth-card" style="width: 100%;">
                    <h3>Totale</h3>
                    <span style="font-size: 2rem; color: #0a84ff; font-weight: 800;"><?= number_format($totale, 2) ?> €</span>
                    <hr style="border: 0.5px solid rgba(255,255,255,0.1); margin: 20px 0;">
                    <?php if (isset($_SESSION['id_utente'])): ?>
                        <a href="checkout.php" class="btn-buy" style="display: block; text-align: center;">Procedi al Checkout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-buy" style="display: block; text-align: center; background: #333;">Accedi per comprare</a>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>