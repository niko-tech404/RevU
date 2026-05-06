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
    // Check di consistenza con prepared statement per evitare abusi o duplicate key
    $stmtCheck = $conn->prepare("SELECT 1 FROM libreria WHERE id_utente = ? AND id_gioco = ? LIMIT 1");
    $stmtCheck->bind_param("ii", $id_u, $id_g);
    $stmtCheck->execute();
    $alreadyOwned = $stmtCheck->get_result();

    if ($alreadyOwned->num_rows === 0) {
        $stmtInsert = $conn->prepare("INSERT INTO libreria (id_utente, id_gioco) VALUES (?, ?)");
        $stmtInsert->bind_param("ii", $id_u, $id_g);
        $stmtInsert->execute();
    }
}

header("Location: library.php");
exit();
?>