<?php
session_start();

$id = (int)($_GET['id'] ?? 0);

if (!empty($_SESSION['carrello']) && $id > 0) {
    $carrello_aggiornato = [];

    foreach ($_SESSION['carrello'] as $item) {
        if ((int) $item !== $id) {
            $carrello_aggiornato[] = $item;
        }
    }

    $_SESSION['carrello'] = $carrello_aggiornato;
}

header("Location: cart.php");
exit();
