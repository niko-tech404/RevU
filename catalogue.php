<?php
session_start();
include 'connect_db.php';

// 1. GESTIONE INPUT (Semplice e leggibile)
$cerca_nome = $_GET['q'] ?? '';
$ordina_per = $_GET['order'] ?? 'titolo ASC'; // Default Alfabetico

$termine_sicuro = $conn->real_escape_string($cerca_nome);

// 2. COSTRUZIONE QUERY
$sql = "SELECT * FROM giochi";

if (!empty($cerca_nome)) {
    $sql .= " WHERE titolo LIKE '%$termine_sicuro%'";
}

$sql .= " ORDER BY $ordina_per";
$lista_giochi = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Catalogo - 3 per fila</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand" style="font-size: 16px;">VAULT</a>
            <nav class="nav-group">
                <a href="index.php" class="nav-link">Store</a>
                <?php if(isset($_SESSION['id_utente'])): ?>
                    <a href="logout.php" class="nav-link">Esci</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Accedi</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container catalogo-layout">
        
        <!-- AREA GIOCHI (3 per fila) -->
        <section class="grid">
            <?php if ($lista_giochi->num_rows > 0): ?>
                <?php while($gioco = $lista_giochi->fetch_assoc()): ?>
                    <article class="card">
                        <img src="<?= $gioco['immagine'] ?>" class="card-image">
                        <div class="card-content">
                            <h3><?= htmlspecialchars($gioco['titolo']) ?></h3>
                            <div class="card-footer" style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-weight:700; font-size:14px;"><?= number_format($gioco['prezzo'], 2) ?> €</span>
                                <a href="game.php?id=<?= $gioco['id'] ?>" class="btn-small">Apri</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nessun gioco trovato.</p>
            <?php endif; ?>
        </section>

        <!-- SIDEBAR RICERCA (A destra) -->
        <aside class="sidebar-filtri">
            <form method="GET">
                <label class="filtro-label">Ricerca rapida</label>
                <input type="text" name="q" class="search-sidebar" placeholder="Scrivi qui..." value="<?= htmlspecialchars($cerca_nome) ?>">
                
                <label class="filtro-label">Ordina</label>
                <select name="order" class="select-custom" onchange="this.form.submit()">
                    <option value="titolo ASC" <?= $ordina_per == 'titolo ASC' ? 'selected' : '' ?>>A-Z</option>
                    <option value="prezzo ASC" <?= $ordina_per == 'prezzo ASC' ? 'selected' : '' ?>>Prezzo Min</option>
                </select>
                
                <button type="submit" class="btn-buy" style="width:100%; margin-top:15px; font-size:12px;">Aggiorna</button>
            </form>
        </aside>

    </main>
</body>
</html>