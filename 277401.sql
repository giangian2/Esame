-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 26, 2021 alle 02:19
-- Versione del server: 10.3.22-MariaDB-log
-- Versione PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hybrid_working`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`spesagian`@`localhost` PROCEDURE `Auth` (IN `_mail` VARCHAR(50), IN `_passw` VARCHAR(50), OUT `_ruolo` VARCHAR(15), OUT `_cf` VARCHAR(45))  BEGIN
select dipendente.ruolo,dipendente.cf into _ruolo,_cf  from dipendente where dipendente.mail=_mail and dipendente.passw=_passw;
end$$

CREATE DEFINER=`spesagian`@`localhost` PROCEDURE `GetArrivi` (IN `_giorno` VARCHAR(2), IN `_mese` VARCHAR(2), IN `_anno` VARCHAR(4))  begin
select InfoPrenotazioni.cf,InfoPrenotazioni.nome,InfoPrenotazioni.cognome,InfoPrenotazioni.oraInizio,InfoPrenotazioni.numero,InfoPrenotazioni.area,InfoPrenotazioni.oraFine FROM
InfoPrenotazioni where InfoPrenotazioni.giorno=_giorno and InfoPrenotazioni.mese=_mese and InfoPrenotazioni.anno=_anno order by (InfoPrenotazioni.oraInizio);
end$$

CREATE DEFINER=`spesagian`@`localhost` PROCEDURE `GetHours` (IN `_mese` VARCHAR(2), IN `_sede` VARCHAR(30))  BEGIN
select InfoPrenotazioni.cf,InfoPrenotazioni.nome,InfoPrenotazioni.cognome,SUM(InfoPrenotazioni.nSlot) AS totOre from InfoPrenotazioni
where InfoPrenotazioni.denominazione_sede=_sede and InfoPrenotazioni.mese=_mese group by (InfoPrenotazioni.cf);
end$$

CREATE DEFINER=`spesagian`@`localhost` PROCEDURE `PrenotaPostazione` (IN `_numero` INT, IN `_giorno` VARCHAR(2), IN `_mese` VARCHAR(2), IN `_anno` VARCHAR(4), IN `_oraInizio` TIME, IN `_oraFine` TIME, IN `cf_dipendente` VARCHAR(45), IN `cf_cliente` VARCHAR(45), IN `tipo_attivita` VARCHAR(20), IN `descrizione_attivita` VARCHAR(200), IN `_nomeCliente` VARCHAR(40), IN `_cognomeCliente` VARCHAR(40), IN `_cfCliente` VARCHAR(45), IN `_telCliente` BIGINT(20), IN `_mailCLiente` VARCHAR(45), OUT `result` VARCHAR(20), IN `_codice` VARCHAR(45), IN `_data` DATE, IN `_nSlot` INT)  BEGIN
declare disponibile int;
declare existsCliente int default 0;
set AUTOCOMMIT=1;
start transaction;
select COUNT(*) into disponibile from InfoPrenotazioni where InfoPrenotazioni.numero=_numero and InfoPrenotazioni.giorno=_giorno and InfoPrenotazioni.mese=_mese and InfoPrenotazioni.anno=_anno for UPDATE;
if disponibile=0 THEN

select COUNT(*) into existsCliente from cliente where cliente.cf=_cfCliente;
if existsCliente=0 THEN
insert into cliente values (_cfCliente,_nomeCliente ,_cognomeCliente,
                            _telCliente, _mailCliente);
end if;

insert into prenotazione values (_codice, _oraInizio, _oraFine,_nSlot , descrizione_attivita, tipo_attivita, cf_cliente , cf_dipendente,
                               _mese ,_giorno,_anno);
insert into prenotazione_postazione values (_numero, _codice, _data);
set result='inserito con successo';
end if;


if disponibile>0 THEN
set result='posto già occupato fra';
end if;
COMMIT;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `cf` varchar(45) NOT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `cognome` varchar(40) DEFAULT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `mail` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`cf`, `nome`, `cognome`, `telefono`, `mail`) VALUES
('abcd123', 'Marco', 'Verdi', 123456789, 'marco.verdi@gmail.com'),
('fefe5678', 'Gaia', 'Rossi', 987654321, 'gaia.rossi@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendente`
--

CREATE TABLE `dipendente` (
  `cf` varchar(45) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `mail` varchar(50) NOT NULL,
  `passw` varchar(50) NOT NULL,
  `ruolo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dipendente`
--

INSERT INTO `dipendente` (`cf`, `nome`, `cognome`, `telefono`, `mail`, `passw`, `ruolo`) VALUES
('dsdscf32', 'Giulio', 'Semprini', 222345213, 'giulio.work@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'project-manager'),
('tkjtoi900', 'Federico', 'Rizzo', 4454535466, 'federico.work@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'sviluppatore'),
('wserrto56', 'Gianluca', 'Bianchi', 3316515569, 'gianluca.work@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'sviluppatore'),
('wsfwef229', 'Sandra', 'Gialli', 3316554432, 'sandra.work@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'amministratore');

--
-- Trigger `dipendente`
--
DELIMITER $$
CREATE TRIGGER `DeleteDipendente` BEFORE DELETE ON `dipendente` FOR EACH ROW BEGIN
delete from dipendente_mezzo where dipendente_mezzo.cf_dipendente=OLD.cf;
delete from prenotazione where prenotazione.cf_dipendente=OLD.cf;
delete from seleziona where seleziona.cf_dipendente=OLD.cf;
End
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendente_mezzo`
--

CREATE TABLE `dipendente_mezzo` (
  `cf_dipendente` varchar(45) NOT NULL,
  `targa_mezzo` int(11) NOT NULL,
  `_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dipendente_mezzo`
--

INSERT INTO `dipendente_mezzo` (`cf_dipendente`, `targa_mezzo`, `_data`) VALUES
('dsdscf32', 12324, '2021-05-21'),
('dsdscf32', 12324, '2021-05-24'),
('dsdscf32', 12324, '2021-05-29'),
('tkjtoi900', 12324, '2021-05-21'),
('tkjtoi900', 12324, '2021-05-23'),
('tkjtoi900', 74673, '2021-05-24'),
('wserrto56', 74673, '2021-05-16'),
('wserrto56', 74673, '2021-05-19'),
('wserrto56', 74673, '2021-05-22');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `InfoPrenotazioni`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `InfoPrenotazioni` (
`cf` varchar(45)
,`nome` varchar(30)
,`cognome` varchar(30)
,`codice` varchar(45)
,`giorno` varchar(2)
,`anno` varchar(4)
,`mese` varchar(2)
,`oraInizio` time
,`oraFine` time
,`nSlot` int(11)
,`cf_cliente` varchar(45)
,`tipo_attivita` varchar(20)
,`descrizione_attivita` varchar(200)
,`numero` int(11)
,`area` varchar(30)
,`denominazione_sede` varchar(30)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `menu`
--

CREATE TABLE `menu` (
  `codice` varchar(45) NOT NULL,
  `primoPiatto` varchar(30) DEFAULT NULL,
  `secondoPiatto` varchar(30) DEFAULT NULL,
  `contorni` varchar(30) DEFAULT NULL,
  `valoriNutrizionali` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `menu`
--

INSERT INTO `menu` (`codice`, `primoPiatto`, `secondoPiatto`, `contorni`, `valoriNutrizionali`) VALUES
('MN01', 'Tagliatelle al pesto', 'Petto di Pollo', 'Insalata', '......'),
('MN120', 'Spaghetti allo scoglio', 'X', 'patate', '......');

-- --------------------------------------------------------

--
-- Struttura della tabella `mezzo`
--

CREATE TABLE `mezzo` (
  `targa` varchar(11) NOT NULL,
  `nPosti` int(11) DEFAULT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `cilindrata` int(11) DEFAULT NULL,
  `marca` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `mezzo`
--

INSERT INTO `mezzo` (`targa`, `nPosti`, `descrizione`, `cilindrata`, `marca`) VALUES
('12324', 26, NULL, NULL, NULL),
('74673', 110, NULL, NULL, NULL),
('7673', 26, NULL, NULL, NULL);

--
-- Trigger `mezzo`
--
DELIMITER $$
CREATE TRIGGER `DeleteMezzo` BEFORE DELETE ON `mezzo` FOR EACH ROW begin 
delete from dipendente_mezzo where dipendente_mezzo.targa_mezzo=OLD.targa;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `postazione`
--

CREATE TABLE `postazione` (
  `numero` int(11) NOT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `area` varchar(30) DEFAULT NULL,
  `denominazione_sede` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `postazione`
--

INSERT INTO `postazione` (`numero`, `descrizione`, `area`, `denominazione_sede`) VALUES
(1, '...', 'project-managment', 'sede-cesena1'),
(2, '...', 'sviluppo', 'sede-cesena1'),
(3, '...', 'project-managment', 'sede-cesena1'),
(4, '...', 'sviluppo', 'sede-cesena1'),
(5, '...', 'amministratori', 'sede-cesena1'),
(6, '...', 'amministratori', 'sede-cesena1'),
(7, '...', 'project-managment', 'sede-cesena1'),
(8, '...', 'sviluppo', 'sede-cesena1'),
(9, '...', 'sviluppo', 'sede-cesena1'),
(10, '...', 'amministratori', 'sede-cesena1'),
(11, '...', 'amministratori', 'sede-cesena1');

-- --------------------------------------------------------

--
-- Struttura della tabella `postomensa`
--

CREATE TABLE `postomensa` (
  `numero` int(11) NOT NULL,
  `descrizione` varchar(50) DEFAULT NULL,
  `disabili` tinyint(1) DEFAULT NULL,
  `codice_menu` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `postomensa`
--

INSERT INTO `postomensa` (`numero`, `descrizione`, `disabili`, `codice_menu`) VALUES
(1, 'posto vicino all uscita', 0, 'MN01'),
(2, 'posto all\'entrata', 0, 'MN01'),
(3, 'posto vicino all uscita', 0, 'MN120'),
(4, 'posto vicino all uscita', 0, 'MN01'),
(5, 'posto all\'entrata', 0, 'MN01'),
(6, 'posto vicino all uscita', 0, 'MN01'),
(7, 'posto vicino all uscita', 0, 'MN01'),
(8, 'posto vicino all uscita', 0, 'MN01'),
(9, 'posto centrale', 1, 'MN120'),
(10, 'posto centrale', 1, 'MN120');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `codice` varchar(45) NOT NULL,
  `oraInizio` time DEFAULT NULL,
  `oraFine` time DEFAULT NULL,
  `nSlot` int(11) DEFAULT NULL,
  `descrizione_attivita` varchar(200) DEFAULT NULL,
  `tipo_attivita` varchar(20) DEFAULT NULL,
  `cf_cliente` varchar(45) DEFAULT NULL,
  `cf_dipendente` varchar(45) DEFAULT NULL,
  `mese` varchar(2) DEFAULT NULL,
  `giorno` varchar(2) DEFAULT NULL,
  `anno` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO `prenotazione` (`codice`, `oraInizio`, `oraFine`, `nSlot`, `descrizione_attivita`, `tipo_attivita`, `cf_cliente`, `cf_dipendente`, `mese`, `giorno`, `anno`) VALUES
('PT55621', '08:30:00', '09:30:00', 2, 'assistenza dal vivo al cliente per sistemazione software banca', 'assistenza', 'fefe5678', 'dsdscf32', '05', '19', '2021'),
('PT6668', '09:00:00', '13:00:00', 8, '...', 'manutenzione', 'abcd123', 'dsdscf32', '05', '29', '2021'),
('PT870', '08:30:00', '12:30:00', 6, 'sviluppo software trisip', 'sviluppo', NULL, 'tkjtoi900', '05', '22', '2021');

--
-- Trigger `prenotazione`
--
DELIMITER $$
CREATE TRIGGER `DeletePrenotazione` BEFORE DELETE ON `prenotazione` FOR EACH ROW BEGIN
DELETE from prenotazione_postazione where prenotazione_postazione.codice_prenotazione=OLD.codice;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione_postazione`
--

CREATE TABLE `prenotazione_postazione` (
  `numero_postazione` int(11) NOT NULL,
  `codice_prenotazione` varchar(45) NOT NULL,
  `_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prenotazione_postazione`
--

INSERT INTO `prenotazione_postazione` (`numero_postazione`, `codice_prenotazione`, `_data`) VALUES
(6, 'PT55621', '2021-05-13'),
(9, 'PT6668', '2021-05-25'),
(11, 'PT870', '2021-05-29');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `PrenotazioniMezzi`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `PrenotazioniMezzi` (
`cf` varchar(45)
,`nome` varchar(30)
,`cognome` varchar(30)
,`_data` date
,`targa` varchar(11)
,`nPosti` int(11)
,`descrizione` varchar(100)
,`cilindrata` int(11)
,`marca` varchar(20)
);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `PrenotazioniRistorante`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `PrenotazioniRistorante` (
`cf` varchar(45)
,`nome` varchar(30)
,`cognome` varchar(30)
,`_data` date
,`numero` int(11)
,`descrizione` varchar(50)
,`primoPiatto` varchar(30)
,`secondoPiatto` varchar(30)
,`contorni` varchar(30)
,`valoriNutrizionali` varchar(50)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `Risorsa`
--

CREATE TABLE `Risorsa` (
  `codice` int(11) NOT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `marca` varchar(20) DEFAULT NULL,
  `num_postazione` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `sede`
--

CREATE TABLE `sede` (
  `denominazione` varchar(30) NOT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `indirizzo` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `sede`
--

INSERT INTO `sede` (`denominazione`, `descrizione`, `indirizzo`) VALUES
('sede-cesena1', 'sede di cesena dal 2010', 'Cesena(FC) via bella 34A'),
('sede-cesena2', 'sede di cesena dal 2010', 'Cesena(FC) via serti 1230');

-- --------------------------------------------------------

--
-- Struttura della tabella `seleziona`
--

CREATE TABLE `seleziona` (
  `numero_posto` int(11) NOT NULL,
  `cf_dipendente` varchar(45) NOT NULL,
  `_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `seleziona`
--

INSERT INTO `seleziona` (`numero_posto`, `cf_dipendente`, `_data`) VALUES
(1, 'tkjtoi900', '2021-05-27'),
(2, 'wserrto56', '2021-05-11'),
(6, 'wsfwef229', '2021-05-19'),
(8, 'dsdscf32', '2021-05-20'),
(8, 'wserrto56', '2021-05-29'),
(9, 'wserrto56', '2021-05-21'),
(10, 'tkjtoi900', '2021-05-21'),
(10, 'tkjtoi900', '2021-05-22');

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `vista`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `vista` (
`cf` varchar(45)
);

-- --------------------------------------------------------

--
-- Struttura per vista `InfoPrenotazioni`
--
DROP TABLE IF EXISTS `InfoPrenotazioni`;

CREATE ALGORITHM=UNDEFINED DEFINER=`spesagian`@`localhost` SQL SECURITY DEFINER VIEW `InfoPrenotazioni`  AS  select `dipendente`.`cf` AS `cf`,`dipendente`.`nome` AS `nome`,`dipendente`.`cognome` AS `cognome`,`prenotazione`.`codice` AS `codice`,`prenotazione`.`giorno` AS `giorno`,`prenotazione`.`anno` AS `anno`,`prenotazione`.`mese` AS `mese`,`prenotazione`.`oraInizio` AS `oraInizio`,`prenotazione`.`oraFine` AS `oraFine`,`prenotazione`.`nSlot` AS `nSlot`,`prenotazione`.`cf_cliente` AS `cf_cliente`,`prenotazione`.`tipo_attivita` AS `tipo_attivita`,`prenotazione`.`descrizione_attivita` AS `descrizione_attivita`,`postazione`.`numero` AS `numero`,`postazione`.`area` AS `area`,`postazione`.`denominazione_sede` AS `denominazione_sede` from (`dipendente` join (`prenotazione` join (`prenotazione_postazione` join `postazione` on(`prenotazione_postazione`.`numero_postazione` = `postazione`.`numero`)) on(`prenotazione`.`codice` = `prenotazione_postazione`.`codice_prenotazione`)) on(`dipendente`.`cf` = `prenotazione`.`cf_dipendente`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `PrenotazioniMezzi`
--
DROP TABLE IF EXISTS `PrenotazioniMezzi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`spesagian`@`localhost` SQL SECURITY DEFINER VIEW `PrenotazioniMezzi`  AS  select `dipendente`.`cf` AS `cf`,`dipendente`.`nome` AS `nome`,`dipendente`.`cognome` AS `cognome`,`dipendente_mezzo`.`_data` AS `_data`,`mezzo`.`targa` AS `targa`,`mezzo`.`nPosti` AS `nPosti`,`mezzo`.`descrizione` AS `descrizione`,`mezzo`.`cilindrata` AS `cilindrata`,`mezzo`.`marca` AS `marca` from (`dipendente` join (`dipendente_mezzo` join `mezzo` on(`dipendente_mezzo`.`targa_mezzo` = `mezzo`.`targa`)) on(`dipendente`.`cf` = `dipendente_mezzo`.`cf_dipendente`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `PrenotazioniRistorante`
--
DROP TABLE IF EXISTS `PrenotazioniRistorante`;

CREATE ALGORITHM=UNDEFINED DEFINER=`spesagian`@`localhost` SQL SECURITY DEFINER VIEW `PrenotazioniRistorante`  AS  select `dipendente`.`cf` AS `cf`,`dipendente`.`nome` AS `nome`,`dipendente`.`cognome` AS `cognome`,`seleziona`.`_data` AS `_data`,`postomensa`.`numero` AS `numero`,`postomensa`.`descrizione` AS `descrizione`,`menu`.`primoPiatto` AS `primoPiatto`,`menu`.`secondoPiatto` AS `secondoPiatto`,`menu`.`contorni` AS `contorni`,`menu`.`valoriNutrizionali` AS `valoriNutrizionali` from (`dipendente` join (`seleziona` join (`postomensa` join `menu` on(`postomensa`.`codice_menu` = `menu`.`codice`)) on(`seleziona`.`numero_posto` = `postomensa`.`numero`)) on(`dipendente`.`cf` = `seleziona`.`cf_dipendente`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `vista`
--
DROP TABLE IF EXISTS `vista`;

CREATE ALGORITHM=UNDEFINED DEFINER=`spesagian`@`localhost` SQL SECURITY DEFINER VIEW `vista`  AS  select `dipendente`.`cf` AS `cf` from `dipendente` ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cf`);

--
-- Indici per le tabelle `dipendente`
--
ALTER TABLE `dipendente`
  ADD PRIMARY KEY (`cf`);

--
-- Indici per le tabelle `dipendente_mezzo`
--
ALTER TABLE `dipendente_mezzo`
  ADD PRIMARY KEY (`cf_dipendente`,`targa_mezzo`,`_data`);

--
-- Indici per le tabelle `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`codice`);

--
-- Indici per le tabelle `mezzo`
--
ALTER TABLE `mezzo`
  ADD PRIMARY KEY (`targa`);

--
-- Indici per le tabelle `postazione`
--
ALTER TABLE `postazione`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `denominazione_sede` (`denominazione_sede`);

--
-- Indici per le tabelle `postomensa`
--
ALTER TABLE `postomensa`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `codice_menu` (`codice_menu`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `cf_cliente` (`cf_cliente`),
  ADD KEY `cf_dipendente` (`cf_dipendente`);

--
-- Indici per le tabelle `prenotazione_postazione`
--
ALTER TABLE `prenotazione_postazione`
  ADD PRIMARY KEY (`numero_postazione`,`codice_prenotazione`,`_data`);

--
-- Indici per le tabelle `Risorsa`
--
ALTER TABLE `Risorsa`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `num_postazione` (`num_postazione`);

--
-- Indici per le tabelle `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`denominazione`);

--
-- Indici per le tabelle `seleziona`
--
ALTER TABLE `seleziona`
  ADD PRIMARY KEY (`numero_posto`,`cf_dipendente`,`_data`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `postazione`
--
ALTER TABLE `postazione`
  ADD CONSTRAINT `postazione_ibfk_1` FOREIGN KEY (`denominazione_sede`) REFERENCES `sede` (`denominazione`);

--
-- Limiti per la tabella `postomensa`
--
ALTER TABLE `postomensa`
  ADD CONSTRAINT `postomensa_ibfk_1` FOREIGN KEY (`codice_menu`) REFERENCES `menu` (`codice`);

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`cf_cliente`) REFERENCES `cliente` (`cf`),
  ADD CONSTRAINT `prenotazione_ibfk_2` FOREIGN KEY (`cf_dipendente`) REFERENCES `dipendente` (`cf`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
