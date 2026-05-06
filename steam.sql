-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 06, 2026 alle 09:34
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `steam`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `giochi`
--

CREATE TABLE `giochi` (
  `id` int(11) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `immagine` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `giochi`
--

INSERT INTO `giochi` (`id`, `titolo`, `descrizione`, `prezzo`, `immagine`) VALUES
(4, 'Elden Ring', 'Esplora l\'Interregno e diventa il Lord Ancestrale.', 59.99, 'assets/game/elden_ring.jpg'),
(5, 'Cyberpunk 2077', 'Vivi come un mercenario fuorilegge a Night City.', 49.99, 'assets/game/cyberpunk_2077.jpg'),
(6, 'The Witcher 3', 'Caccia mostri in un mondo devastato dalla guerra.', 29.99, 'assets/game/the_witcher_3.jpg'),
(7, 'God of War', 'Kratos e Atreus in una lotta contro gli dei norreni.', 59.99, 'assets/game/god_of_war.jpg'),
(8, 'Hades', 'Fuggi dagli inferi in questo frenetico rogue-like.', 24.50, 'assets/game/hades.jpg'),
(9, 'Stardew Valley', 'Coltiva la terra e costruisci relazioni nella valle.', 13.99, 'assets/game/stardew_valley.jpg'),
(10, 'Red Dead Redemption 2', 'Un\'epopea fuorilegge nel cuore dell\'America.', 59.99, 'assets/game/rdr2.jpg'),
(11, 'Horizon Zero Dawn', 'Macchine leggendarie dominano una terra post-apocalittica.', 39.99, 'assets/game/horizon.jpg'),
(12, 'Assetto Corsa', 'Il simulatore di corse definitivo per veri piloti.', 39.99, 'assets/game/assetto_corsa.jpg'),
(13, 'FIFA 26', 'Il calcio di nuova generazione sul tuo schermo.', 69.99, 'assets/game/fifa_26.jpg'),
(14, 'Minecraft', 'Crea, esplora e sopravvivi in un mondo di cubi.', 23.95, 'assets/game/minecraft.jpg'),
(15, 'Apex Legends', 'Battle Royale tattico basato su eroi unici.', 0.00, 'assets/game/apex_legends.jpg'),
(16, 'The Last of Us', 'Un viaggio brutale attraverso gli Stati Uniti infetti.', 59.99, 'assets/game/tlou.jpg'),
(17, 'Forza Horizon 5', 'Esplora i paesaggi vibranti del Messico.', 59.99, 'assets/game/forza_horizon_5.jpg'),
(18, 'Hollow Knight', 'Scendi nel regno di Nidosacro tra insetti e misteri.', 14.99, 'assets/game/hollow_knight.jpg'),
(19, 'Spider-Man 2', 'Vola tra i palazzi di New York con poteri incredibili.', 69.99, 'assets/game/spiderman_2.jpg'),
(20, 'Resident Evil Village', 'Sopravvivi all\'orrore in un villaggio remoto.', 39.99, 'assets/game/re_village.jpg'),
(21, 'Valorant', 'Sparatutto tattico dove la mira incontra le abilità.', 0.00, 'assets/game/valorant.jpg'),
(22, 'Slay the Spire', 'Costruisci il tuo mazzo e scala la guglia.', 24.99, 'assets/game/slay_the_spire.jpg'),
(23, 'Subnautica', 'Sopravvivenza sottomarina su un pianeta alieno.', 29.99, 'assets/game/subnautica.jpg'),
(24, 'Final Fantasy VII Remake', 'Il ritorno di Cloud in un\'avventura mozzafiato.', 49.99, 'assets/game/ffvii_remake.jpg'),
(25, 'Doom Eternal', 'L\'unica cosa che temono sei tu. Stermina i demoni.', 39.99, 'assets/game/doom_eternal.jpg'),
(26, 'Sea of Thieves', 'Salpa con i tuoi amici per la vita da pirata.', 39.99, 'assets/game/sea_of_thieves.jpg'),
(27, 'Baldur\'s Gate 3', 'Il GDR definitivo basato sul mondo di D&D.', 59.99, 'assets/game/baldurs_gate_3.jpg'),
(28, 'Dead Cells', 'Esplora un castello mutante in stile metroidvania.', 24.99, 'assets/game/dead_cells.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `libreria`
--

CREATE TABLE `libreria` (
  `id_utente` int(11) NOT NULL,
  `id_gioco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nickname`, `email`, `password`) VALUES
(2, 'Nicola 8050', 'verardinicola21@gmail.com', '$2y$10$1nUEJjMWg4IFk0TWQ2vG1uZTE6zpT0n81SbnAzI6cGEI4EHDbUE.C'),
(3, 'Nicola 8050', 'verardinicola21@gmail.com', '$2y$10$QS0JIPhOJniXtyfYXYvyguLkfVDQonWAve0KTF3vDqrjbFH/9anmO');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `giochi`
--
ALTER TABLE `giochi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `libreria`
--
ALTER TABLE `libreria`
  ADD PRIMARY KEY (`id_utente`,`id_gioco`),
  ADD KEY `id_gioco` (`id_gioco`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `giochi`
--
ALTER TABLE `giochi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `libreria`
--
ALTER TABLE `libreria`
  ADD CONSTRAINT `libreria_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `libreria_ibfk_2` FOREIGN KEY (`id_gioco`) REFERENCES `giochi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
