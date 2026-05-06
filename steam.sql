-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 06, 2026 alle 16:22
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `steam` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `steam`;

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
(28, 'Dead Cells', 'Esplora un castello mutante in stile metroidvania.', 24.99, 'assets/game/dead_cells.jpg'),
(29, 'Elden Ring: Shadow of the Erdtree', 'L espansione dell anno nel regno delle ombre.', 39.99, 'assets/game/elden_ring_dlc.jpg'),
(30, 'Starfield', 'Esplora le stelle in questo RPG spaziale epico.', 69.99, 'assets/game/starfield.jpg'),
(31, 'Forza Motorsport', 'L eccellenza della simulazione automobilistica.', 69.99, 'assets/game/forza_motorsport.jpg'),
(32, 'Alan Wake 2', 'Un thriller psicologico tra realtà e incubo.', 49.99, 'assets/game/alan_wake_2.jpg'),
(33, 'Lies of P', 'Un soulslike oscuro ispirato alla storia di Pinocchio.', 59.99, 'assets/game/lies_of_p.jpg'),
(34, 'Street Fighter 6', 'Il re dei picchiaduro è tornato con una nuova veste.', 59.99, 'assets/game/sf6.jpg'),
(35, 'Diablo IV', 'La battaglia eterna tra Paradiso e Inferno continua.', 69.99, 'assets/game/diablo_4.jpg'),
(36, 'Armored Core VI', 'Combattimenti frenetici tra mech personalizzabili.', 59.99, 'assets/game/armored_core_6.jpg'),
(37, 'Final Fantasy XVI', 'Un oscuro fantasy d azione nel mondo di Valisthea.', 79.99, 'assets/game/ff16.jpg'),
(38, 'Dead Space Remake', 'Sopravvivi all orrore a bordo della Ishimura.', 59.99, 'assets/game/dead_space.jpg'),
(39, 'Hogwarts Legacy', 'Vivi la tua storia nel mondo di Harry Potter.', 59.99, 'assets/game/hogwarts_legacy.jpg'),
(40, 'Star Wars Jedi: Survivor', 'Continua il viaggio di Cal Kestis contro l Impero.', 69.99, 'assets/game/jedi_survivor.jpg'),
(41, 'Resident Evil 4 Remake', 'L incubo di Leon S. Kennedy completamente rinnovato.', 59.99, 'assets/game/re4_remake.jpg'),
(42, 'Ghost of Tsushima', 'Difendi l isola di Tsushima come l ultimo samurai.', 49.99, 'assets/game/ghost_tsushima.jpg'),
(43, 'Sekiro: Shadows Die Twice', 'Vendetta e onore nel Giappone feudale di FromSoftware.', 59.99, 'assets/game/sekiro.jpg'),
(44, 'Death Stranding', 'Riconnetti un America frammentata in un mondo isolato.', 39.99, 'assets/game/death_stranding.jpg'),
(45, 'Ratchet & Clank: Rift Apart', 'Un avventura interdimensionale mozzafiato.', 69.99, 'assets/game/ratchet_clank.jpg'),
(46, 'Returnal', 'Spezza il ciclo in questo roguelike shooter sci-fi.', 59.99, 'assets/game/returnal.jpg'),
(47, 'Demon s Souls', 'Il remake del capolavoro che ha dato il via a tutto.', 79.99, 'assets/game/demons_souls.jpg'),
(48, 'Gran Turismo 7', 'Il simulatore di guida definitivo per veri appassionati.', 69.99, 'assets/game/gt7.jpg'),
(49, 'It Takes Two', 'L avventura cooperativa definitiva per due giocatori.', 39.99, 'assets/game/it_takes_two.jpg'),
(50, 'Monster Hunter Rise', 'Caccia creature leggendarie con stile e dinamismo.', 39.99, 'assets/game/monster_hunter_rise.jpg'),
(51, 'Persona 5 Royal', 'L RPG giapponese stilisticamente perfetto.', 59.99, 'assets/game/p5r.jpg'),
(52, 'Nier: Automata', 'Una riflessione profonda sull umanità e le macchine.', 39.99, 'assets/game/nier_automata.jpg'),
(53, 'Control', 'Esplora i misteri del Federal Bureau of Control.', 29.99, 'assets/game/control.jpg'),
(54, 'Outer Wilds', 'Un mistero spaziale bloccato in un loop temporale.', 24.99, 'assets/game/outer_wilds.jpg'),
(55, 'Disco Elysium', 'Un RPG investigativo con una scrittura incredibile.', 39.99, 'assets/game/disco_elysium.jpg'),
(56, 'Dave the Diver', 'Pesca di giorno, gestisci un sushi bar di notte.', 19.99, 'assets/game/dave_diver.jpg'),
(57, 'Risk of Rain 2', 'Sopravvivi su un pianeta alieno ostile.', 24.99, 'assets/game/risk_of_rain_2.jpg'),
(58, 'Terraria', 'Scava, combatti, esplora e costruisci il tuo mondo.', 9.99, 'assets/game/terraria.jpg'),
(59, 'Valheim', 'Sopravvivenza vichinga in un mondo generato proceduralmente.', 19.99, 'assets/game/valheim.jpg'),
(60, 'Rust', 'Sopravvivenza spietata in un mondo multiplayer.', 39.99, 'assets/game/rust.jpg'),
(61, 'The Forest', 'Sopravvivi a una tribù di mutanti cannibali.', 16.99, 'assets/game/the_forest.jpg'),
(62, 'Sons of the Forest', 'Il sequel dell acclamato horror survival.', 29.99, 'assets/game/sons_forest.jpg'),
(63, 'Project Zomboid', 'Come morirai in questa apocalisse zombie realistica?', 19.99, 'assets/game/zomboid.jpg'),
(64, 'Factorio', 'Costruisci e automatizza fabbriche su scala planetaria.', 32.00, 'assets/game/factorio.jpg'),
(65, 'RimWorld', 'Un simulatore di colonia guidato da un IA narratrice.', 34.99, 'assets/game/rimworld.jpg'),
(66, 'Cities: Skylines II', 'Costruisci la metropoli dei tuoi sogni.', 49.99, 'assets/game/cities_skylines_2.jpg'),
(67, 'Civilization VI', 'Conquista il mondo attraverso i secoli.', 59.99, 'assets/game/civ6.jpg'),
(68, 'Hearts of Iron IV', 'Guida la tua nazione durante la Seconda Guerra Mondiale.', 39.99, 'assets/game/hoi4.jpg'),
(69, 'Stellaris', 'Grand strategy spaziale tra diplomazia e guerra.', 39.99, 'assets/game/stellaris.jpg'),
(70, 'Phasmophobia', 'Indaga su presenze paranormali con i tuoi amici.', 11.59, 'assets/game/phasmophobia.jpg'),
(71, 'Left 4 Dead 2', 'L apocalisse zombie cooperativa per eccellenza.', 9.75, 'assets/game/l4d2.jpg'),
(72, 'Payday 3', 'Pianifica ed esegui le rapine più audaci.', 39.99, 'assets/game/payday_3.jpg'),
(73, 'Deep Rock Galactic', 'Nani spaziali, miniere e alieni pericolosi.', 29.99, 'assets/game/drg.jpg'),
(74, 'Hunt: Showdown', 'Caccia taglie e mostri nelle paludi della Louisiana.', 39.99, 'assets/game/hunt_showdown.jpg'),
(75, 'Tarkov', 'L estrattore shooter più hardcore sul mercato.', 49.99, 'assets/game/tarkov.jpg'),
(76, 'Ready or Not', 'Simulatore tattico SWAT moderno e realistico.', 49.99, 'assets/game/ready_or_not.jpg'),
(77, 'Squad', 'Combattimento tattico militare su vasta scala.', 44.99, 'assets/game/squad.jpg'),
(78, 'Insurgency: Sandstorm', 'FPS tattico focalizzato sul realismo letale.', 29.99, 'assets/game/insurgency.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `libreria`
--

CREATE TABLE `libreria` (
  `id_utente` int(11) NOT NULL,
  `id_gioco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `libreria`
--

INSERT INTO `libreria` (`id_utente`, `id_gioco`) VALUES
(4, 32);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensioni`
--

CREATE TABLE `recensioni` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_gioco` int(11) NOT NULL,
  `voto` int(1) NOT NULL,
  `commento` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `recensioni`
--

INSERT INTO `recensioni` (`id`, `id_utente`, `id_gioco`, `voto`, `commento`) VALUES
(1, 4, 32, 5, 'spacca');

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
(3, 'Nicola 8050', 'verardinicola21@gmail.com', '$2y$10$QS0JIPhOJniXtyfYXYvyguLkfVDQonWAve0KTF3vDqrjbFH/9anmO'),
(4, 'IlDege', 'gabriele.degennaro03@gmail.com', '$2y$10$wLaApHFdGRqcPgFTpU5hfeF84u0yK3ipw/ps.RIeDVz3MWbmSXG.C');

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
-- Indici per le tabelle `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unica_recensione` (`id_utente`,`id_gioco`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `libreria`
--
ALTER TABLE `libreria`
  ADD CONSTRAINT `libreria_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `libreria_ibfk_2` FOREIGN KEY (`id_gioco`) REFERENCES `giochi` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `recensioni_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recensioni_ibfk_2` FOREIGN KEY (`id_gioco`) REFERENCES `giochi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
