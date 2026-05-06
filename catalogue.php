<?php
session_start();
include 'connect_db.php';

// Gestione Ricerca
$search = trim($_GET['q'] ?? '');
$escapedSearch = $conn->real_escape_string($search);

$sql = "SELECT * FROM giochi";
if ($search !== '') {
    $sql .= " WHERE titolo LIKE '%$escapedSearch%'";
}
$sql .= " ORDER BY titolo ASC";
$ris = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo Giochi - Store 2026</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">GAMER_VAULT</a>
            <nav class="nav-group">
                <a href="index.php" class="nav-link">Home</a>
                <a href="catalogue.php" class="nav-link active">Catalogo</a>
                <?php if(isset($_SESSION['id_utente'])): ?>
                    <a href="library.php" class="nav-link">Libreria</a>
                    <a href="logout.php" class="nav-link" style="color: #ff453a;">Esci</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Accedi</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="container">
        <!-- Hero Section con Ricerca Raggruppata -->
        <section style="padding: 40px 0;">
            <h1 style="font-size: 42px; letter-spacing: -2px; margin-bottom: 10px;">Catalogo</h1>
            <p style="color: rgba(255,255,255,0.5); margin-bottom: 30px;">Esplora i migliori titoli della generazione.</p>

            <div class="search-group">
                <form action="catalogue.php" method="GET" class="search-container">
                    <input type="text" name="q" class="search-input" 
                           placeholder="Cerca un titolo..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="search-btn">Cerca</button>
                </form>
            </div>
        </section>

        <!-- Griglia Giochi -->
        <div class="grid">
            <?php if ($ris && $ris->num_rows > 0): ?>
                <?php while($g = $ris->fetch_assoc()): ?>
                    <article class="card">
                        <!-- Immagine locale da assets/game/ -->
                        <img src="<?php echo htmlspecialchars($g['immagine']); ?>" 
                             alt="Cover <?php echo htmlspecialchars($g['titolo']); ?>" 
                             class="card-image">
                        
                        <div class="card-content">
                            <div>
                                <h3><?php echo htmlspecialchars($g['titolo']); ?></h3>
                                <p class="desc-text">Esperienza digitale completa.</p>
                            </div>
                            
                            <div class="card-footer">
                                <span class="price">
                                    <?php echo ($g['prezzo'] == 0) ? 'Gratis' : number_format($g['prezzo'], 2) . ' €'; ?>
                                </span>
                                <a href="game.php?id=<?php echo $g['id']; ?>" class="btn-small">Dettagli</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <p style="color: rgba(255,255,255,0.5);">Nessun gioco trovato per questa ricerca.</p>
                    <a href="catalogue.php" style="color: #0a84ff; text-decoration: none; margin-top: 10px; display: block;">Mostra tutti</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>