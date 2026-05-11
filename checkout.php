<?php
session_start();
include 'connect_db.php';

if (!isset($_SESSION['id_utente'])) { header("Location: login.php"); exit(); }

$prodotti = [];
$totale = 0;
$directId = (int)($_GET['direct_id'] ?? $_POST['direct_id'] ?? 0);

if ($directId > 0) {
    $stmt = $conn->prepare("SELECT * FROM giochi WHERE id = ?");
    $stmt->bind_param("i", $directId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($gioco = $res->fetch_assoc()) {
        $prodotti[] = $gioco;
        $totale = $gioco['prezzo'];
    }
} elseif (!empty($_SESSION['carrello'])) {
    $ids = implode(',', array_map('intval', $_SESSION['carrello']));
    $res = $conn->query("SELECT * FROM giochi WHERE id IN ($ids)");

    while ($row = $res->fetch_assoc()) {
        $prodotti[] = $row;
        $totale += $row['prezzo'];
    }
}

if (empty($prodotti)) { header("Location: catalogue.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">RevU</a>
            <nav class="nav-group">
                <a href="catalogue.php" class="nav-link">Catalogo</a>
                <a href="cart.php" class="nav-link">Carrello</a>
                <a href="checkout.php<?= $directId > 0 ? '?direct_id=' . $directId : '' ?>" class="nav-link active">Checkout</a>
            </nav>
        </div>
    </header>

    <main class="container checkout-page">
        <div class="checkout-layout">
            <section class="checkout-panel">
                <div class="section-head section-head-tight">
                    <div>
                        <p class="eyebrow">Pagamento</p>
                        <h1>Checkout sicuro</h1>
                    </div>
                    <p class="section-note">Layout più vicino ai siti reali: form chiaro a sinistra, riepilogo ordine a destra.</p>
                </div>

                <form action="process_payment.php" method="POST" class="checkout-form">
                    <?php if ($directId > 0): ?>
                        <input type="hidden" name="direct_id" value="<?= $directId ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Intestatario</label>
                        <input type="text" name="nome" placeholder="Nome sulla carta" required>
                    </div>
                    <div class="form-group">
                        <label>Numero Carta</label>
                        <input type="text" name="card" placeholder="0000 0000 0000 0000" maxlength="16" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Scadenza</label>
                            <input type="text" name="exp" placeholder="MM/AA" required>
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="password" name="cvv" placeholder="***" maxlength="3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email di conferma</label>
                        <input type="email" name="email" placeholder="ricevuta@mail.com" required>
                    </div>
                    <button type="submit" class="btn-buy btn-full btn-no-border">Conferma e paga</button>
                </form>
            </section>

            <aside class="summary-card checkout-summary">
                <div class="summary-card-head">
                    <h3>Riepilogo ordine</h3>
                    <span><?= count($prodotti) ?> articoli</span>
                </div>

                <div class="checkout-items">
                    <?php foreach ($prodotti as $prodotto): ?>
                        <div class="checkout-item">
                            <img src="<?= htmlspecialchars($prodotto['immagine']) ?>" alt="<?= htmlspecialchars($prodotto['titolo']) ?>">
                            <div>
                                <strong><?= htmlspecialchars($prodotto['titolo']) ?></strong>
                                <p>Licenza digitale immediata</p>
                            </div>
                            <span><?= number_format($prodotto['prezzo'], 2) ?> €</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-row">
                    <span>Subtotale</span>
                    <strong><?= number_format($totale, 2) ?> €</strong>
                </div>
                <div class="summary-row">
                    <span>Costi aggiuntivi</span>
                    <strong>0,00 €</strong>
                </div>
                <div class="summary-row summary-total">
                    <span>Totale finale</span>
                    <strong><?= number_format($totale, 2) ?> €</strong>
                </div>

                <p class="summary-note">Confermando il pagamento, i giochi verranno aggiunti direttamente alla tua libreria personale.</p>
            </aside>
        </div>
    </main>
</body>
</html>
