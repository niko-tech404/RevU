<?php
session_start();
include 'connect_db.php';

$games = [];
$result = $conn->query("SELECT * FROM giochi");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}

$featuredGames = array_slice($games, 0, 4);
$heroGame = $featuredGames[0] ?? null;
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam Clone - Home</title>
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
                <a href="index.php" class="btn active">Home</a>
                <a href="catalogue.php" class="btn">Catalogo</a>
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
        <section class="hero-panel">
            <div class="hero-copy">
                <span class="eyebrow">In evidenza</span>
                <h1>Contenuti premium, sconti visibili e una UI scura che finalmente respira.</h1>
                <p>La home ora funziona come hub principale: un hero editoriale con focus sui giochi in evidenza, palette multi-colore ben dosata, tab flottanti e spacing piu ampio su tutta la pagina.</p>
                <div class="hero-actions">
                    <a href="catalogue.php" class="btn btn-primary">Apri game list</a>
                    <?php if (isset($_SESSION['id_utente'])): ?>
                        <a href="library.php" class="btn">Vai ai tuoi acquisti</a>
                    <?php else: ?>
                        <a href="signup.php" class="btn">Crea account</a>
                    <?php endif; ?>
                </div>
                <div class="hero-stats">
                    <div class="stat-chip">
                        <strong><?php echo count($games); ?> titoli</strong>
                        <span>catalogo collegato al database</span>
                    </div>
                    <div class="stat-chip">
                        <strong>Dark glass UI</strong>
                        <span>blur profondo e contrasti puliti</span>
                    </div>
                    <div class="stat-chip">
                        <strong>Responsive</strong>
                        <span>margini piu larghi e layout piu fluidi</span>
                    </div>
                </div>
            </div>

            <div class="hero-preview">
                <div class="floating-tabs">
                    <span class="tab-pill active">Featured</span>
                    <span class="tab-pill">Deals</span>
                    <span class="tab-pill">New</span>
                    <span class="tab-pill">Top rated</span>
                </div>

                <div class="showcase-card">
                    <div class="showcase-grid">
                        <div class="showcase-tile discount">
                            <span class="discount-badge">-40%</span>
                            <h3><?php echo htmlspecialchars($heroGame['titolo'] ?? 'Game Spotlight'); ?></h3>
                            <p>Promo hero con card ampia, riflessi morbidi e pricing in evidenza.</p>
                        </div>
                        <div class="showcase-tile highlight">
                            <span class="eyebrow">UI update</span>
                            <h3>Navbar riallineata</h3>
                            <p>Logo a sinistra, tutte le azioni a destra.</p>
                        </div>
                        <div class="showcase-tile">
                            <span class="eyebrow">Fluidity</span>
                            <h3>Hover e motion</h3>
                            <p>Animazioni piu leggere e leggibili.</p>
                        </div>
                        <div class="showcase-tile">
                            <span class="eyebrow">Spacing</span>
                            <h3>Page breathing</h3>
                            <p>Più margine laterale e pannelli meno attaccati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-section">
            <div class="section-shell">
                <div class="section-heading">
                    <div>
                        <span class="eyebrow">Sconti del momento</span>
                        <h2>Giochi in evidenza</h2>
                        <p>Questa sezione mostra i titoli principali con impostazione piu commerciale: prezzo, promo e accesso diretto alla scheda gioco.</p>
                    </div>
                </div>

                <div class="card-grid">
                    <?php foreach ($featuredGames as $index => $gioco): ?>
                        <?php
                        $discount = 20 + ($index * 10);
                        $price = (float) $gioco['prezzo'];
                        $oldPrice = $price > 0 ? $price / (1 - ($discount / 100)) : $price;
                        ?>
                        <article class="card">
                            <div class="card-topline">
                                <span class="eyebrow">-<?php echo $discount; ?>%</span>
                                <span class="label">featured deal</span>
                            </div>
                            <div class="card-media">
                                <div class="media-label">
                                    <strong><?php echo htmlspecialchars($gioco['titolo']); ?></strong>
                                    <span>Limited promo</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3><?php echo htmlspecialchars($gioco['titolo']); ?></h3>
                                <p>Prezzo scontato e layout promozionale coerente con la nuova home, pensato per dare gerarchia vera ai contenuti.</p>
                                <div class="card-topline">
                                    <span class="price-tag">
                                        <strong><?php echo number_format($price, 2, ',', '.'); ?> EUR</strong>
                                        <span>prima <?php echo number_format($oldPrice, 2, ',', '.'); ?> EUR</span>
                                    </span>
                                    <a href="game.php?id=<?php echo $gioco['id']; ?>" class="card-link">Apri scheda</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
