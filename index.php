<?php
session_start();
include 'connect_db.php';

$games = [];
$result = $conn->query("SELECT giochi.*, AVG(recensioni.voto) AS media_voti
                        FROM giochi
                        LEFT JOIN recensioni ON giochi.id = recensioni.id_gioco
                        GROUP BY giochi.id
                        LIMIT 8");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}

$featuredGames = array_slice($games, 0, 4);
$discountGames = array_slice($games, 4, 4);
$heroGame = $featuredGames[0] ?? null;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">VAULT</a>
            <nav class="nav-group">
                <a href="index.php" class="nav-link active">Home</a>
                <a href="catalogue.php" class="nav-link">Catalogo</a>
                <?php if (isset($_SESSION['id_utente'])): ?>
                    <a href="library.php" class="nav-link">Libreria</a>
                    <a href="profile.php" class="nav-link">Profilo</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Accedi</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero hero-home">
            <div class="hero-copy">
                <span class="hero-label">Catalogo curato</span>
                <h1>Scopri la tua prossima avventura</h1>
                <p>Un catalogo essenziale, con giochi scelti bene, acquisto veloce e una libreria chiara da usare davvero.</p>
                <div class="hero-actions">
                    <a href="catalogue.php" class="btn-buy">Esplora il catalogo</a>
                    <?php if (isset($_SESSION['id_utente'])): ?>
                        <a href="library.php" class="btn btn-secondary">Apri la libreria</a>
                    <?php else: ?>
                        <a href="signup.php" class="btn btn-secondary">Crea account</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($heroGame): ?>
                <article class="hero-spotlight">
                    <img src="<?= htmlspecialchars($heroGame['immagine']) ?>" alt="<?= htmlspecialchars($heroGame['titolo']) ?>" class="hero-spotlight-image">
                    <div class="hero-spotlight-content">
                        <p class="eyebrow">In primo piano</p>
                        <h2><?= htmlspecialchars($heroGame['titolo']) ?></h2>
                        <p><?= htmlspecialchars($heroGame['descrizione']) ?></p>
                        <div class="hero-spotlight-meta">
                            <span class="price"><?= number_format($heroGame['prezzo'], 2, ',', '.') ?> €</span>
                            <span class="rating-pill">
                                ★
                                <?php if ($heroGame['media_voti']): ?>
                                    <?= number_format($heroGame['media_voti'], 1, ',', '.') ?>/5
                                <?php else: ?>
                                    Nuovo
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="hero-spotlight-actions">
                            <a href="game.php?id=<?= $heroGame['id'] ?>" class="btn-small">Dettagli</a>
                            <a href="add_to_cart.php?id=<?= $heroGame['id'] ?>" class="btn-buy btn-buy-compact">Acquista</a>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
        </section>

        <section class="content-section">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Selezione</p>
                    <h2>In evidenza</h2>
                </div>
                <p class="section-note">I titoli più forti del catalogo, messi subito in risalto.</p>
            </div>
            <div class="grid">
                <?php foreach ($featuredGames as $gioco): ?>
                    <article class="card game-card">
                        <img src="<?= htmlspecialchars($gioco['immagine']) ?>" alt="<?= htmlspecialchars($gioco['titolo']) ?>" class="card-image">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($gioco['titolo']); ?></h3>
                            <p class="desc-text"><?php echo htmlspecialchars(strlen($gioco['descrizione']) > 88 ? substr($gioco['descrizione'], 0, 85) . '...' : $gioco['descrizione']); ?></p>
                            <div class="card-meta">
                                <span class="rating-pill">
                                    ★
                                    <?php if ($gioco['media_voti']): ?>
                                        <?= number_format($gioco['media_voti'], 1, ',', '.') ?>
                                    <?php else: ?>
                                        Nessun voto
                                    <?php endif; ?>
                                </span>
                                <span class="price"><?php echo number_format($gioco['prezzo'], 2, ',', '.'); ?> €</span>
                            </div>
                            <div class="card-actions">
                                <a href="game.php?id=<?php echo $gioco['id']; ?>" class="btn-small">Dettagli</a>
                                <a href="add_to_cart.php?id=<?php echo $gioco['id']; ?>" class="btn-buy btn-buy-compact">Acquista</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="content-section">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Prezzi vantaggiosi</p>
                    <h2>Sconti</h2>
                </div>
                <p class="section-note">Una selezione rapida di giochi dal prezzo più accessibile del catalogo.</p>
            </div>
            <div class="grid">
                <?php foreach ($discountGames as $gioco): ?>
                    <article class="card game-card game-card-discount">
                        <div class="discount-badge">Offerta</div>
                        <img src="<?= htmlspecialchars($gioco['immagine']) ?>" alt="<?= htmlspecialchars($gioco['titolo']) ?>" class="card-image">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($gioco['titolo']); ?></h3>
                            <p class="desc-text"><?php echo htmlspecialchars(strlen($gioco['descrizione']) > 78 ? substr($gioco['descrizione'], 0, 75) . '...' : $gioco['descrizione']); ?></p>
                            <div class="card-footer">
                                <span class="price"><?php echo number_format($gioco['prezzo'], 2, ',', '.'); ?> €</span>
                                <a href="checkout.php?direct_id=<?php echo $gioco['id']; ?>" class="btn-buy btn-buy-compact">Acquista</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>
