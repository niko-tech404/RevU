<?php
session_start();
include 'connect_db.php';

$search = trim($_GET['q'] ?? '');
$escapedSearch = $conn->real_escape_string($search);

$sql = "SELECT * FROM giochi";
if ($search !== '') {
    $sql .= " WHERE titolo LIKE '%$escapedSearch%'";
}
$sql .= " ORDER BY titolo ASC";

$ris = $conn->query($sql);
$results = [];
if ($ris) {
    while ($row = $ris->fetch_assoc()) {
        $results[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
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
        <section class="section-shell">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Game list</span>
                    <h2>Catalogo giochi</h2>
                    <p>Qui c’e solo quello che serve: ricerca, risultati e stato vuoto chiaro se un titolo non e caricato nel database.</p>
                </div>
            </div>

            <div class="toolbar-shell">
                <form action="catalogue.php" method="GET" class="search-shell">
                    <input
                        class="search-input"
                        type="search"
                        name="q"
                        value="<?php echo htmlspecialchars($search); ?>"
                        placeholder="Cerca un titolo..."
                    >
                    <button class="btn btn-primary" type="submit">Cerca</button>
                </form>

                <div class="toolbar-row">
                    <div class="search-meta">
                        <span class="eyebrow">Search</span>
                        <span class="result-info">
                            <?php if ($search !== ''): ?>
                                Risultati per "<?php echo htmlspecialchars($search); ?>"
                            <?php else: ?>
                                Tutti i titoli ordinati alfabeticamente
                            <?php endif; ?>
                        </span>
                    </div>
                    <span class="result-info"><?php echo count($results); ?> risultati</span>
                </div>
            </div>

            <?php if (count($results) > 0): ?>
                <div class="card-grid mt-8">
                    <?php foreach ($results as $g): ?>
                        <article class="card">
                            <div class="card-topline">
                                <span class="eyebrow">Ready</span>
                                <span class="label"><?php echo number_format((float) $g['prezzo'], 2, ',', '.'); ?> EUR</span>
                            </div>
                            <div class="card-media">
                                <div class="media-label">
                                    <strong><?php echo htmlspecialchars($g['titolo']); ?></strong>
                                    <span>Search result</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3><?php echo htmlspecialchars($g['titolo']); ?></h3>
                                <p>Risultato del catalogo con card piu leggibile, spacing piu ampio e accesso diretto alla scheda dettaglio.</p>
                                <div class="card-topline">
                                    <span class="price-tag">
                                        <strong><?php echo number_format((float) $g['prezzo'], 2, ',', '.'); ?> EUR</strong>
                                        <span>digital access</span>
                                    </span>
                                    <a href="game.php?id=<?php echo $g['id']; ?>" class="card-link">Apri scheda</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state catalog-empty mt-8">
                    <h3>Gioco non caricato</h3>
                    <p>Il titolo cercato non e presente nel catalogo attuale. Se serve, va inserito nel database prima che compaia nella game list.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
