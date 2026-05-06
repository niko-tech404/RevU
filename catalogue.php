<?php
session_start();
include 'connect_db.php';

// 1. GESTIONE INPUT (Semplice e leggibile)
$cerca_nome = $_GET['q'] ?? '';
$allowedOrders = [
    'titolo ASC' => 'titolo ASC',
    'prezzo ASC' => 'prezzo ASC',
    'prezzo DESC' => 'prezzo DESC'
];
$ordina_per = $_GET['order'] ?? 'titolo ASC'; // Default Alfabetico
$ordina_per = $allowedOrders[$ordina_per] ?? 'titolo ASC';

$termine_sicuro = $conn->real_escape_string($cerca_nome);

// 2. COSTRUZIONE QUERY
$sql = "SELECT giochi.*, AVG(recensioni.voto) AS media_voti
        FROM giochi
        LEFT JOIN recensioni ON giochi.id = recensioni.id_gioco";

if (!empty($cerca_nome)) {
    $sql .= " WHERE giochi.titolo LIKE '%$termine_sicuro%'";
}

$sql .= " GROUP BY giochi.id ORDER BY $ordina_per";
$lista_giochi = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Vault - Catalogo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand brand-small">VAULT</a>
            <nav class="nav-group">
                <a href="index.php" class="nav-link">Home</a>
                <a href="catalogue.php" class="nav-link active">Catalogo</a>
                <?php if(isset($_SESSION['id_utente'])): ?>
                    <a href="library.php" class="nav-link">Libreria</a>
                    <a href="cart.php" class="nav-link">Carrello (<?= count($_SESSION['carrello'] ?? []) ?>)</a>
                    <a href="profile.php" class="nav-link">Profilo</a>
                    <a href="logout.php" class="nav-link">Esci</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Accedi</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container catalogo-layout">
        
        <!-- AREA GIOCHI (3 per fila) -->
        <section class="catalogue-results">
            <div class="section-head section-head-tight">
                <div>
                    <p class="eyebrow">Store</p>
                    <h1>Catalogo giochi</h1>
                </div>
                <p class="section-note">Scopri i titoli disponibili e passa dal dettaglio all'acquisto con un flusso più diretto.</p>
            </div>

            <div class="grid">
            <?php if ($lista_giochi->num_rows > 0): ?>
                <?php while($gioco = $lista_giochi->fetch_assoc()): ?>
                    <article class="card game-card">
                        <img src="<?= htmlspecialchars($gioco['immagine']) ?>" alt="<?= htmlspecialchars($gioco['titolo']) ?>" class="card-image">
                        <div class="card-content">
                            <h3><?= htmlspecialchars($gioco['titolo']) ?></h3>
                            <p class="desc-text"><?= htmlspecialchars(strlen($gioco['descrizione']) > 88 ? substr($gioco['descrizione'], 0, 85) . '...' : $gioco['descrizione']) ?></p>

                            <div class="card-meta">
                                <span class="price">
                                    <?= number_format($gioco['prezzo'], 2) ?> €
                                </span>
                                <span class="rating-pill">
                                    ★
                                    <?php if ($gioco['media_voti']): ?>
                                        <?= number_format($gioco['media_voti'], 1) ?>
                                    <?php else: ?>
                                        Nessun voto
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="card-actions">
                                <a href="game.php?id=<?= $gioco['id'] ?>" class="btn-small">Scheda</a>
                                <a href="checkout.php?direct_id=<?= $gioco['id'] ?>" class="btn-buy btn-buy-compact">Acquista</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>Nessun gioco trovato</h3>
                    <p>Prova a cambiare ricerca o ordinamento per vedere altri risultati.</p>
                    <a href="catalogue.php" class="btn btn-primary">Ripristina filtri</a>
                </div>
            <?php endif; ?>
            </div>
        </section>

        <!-- SIDEBAR RICERCA (A destra) -->
        <aside class="sidebar-filtri">
            <form method="GET" class="filter-form">
                <div class="filter-card">
                    <div class="filter-card-head">
                        <h2>Filtri rapidi</h2>
                        <p>La ricerca resta semplice e immediata.</p>
                    </div>

                    <label class="filtro-label">Ricerca rapida</label>
                    <input type="text" name="q" class="search-sidebar" placeholder="Scrivi qui..." value="<?= htmlspecialchars($cerca_nome) ?>">
                    
                    <label class="filtro-label">Ordina</label>
                    <select name="order" class="select-custom" onchange="this.form.submit()">
                        <option value="titolo ASC" <?= $ordina_per == 'titolo ASC' ? 'selected' : '' ?>>A-Z</option>
                        <option value="prezzo ASC" <?= $ordina_per == 'prezzo ASC' ? 'selected' : '' ?>>Prezzo Min</option>
                        <option value="prezzo DESC" <?= $ordina_per == 'prezzo DESC' ? 'selected' : '' ?>>Prezzo Max</option>
                    </select>

                    <button type="submit" class="btn-buy btn-full">Aggiorna risultati</button>
                </div>
            </form>
        </aside>

    </main>
</body>
</html>
