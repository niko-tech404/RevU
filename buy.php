<?php
session_start();
include 'connect_db.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

$id_u = (int) $_SESSION['id_utente'];
$id_g = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id_g > 0) {
    $checkSql = "SELECT 1 FROM libreria WHERE id_utente = $id_u AND id_gioco = $id_g LIMIT 1";
    $alreadyOwned = $conn->query($checkSql);

    if ($alreadyOwned && $alreadyOwned->num_rows === 0) {
        $sql = "INSERT INTO libreria (id_utente, id_gioco) VALUES ($id_u, $id_g)";
        $conn->query($sql);
    }
}

header("Location: library.php");
exit();
?>
