<?php
session_start();
include 'connect_db.php';

$games = [];
$result = $conn->query("SELECT * FROM giochi LIMIT 8");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
}

$featuredGames = array_slice($games, 0, 4);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">STORE</a>
            <nav class="nav-right">
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
        <section class="hero">
            <h1>Scopri la tua prossima avventura</h1>
            <p>Esplora i migliori titoli selezionati per te, senza distrazioni.</p>
        </section>

        <section class="grid-section">
            <h2>In evidenza</h2>
            <div class="grid">
                <?php foreach ($featuredGames as $gioco): ?>
                    <div class="card">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($gioco['titolo']); ?></h3>
                            <div class="card-footer">
                                <span class="price"><?php echo number_format($gioco['prezzo'], 2, ',', '.'); ?> €</span>
                                <a href="game.php?id=<?php echo $gioco['id']; ?>" class="btn-small">Dettagli</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>