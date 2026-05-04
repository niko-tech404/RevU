<?php
session_start();
include 'connect_db.php';
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

$id_u = (int) $_SESSION['id_utente'];
$sort = $_GET['sort'] ?? 'alpha';
$allowedSorts = ['alpha', 'date'];
if (!in_array($sort, $allowedSorts, true)) {
    $sort = 'alpha';
}

$dateColumn = null;
$columnResult = $conn->query("SHOW COLUMNS FROM libreria");
if ($columnResult) {
    while ($column = $columnResult->fetch_assoc()) {
        if (in_array($column['Field'], ['data_acquisto', 'created_at', 'purchase_date'], true)) {
            $dateColumn = $column['Field'];
            break;
        }
    }
}

$orderBy = "giochi.titolo ASC";
$sortLabel = "Ordine alfabetico";
if ($sort === 'date') {
    if ($dateColumn !== null) {
        $orderBy = "libreria.$dateColumn DESC, giochi.titolo ASC";
        $sortLabel = "Ordine per data di acquisto";
    } else {
        $sortLabel = "Data di acquisto non disponibile: fallback alfabetico";
    }
}

$sql = "SELECT giochi.*, libreria.id_gioco";
if ($dateColumn !== null) {
    $sql .= ", libreria.$dateColumn AS data_acquisto";
}
$sql .= " FROM giochi
        JOIN libreria ON giochi.id = libreria.id_gioco
        WHERE libreria.id_utente = $id_u
        ORDER BY $orderBy";

$ris = $conn->query($sql);
$games = [];
if ($ris) {
    while ($row = $ris->fetch_assoc()) {
        $games[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La mia Libreria</title>
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
                <a href="library.php" class="btn active">Libreria</a>
                <a href="profile.php" class="btn">Profilo</a>
            </div>
        </div>
    </header>

    <main class="shell-container stack">
        <section class="section-shell">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Acquisti</span>
                    <h2>Giochi acquistati</h2>
                    <p>La libreria e stata ridotta a una sola vista utile: elenco dei tuoi giochi con ordinamento alfabetico o per data di acquisto quando disponibile nello schema.</p>
                </div>
            </div>

            <div class="toolbar-shell">
                <div class="tab-shell">
                    <span class="tab-pill active">Giochi acquistati</span>
                </div>

                <form action="library.php" method="GET" class="toolbar-row">
                    <div class="sort-shell">
                        <div class="sort-field">
                            <label for="sort">Ordina per</label>
                            <select id="sort" name="sort">
                                <option value="alpha" <?php echo $sort === 'alpha' ? 'selected' : ''; ?>>Ordine alfabetico</option>
                                <option value="date" <?php echo $sort === 'date' ? 'selected' : ''; ?>>Data di acquisto</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">Applica</button>
                    </div>
                    <span class="result-info"><?php echo htmlspecialchars($sortLabel); ?></span>
                </form>
            </div>

            <?php if (count($games) > 0): ?>
                <div class="card-grid mt-8">
                    <?php foreach ($games as $g): ?>
                        <article class="card">
                            <div class="card-topline">
                                <span class="eyebrow">Owned</span>
                                <span class="label">
                                    <?php
                                    if (isset($g['data_acquisto']) && $g['data_acquisto']) {
                                        echo htmlspecialchars($g['data_acquisto']);
                                    } else {
                                        echo 'stored purchase';
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="card-media">
                                <div class="media-label">
                                    <strong><?php echo htmlspecialchars($g['titolo']); ?></strong>
                                    <span>Purchased title</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3><?php echo htmlspecialchars($g['titolo']); ?></h3>
                                <p>Vista dedicata agli acquisti con ordinamento semplice, card piu compatte e una sola tab funzionale.</p>
                                <a href="game.php?id=<?php echo $g['id']; ?>" class="card-link">Apri dettaglio</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state library-empty mt-8">
                    <h3>Nessun gioco acquistato</h3>
                    <p>La tua libreria e vuota. Quando completi un acquisto, il titolo verra mostrato qui con l’ordinamento selezionato.</p>
                    <div class="hero-actions actions-center mt-8">
                        <a href="catalogue.php" class="btn btn-primary">Vai al catalogo</a>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
