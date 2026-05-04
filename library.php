<?php
session_start();
include 'connect_db.php';
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

$id_u = (int) $_SESSION['id_utente'];
$sql = "SELECT giochi.* FROM giochi 
        JOIN libreria ON giochi.id = libreria.id_gioco 
        WHERE libreria.id_utente = ? 
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
    <title>La tua Libreria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">STORE</a>
            <nav class="nav-right">
                <a href="index.php" class="nav-link">Home</a>
                <a href="library.php" class="nav-link active">Libreria</a>
                <a href="profile.php" class="nav-link">Profilo</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1>I tuoi giochi</h1>
        <?php if (!empty($library)): ?>
            <div class="grid">
                <?php foreach ($library as $g): ?>
                    <div class="card">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($g['titolo']); ?></h3>
                            <div class="card-footer" style="margin-top: 1rem;">
                                <a href="game.php?id=<?php echo $g['id']; ?>" class="btn-small">Gioca ora</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>La tua libreria è ancora vuota. È il momento di popolarla.</p>
                <br>
                <a href="catalogue.php" class="btn btn-primary">Sfoglia il catalogo</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>