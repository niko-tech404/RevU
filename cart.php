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
                <a href="catalogue.php" class="nav-link">Catalogo</a>
                <?php if (isset($_SESSION['id_utente'])): ?>
                    <a href="library.php" class="nav-link">Libreria</a>
                <?php endif; ?>
                <a href="cart.php" class="nav-link active">Carrello (<?= count($prodotti) ?>)</a>
            </nav>
        </div>
    </header>

    <main class="container cart-page">
        <div class="catalogo-layout">
            <section class="cart-list">
                <div class="section-head section-head-tight">
                    <div>
                        <p class="eyebrow">Ordine</p>
                        <h1>Il tuo carrello</h1>
                    </div>
                    <p class="section-note">Un riepilogo più chiaro dei prodotti scelti prima del checkout.</p>
                </div>

                <?php if (empty($prodotti)): ?>
                    <div class="empty-state empty-state-left">
                        <h3>Carrello vuoto</h3>
                        <p>Non hai ancora aggiunto giochi. Vai nel catalogo e crea il tuo prossimo ordine.</p>
                        <a href="catalogue.php" class="btn btn-primary">Esplora i giochi</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($prodotti as $p): ?>
                        <article class="cart-item">
                            <img src="<?= htmlspecialchars($p['immagine']) ?>" alt="<?= htmlspecialchars($p['titolo']) ?>">
                            <div class="cart-item-info">
                                <h3><?= htmlspecialchars($p['titolo']) ?></h3>
                                <p><?= htmlspecialchars(strlen($p['descrizione']) > 96 ? substr($p['descrizione'], 0, 93) . '...' : $p['descrizione']) ?></p>
                            </div>
                            <div class="cart-item-price">
                                <span><?= number_format($p['prezzo'], 2) ?> €</span>
                                <div class="cart-item-links">
                                    <a href="game.php?id=<?= $p['id'] ?>" class="remove-link">Apri scheda</a>
                                    <a href="remove_from_cart.php?id=<?= $p['id'] ?>" class="remove-link remove-link-danger">Rimuovi</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <aside class="sidebar-filtri">
                <div class="summary-card">
                    <div class="summary-card-head">
                        <h3>Riepilogo ordine</h3>
                        <span><?= count($prodotti) ?> articoli</span>
                    </div>

                    <div class="summary-row">
                        <span>Subtotale</span>
                        <strong><?= number_format($totale, 2) ?> €</strong>
                    </div>
                    <div class="summary-row">
                        <span>Commissioni</span>
                        <strong>0,00 €</strong>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Totale</span>
                        <strong><?= number_format($totale, 2) ?> €</strong>
                    </div>

                    <?php if (isset($_SESSION['id_utente'])): ?>
                        <a href="checkout.php" class="btn-buy btn-full">Procedi al checkout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-secondary btn-full">Accedi per comprare</a>
                    <?php endif; ?>

                    <p class="summary-note">Il pagamento verrà completato in un passaggio separato e i titoli finiranno direttamente nella tua libreria.</p>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
