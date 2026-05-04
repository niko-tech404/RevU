<?php
session_start();
include 'connect_db.php';

$search = trim($_GET['q'] ?? '');
$results = [];

if ($search !== '') {
    $stmt = $conn->prepare("SELECT * FROM giochi WHERE titolo LIKE ? ORDER BY titolo ASC");
    $searchTerm = "%$search%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $ris = $stmt->get_result();
} else {
    $ris = $conn->query("SELECT * FROM giochi ORDER BY titolo ASC");
}

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
    <title>Catalogo Giochi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">STORE</a>
            <nav class="nav-right">
                <a href="index.php" class="nav-link">Home</a>
                <a href="catalogue.php" class="nav-link active">Catalogo</a>
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
        <section class="search-bar">
            <form action="catalogue.php" method="GET">
                <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cerca un gioco...">
                <button type="submit" class="btn">Cerca</button>
            </form>
        </section>

        <section class="grid-section">
            <?php if (!empty($results)): ?>
                <div class="grid">
                    <?php foreach ($results as $g): ?>
                        <div class="card">
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($g['titolo']); ?></h3>
                                <div class="card-footer">
                                    <span class="price"><?php echo number_format($g['prezzo'], 2, ',', '.'); ?> €</span>
                                    <a href="game.php?id=<?php echo $g['id']; ?>" class="btn-small">Apri</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>Nessun risultato trovato. Riprova con termini diversi.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>