<?php
session_start();
include 'connect_db.php';
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

$id_u = (int) $_SESSION['id_utente'];
$sql = "SELECT giochi.*, AVG(recensioni.voto) AS media_voti
        FROM giochi 
        JOIN libreria ON giochi.id = libreria.id_gioco 
        LEFT JOIN recensioni ON giochi.id = recensioni.id_gioco
        WHERE libreria.id_utente = ? 
        GROUP BY giochi.id
        ORDER BY giochi.titolo ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_u);
$stmt->execute();
$ris = $stmt->get_result();
$library = [];
while ($row = $ris->fetch_assoc()) {
    $library[] = $row;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault - Libreria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">RevU</a>
            <nav class="nav-group">
                <a href="index.php" class="nav-link">Home</a>
                <a href="catalogue.php" class="nav-link">Catalogo</a>
                <a href="library.php" class="nav-link active">Libreria</a>
                <a href="profile.php" class="nav-link"><img class='pfp' src="assets/pfp.png" alt="pfpimg" height="25px" width="25px"></a>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="section-head section-head-tight">
            <div>
                <p class="eyebrow">Raccolta personale</p>
                <h1>I tuoi giochi</h1>
            </div>
            <p class="section-note">La libreria ora usa card complete come il catalogo, così ogni titolo resta leggibile e coerente.</p>
        </div>

        <?php if (!empty($library)): ?>
            <div class="grid">
                <?php foreach ($library as $g): ?>
                    <article class="card game-card">
                        <img src="<?php echo htmlspecialchars($g['immagine']); ?>" alt="<?php echo htmlspecialchars($g['titolo']); ?>" class="card-image">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($g['titolo']); ?></h3>
                            <p class="desc-text"><?php echo htmlspecialchars(strlen($g['descrizione']) > 88 ? substr($g['descrizione'], 0, 85) . '...' : $g['descrizione']); ?></p>
                            <div class="card-meta">
                                <span class="library-badge">Nella tua libreria</span>
                                <span class="rating-pill">
                                    ★
                                    <?php if ($g['media_voti']): ?>
                                        <?= number_format($g['media_voti'], 1) ?>
                                    <?php else: ?>
                                        Nessun voto
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="card-actions">
                                <a href="game.php?id=<?php echo $g['id']; ?>" class="btn-small">Apri scheda</a>
                                <a href="game.php?id=<?php echo $g['id']; ?>#recensioni" class="btn-buy btn-buy-compact">Recensisci</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>La tua libreria è ancora vuota</h3>
                <p>Acquista i primi titoli dal catalogo e troverai qui la tua raccolta completa.</p>
                <a href="catalogue.php" class="btn btn-primary">Sfoglia il catalogo</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
