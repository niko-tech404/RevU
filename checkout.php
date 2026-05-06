<?php
session_start();
include 'connect_db.php';

if (!isset($_SESSION['id_utente'])) { header("Location: login.php"); exit(); }
if (empty($_SESSION['carrello'])) { header("Location: catalogue.php"); exit(); }

// Calcolo totale rapido
$ids = implode(',', array_map('intval', $_SESSION['carrello']));
$res = $conn->query("SELECT SUM(prezzo) as totale FROM giochi WHERE id IN ($ids)");
$row = $res->fetch_assoc();
$totale = $row['totale'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Vault</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <main class="container auth-wrapper">
        <div class="auth-card" style="max-width: 500px;">
            <h2>Checkout</h2>
            <p class="auth-subtitle">Totale da pagare: <strong><?= number_format($totale, 2) ?> €</strong></p>
            
            <form action="process_payment.php" method="POST">
                <div class="form-group">
                    <label>Intestatario</label>
                    <input type="text" name="nome" placeholder="Nome sulla carta" required>
                </div>
                <div class="form-group">
                    <label>Numero Carta</label>
                    <input type="text" name="card" placeholder="0000 0000 0000 0000" maxlength="16" required>
                </div>
                <div style="display: flex; gap: 20px;">
                    <div class="form-group">
                        <label>Scadenza</label>
                        <input type="text" name="exp" placeholder="MM/AA" required>
                    </div>
                    <div class="form-group">
                        <label>CVV</label>
                        <input type="password" name="cvv" placeholder="***" maxlength="3" required>
                    </div>
                </div>
                <button type="submit" class="btn-buy" style="width: 100%; border: none; margin-top: 20px;">Conferma e Paga</button>
            </form>
        </div>
    </main>
</body>
</html>