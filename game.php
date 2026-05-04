<?php
session_start();
include 'connect_db.php';
$id_gioco = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$ris = $conn->query("SELECT * FROM giochi WHERE id = $id_gioco");
$g = $ris->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($g['titolo']); ?></title>
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
                <a href="catalogue.php" class="btn active">Catalogo</a>
                <?php if (isset($_SESSION['id_utente'])): ?>
                    <a href="library.php" class="btn">Libreria</a>
                    <a href="profile.php" class="btn">Profilo</a>
                <?php else: ?>
                    <a href="login.php" class="btn">Log In</a>
                    <a href="signup.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="shell-container stack">
        <section class="game-layout">
            <article class="detail-card stack">
                <div class="game-heading">
                    <span class="eyebrow">Game detail</span>
                    <h1><?php echo htmlspecialchars($g['titolo']); ?></h1>
                </div>

                <div class="media-frame">
                    <div class="media-label">
                        <strong><?php echo htmlspecialchars($g['titolo']); ?></strong>
                        <span>Premium storefront presentation</span>
                    </div>
                </div>

                <div class="game-copy">
                    <p><?php echo htmlspecialchars($g['descrizione']); ?></p>
                    <div class="info-grid">
                        <div class="meta-row">
                            <strong>Prezzo</strong>
                            <span><?php echo number_format((float) $g['prezzo'], 2, ',', '.'); ?> EUR</span>
                        </div>
                        <div class="meta-row">
                            <strong>Delivery</strong>
                            <span>Digital unlock immediato</span>
                        </div>
                    </div>
                </div>
            </article>

            <aside class="purchase-card stack">
                <div>
                    <span class="eyebrow">Purchase panel</span>
                    <h3>Acquisto rapido</h3>
                </div>
                <span class="price-tag">
                    <strong><?php echo number_format((float) $g['prezzo'], 2, ',', '.'); ?> EUR</strong>
                    <span>one-time payment</span>
                </span>
                <p>Il pannello laterale resta leggibile nel tema scuro, con CTA stabili, margini piu generosi e comportamento pulito anche su mobile.</p>

                <?php if (isset($_SESSION['id_utente'])): ?>
                    <div class="detail-actions">
                        <a href="buy.php?id=<?php echo $g['id']; ?>" class="btn btn-primary">Acquista ora</a>
                        <a href="library.php" class="btn">Vai alla libreria</a>
                    </div>
                <?php else: ?>
                    <div class="notice">Devi fare log in per acquistare questo gioco.</div>
                    <div class="detail-actions">
                        <a href="login.php" class="btn btn-primary">Accedi</a>
                        <a href="signup.php" class="btn">Crea account</a>
                    </div>
                <?php endif; ?>
            </aside>
        </section>
    </main>
</body>
</html>
