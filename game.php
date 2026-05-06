<?php
session_start();
include 'connect_db.php';

$id = (int)($_GET['id'] ?? 0);

/* Controllo se l'utente ha comprato il gioco */
$ha_comprato = false;

if (isset($_SESSION['id_utente'])) {
    $id_u = (int) $_SESSION['id_utente'];

    $check = $conn->prepare("SELECT * FROM libreria WHERE id_utente = ? AND id_gioco = ?");
    $check->bind_param("ii", $id_u, $id);
    $check->execute();
    $ris_check = $check->get_result();

    if ($ris_check->num_rows > 0) {
        $ha_comprato = true;
    }
}

/* Inserimento recensione */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $ha_comprato) {
    $voto = isset($_POST['voto']) ? (int) $_POST['voto'] : 0;
    $commento = $conn->real_escape_string($_POST['commento']);

    if ($voto >= 1 && $voto <= 5) {
        $id_u = (int) $_SESSION['id_utente'];

        $sql_recensione = "INSERT INTO recensioni (id_utente, id_gioco, voto, commento)
                           VALUES ($id_u, $id, $voto, '$commento')
                           ON DUPLICATE KEY UPDATE voto = $voto, commento = '$commento'";

        $conn->query($sql_recensione);
    }

    header("Location: game.php?id=$id");
    exit();
}

/* Prendo il gioco */
$query = "SELECT giochi.*, AVG(recensioni.voto) AS media_voti
          FROM giochi
          LEFT JOIN recensioni ON giochi.id = recensioni.id_gioco
          WHERE giochi.id = $id
          GROUP BY giochi.id";

$risultato = $conn->query($query);
$gioco = $risultato->fetch_assoc();

if (!$gioco) { 
    header("Location: catalogue.php"); 
    exit(); 
}

/* Prendo tutte le recensioni */
$sql_commenti = "SELECT recensioni.*, utenti.nickname
                 FROM recensioni
                 JOIN utenti ON recensioni.id_utente = utenti.id
                 WHERE recensioni.id_gioco = $id
                 ORDER BY recensioni.id DESC";

$commenti = $conn->query($sql_commenti);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($gioco['titolo']) ?> - Vault</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .stelle-input-finale {
            display: flex;
            justify-content: flex-start;
            gap: 6px;
            margin-top: 8px;
        }

        .stella-finale {
            display: inline-block;
            font-size: 36px;
            color: rgba(255,255,255,0.25);
            cursor: pointer;
            line-height: 1;
            user-select: none;
            transition: 0.2s;
        }

        .stella-finale:hover {
            transform: scale(1.08);
        }
    </style>
</head>
<body class="auth-page">
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">VAULT</a>
            <nav class="nav-group">
                <a href="catalogue.php" class="nav-link">Store</a>
                <a href="cart.php" class="nav-link">Carrello (<?= count($_SESSION['carrello'] ?? []) ?>)</a>
            </nav>
        </div>
    </header>

    <main class="container" style="margin-top: 120px;">

        <!-- BLOCCO PRINCIPALE GIOCO -->
        <div style="display: flex; gap: 40px; align-items: flex-start;">
            <div class="game-cover">
                <img src="<?= $gioco['immagine'] ?>" style="width: 300px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
            </div>
            
            <div class="game-info" style="flex: 1;">
                <h1><?= htmlspecialchars($gioco['titolo']) ?></h1>

                <div style="margin-top: 10px; color: #f5c542; font-size: 18px;">
                    ★
                    <span style="color: white;">
                        <?php if ($gioco['media_voti']): ?>
                            <?= number_format($gioco['media_voti'], 1) ?> / 5
                        <?php else: ?>
                            Nessuna valutazione
                        <?php endif; ?>
                    </span>
                </div>

                <p style="color: var(--text-dim); margin-top: 20px;">
                    <?= nl2br(htmlspecialchars($gioco['descrizione'])) ?>
                </p>
                
                <div class="purchase-card" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 20px; margin-top: 30px;">
                    <span style="font-size: 2rem; font-weight: 800;">
                        <?= number_format($gioco['prezzo'], 2) ?> €
                    </span>

                    <div style="margin-top: 20px; display: flex; gap: 15px;">
                        <a href="add_to_cart.php?id=<?= $gioco['id'] ?>" class="btn-buy" style="background: #323232; border: 1px solid #444;">Aggiungi al Carrello</a>
                        <a href="checkout.php?direct_id=<?= $gioco['id'] ?>" class="btn-buy">Acquista Ora</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- AREA RECENSIONI ORIZZONTALE TIPO COMMENTI -->
        <section class="recensioni-box" style="max-width: 100%; margin: 45px 0 0 0;">
            <h2>Recensioni</h2>

            <?php if (isset($_SESSION['id_utente'])): ?>

                <?php if ($ha_comprato): ?>
                    <form method="POST" class="recensione-form">
                        <label>Lascia la tua valutazione</label>

                        <input type="hidden" name="voto" id="voto" value="">

                        <div class="stelle-input-finale" id="stelleInputFinale">
                            <span class="stella-finale" data-voto="1">★</span>
                            <span class="stella-finale" data-voto="2">★</span>
                            <span class="stella-finale" data-voto="3">★</span>
                            <span class="stella-finale" data-voto="4">★</span>
                            <span class="stella-finale" data-voto="5">★</span>
                        </div>

                        <textarea name="commento" placeholder="Scrivi un commento se vuoi..."></textarea>

                        <button type="submit" class="btn-buy" style="border: none; margin-top: 15px; cursor: pointer;">
                            Invia recensione
                        </button>
                    </form>
                <?php else: ?>
                    <div class="recensione-form recensione-bloccata">
                        <label>Lascia la tua valutazione</label>

                        <div class="stelle-bloccate">
                            ★ ★ ★ ★ ★
                        </div>

                        <textarea disabled placeholder="Devi acquistare il gioco per commentare."></textarea>

                        <p style="font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 10px;">
                            Puoi leggere le recensioni, ma per votare devi acquistare il gioco.
                        </p>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="recensione-form recensione-bloccata">
                    <label>Lascia la tua valutazione</label>

                    <div class="stelle-bloccate">
                        ★ ★ ★ ★ ★
                    </div>

                    <textarea disabled placeholder="Accedi e acquista il gioco per commentare."></textarea>

                    <p style="font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 10px;">
                        Devi accedere e acquistare il gioco per lasciare una recensione.
                    </p>
                </div>
            <?php endif; ?>

            <div class="lista-recensioni">
                <h3>Commenti degli utenti</h3>

                <?php if ($commenti->num_rows > 0): ?>
                    <?php while($r = $commenti->fetch_assoc()): ?>
                        <div class="commento-card">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <strong><?= htmlspecialchars($r['nickname']) ?></strong>
                                <span style="color: #f5c542;">
                                    <?php for ($i = 1; $i <= $r['voto']; $i++): ?>
                                        ★
                                    <?php endfor; ?>
                                </span>
                            </div>

                            <?php if (!empty($r['commento'])): ?>
                                <p><?= nl2br(htmlspecialchars($r['commento'])) ?></p>
                            <?php else: ?>
                                <p style="opacity: 0.5;">Nessun commento scritto.</p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="opacity: 0.5; margin-top: 15px;">
                        Non ci sono ancora recensioni per questo gioco.
                    </p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let stelle = document.querySelectorAll("#stelleInputFinale .stella-finale");
            let inputVoto = document.getElementById("voto");

            stelle.forEach(function(stella) {
                stella.addEventListener("click", function() {
                    let voto = parseInt(stella.getAttribute("data-voto"));
                    inputVoto.value = voto;

                    stelle.forEach(function(s) {
                        let valore = parseInt(s.getAttribute("data-voto"));

                        if (valore <= voto) {
                            s.style.color = "#f5c542";
                        } else {
                            s.style.color = "rgba(255,255,255,0.25)";
                        }
                    });
                });

                stella.addEventListener("mouseover", function() {
                    let voto = parseInt(stella.getAttribute("data-voto"));

                    stelle.forEach(function(s) {
                        let valore = parseInt(s.getAttribute("data-voto"));

                        if (valore <= voto) {
                            s.style.color = "#f5c542";
                        }
                    });
                });

                stella.addEventListener("mouseout", function() {
                    let votoScelto = parseInt(inputVoto.value);

                    stelle.forEach(function(s) {
                        let valore = parseInt(s.getAttribute("data-voto"));

                        if (votoScelto >= 1 && valore <= votoScelto) {
                            s.style.color = "#f5c542";
                        } else {
                            s.style.color = "rgba(255,255,255,0.25)";
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>