<?php
session_start();
include 'connect_db.php';

if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int) $_SESSION['id_utente'];
    $direct_id = (int)($_POST['direct_id'] ?? 0);
    $stmt = $conn->prepare("INSERT IGNORE INTO libreria (id_utente, id_gioco) VALUES (?, ?)");

    if ($direct_id > 0) {
        $stmt->bind_param("ii", $user_id, $direct_id);
        $stmt->execute();

        if (!empty($_SESSION['carrello'])) {
            $carrello_aggiornato = [];
            foreach ($_SESSION['carrello'] as $item) {
                if ((int) $item !== $direct_id) {
                    $carrello_aggiornato[] = $item;
                }
            }
            $_SESSION['carrello'] = $carrello_aggiornato;
        }

        header("Location: library.php?order=success");
        exit();
    }

    if (!empty($_SESSION['carrello'])) {
        foreach ($_SESSION['carrello'] as $gioco_id) {
            $gioco_id = (int) $gioco_id;
            $stmt->bind_param("ii", $user_id, $gioco_id);
            $stmt->execute();
        }

        $_SESSION['carrello'] = []; // Svuota il carrello
        header("Location: library.php?order=success");
        exit();
    }
}

header("Location: catalogue.php");
exit();
