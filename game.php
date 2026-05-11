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
</head>
<body class="auth-page">
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="brand">RevU</a>
            <nav class="nav-group">
                <a href="catalogue.php" class="nav-link">Catalogo</a>
                <?php if (isset($_SESSION['id_utente'])): ?>
                    <a href="library.php" class="nav-link">Libreria</a>
                <?php endif; ?>
                <a href="cart.php" class="nav-link">Carrello (<?= count($_SESSION['carrello'] ?? []) ?>)</a>
            </nav>
        </div>
    </header>

    <main class="container game-page">
        <section class="game-layout">
            <div class="game-cover-card">
                <img src="<?= htmlspecialchars($gioco['immagine']) ?>" alt="<?= htmlspecialchars($gioco['titolo']) ?>" class="game-cover-image">
            </div>

            <div class="game-info">
                <p class="eyebrow">Scheda gioco</p>
                <h1><?= htmlspecialchars($gioco['titolo']) ?></h1>

                <div class="rating-line">
                    ★
                    <span>
                        <?php if ($gioco['media_voti']): ?>
                            <?= number_format($gioco['media_voti'], 1) ?> / 5
                        <?php else: ?>
                            Nessuna valutazione
                        <?php endif; ?>
                    </span>
                </div>

                <p class="game-description">
                    <?= nl2br(htmlspecialchars($gioco['descrizione'])) ?>
                </p>

                <div class="game-feature-list">
                    <span class="feature-pill">Download digitale</span>
                    <span class="feature-pill">Accesso immediato</span>
                    <span class="feature-pill">Recensioni utenti</span>
                </div>

                <div class="purchase-card">
                    <div class="purchase-card-head">
                        <div>
                            <p class="purchase-label">Prezzo attuale</p>
                            <span class="purchase-price"><?= number_format($gioco['prezzo'], 2) ?> €</span>
                        </div>
                        <?php if ($ha_comprato): ?>
                            <span class="library-badge">Già nella tua libreria</span>
                        <?php endif; ?>
                    </div>

                    <p class="purchase-copy">Acquista subito oppure salva il titolo nel carrello per completare l'ordine insieme agli altri giochi.</p>

                    <?php if ($ha_comprato): ?>
                        <div class="purchase-actions">
                            <a href="library.php" class="btn-buy">Vai alla libreria</a>
                            <a href="#recensioni" class="btn btn-secondary">Scrivi una recensione</a>
                        </div>
                    <?php else: ?>
                        <div class="purchase-actions">
                            <a href="add_to_cart.php?id=<?= $gioco['id'] ?>" class="btn btn-secondary">Aggiungi al carrello</a>
                            <a href="checkout.php?direct_id=<?= $gioco['id'] ?>" class="btn-buy">Acquista ora</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="recensioni-box" id="recensioni">
            <div class="section-head section-head-tight">
                <div>
                    <p class="eyebrow">Community</p>
                    <h2>Recensioni</h2>
                </div>
                <p class="section-note">Un'area più ordinata, leggibile e simile a una vera scheda prodotto.</p>
            </div>

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

                        <button type="submit" class="btn-buy btn-no-border">
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

                        <p class="info-note">
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

                    <p class="info-note">
                        Devi accedere e acquistare il gioco per lasciare una recensione.
                    </p>
                </div>
            <?php endif; ?>

            <div class="lista-recensioni">
                <h3>Commenti degli utenti</h3>

                <?php if ($commenti->num_rows > 0): ?>
                    <?php while($r = $commenti->fetch_assoc()): ?>
                        <div class="commento-card">
                            <div class="commento-head">
                                <strong><?= htmlspecialchars($r['nickname']) ?></strong>
                                <span class="rating-line rating-line-small">
                                    <?php for ($i = 1; $i <= $r['voto']; $i++): ?>
                                        ★
                                    <?php endfor; ?>
                                </span>
                            </div>

                            <?php if (!empty($r['commento'])): ?>
                                <p><?= nl2br(htmlspecialchars($r['commento'])) ?></p>
                            <?php else: ?>
                                <p class="commento-empty">Nessun commento scritto.</p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="empty-copy">Non ci sono ancora recensioni per questo gioco.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let stelle = document.querySelectorAll("#stelleInputFinale .stella-finale");
            let inputVoto = document.getElementById("voto");

            function aggiornaStelle(votoAttivo, classeAttiva) {
                stelle.forEach(function(stella) {
                    let valore = parseInt(stella.getAttribute("data-voto"));
                    stella.classList.remove("is-active", "is-preview");

                    if (votoAttivo >= 1 && valore <= votoAttivo) {
                        stella.classList.add(classeAttiva);
                    }
                });
            }

            stelle.forEach(function(stella) {
                stella.addEventListener("click", function() {
                    let voto = parseInt(stella.getAttribute("data-voto"));
                    inputVoto.value = voto;
                    aggiornaStelle(voto, "is-active");
                });

                stella.addEventListener("mouseover", function() {
                    let voto = parseInt(stella.getAttribute("data-voto"));
                    aggiornaStelle(voto, "is-preview");
                });

                stella.addEventListener("mouseout", function() {
                    let votoScelto = parseInt(inputVoto.value || 0);
                    aggiornaStelle(votoScelto, "is-active");
                });
            });
        });
    </script>
</body>
</html>
