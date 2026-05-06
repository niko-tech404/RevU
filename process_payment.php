<?php
session_start();
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['carrello'])) {
    $user_id = $_SESSION['id_utente'];
    $stmt = $conn->prepare("INSERT IGNORE INTO libreria (id_utente, id_gioco) VALUES (?, ?)");

    foreach ($_SESSION['carrello'] as $gioco_id) {
        $stmt->bind_param("ii", $user_id, $gioco_id);
        $stmt->execute();
    }

    $_SESSION['carrello'] = []; // Svuota il carrello
    header("Location: library.php?order=success");
    exit();
}
header("Location: catalogue.php");
exit();