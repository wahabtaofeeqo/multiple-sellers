-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 16 Mars 2020 à 11:01
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tache`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `categorie_id` int(8) NOT NULL,
  `categorie_nom` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`categorie_id`, `categorie_nom`) VALUES
(1, 'Tertiaire'),
(2, 'Médical'),
(3, 'Locaux commerciaux'),
(4, 'Parties Communes'),
(5, 'Etablissement scolaire');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `client_id` int(8) NOT NULL,
  `client_nom` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `client_adr1` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `client_adr2` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `client_adr3` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `client_cp` int(8) DEFAULT NULL,
  `client_ville` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `client_statut` enum('0','1') COLLATE latin1_general_ci NOT NULL,
  `etablissement_id` int(8) DEFAULT NULL,
  `categorie_id` int(8) NOT NULL,
  `client_tele` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `client_fax` varchar(30) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`client_id`, `client_nom`, `client_adr1`, `client_adr2`, `client_adr3`, `client_cp`, `client_ville`, `client_statut`, `etablissement_id`, `categorie_id`, `client_tele`, `client_fax`) VALUES
(8711, 'AAAAaaaaaa', '273 Rue Paradis', '', '', 13006, 'MARSEILLE', '0', 2, 1, '04 ', ''),
(9888, 'aaaaa', '7 Rue G?nes ', '', '', 13006, 'MARSEILLE', '0', 2, 1, '', ''),
(9998, 'AAAAG', '176 Avenue Du Prado', '', '', 13008, 'MARSEILLE', '0', 2, 1, '987654', ''),
(10467, 'AAB', '179 Rue Du Rouet', '', '', 13008, 'MARSEILLE', '1', 2, 1, '98765', ''),
(7486, 'ARoiuy', '9 Rue Jacques R?attu', '', '', 13009, 'MARSEILLE', '1', 2, 1, '', ''),
(10343, 'aar', '73 Rue Alphonse Daudet', '', '', 13013, 'MARSEILLE', '0', 2, 1, '07 86az', ''),
(10457, 'aa', '64 Rue Ferdinand De Lesseps', '', '', 13760, 'SAINT-CANNAT', '1', 2, 1, '876543', ''),
(10181, 'aaertr', '55 Cours Georges Cl?menceau', '', '', 33000, 'BORDEAUX', '1', 1, 1, '', ''),
(9698, 'an', 'Immeuble Perspective - 2, Rue ', 'Cs 71974', '', 33088, 'BORDEAUX CEDEX', '1', 1, 1, '06 3', ''),
(10327, 'ag', 'Mr St?phane Berger', '49, Rue De La R?publique', '', 69002, 'LYON', '0', 1, 1, '6', ''),
(6966, 'aaaer', '22 Rue Saint Augustin', '', '', 75002, 'PARIS', '0', 1, 1, '', ''),
(9898, 'ARP', '23 Boulevard Poissonni?re', '', '', 75002, 'PARIS', '0', 1, 1, '', ''),
(9528, 'arrrUYUI', '3 Rue Des Jeuneurs', '', '', 75002, 'PARIS', '1', 1, 1, '0', ''),
(9933, 'ah', '9 Rue Saint Martin', 'Batiment B', '', 75004, 'PARIS', '0', 1, 1, '', ''),
(9604, 'aeeee', '13 Avenue De La Motte Piquet', '', '', 75007, 'PARIS', '0', 1, 1, '0', ''),
(9895, 'arreA', 'Bureau De Lattach? De S?curit', '34 Cours Albert 1er', '', 75008, 'PARIS', '0', 1, 1, '', ''),
(9901, 'aaayt', '', '30 Cours Albert 1er', '', 75008, 'PARIS', '0', 1, 1, '14', ''),
(9903, 'AAAA', 'Bureau De Lattach? De Defense', '34 Cours Albert 1er', '', 75008, 'PARIS', '0', 1, 1, '09', ''),
(10529, 'aBB', '24 Rue Du Colis', '', '', 75008, 'PARIS', '0', 1, 1, '', ''),
(7967, 'aattAT', '31 Rue De La Boetie', '', '', 75008, 'PARIS', '1', 1, 1, '', ''),
(10178, 'AGGGOeee', '1 Rue De La Ville ', '', '', 75008, 'PARIS', '1', 1, 1, '01 ', ''),
(10275, 'aaaa', '3 Rue De La Fidelit', '', '', 75010, 'PARIS', '1', 1, 1, '', ''),
(9850, 'AA1', '11-13 Rue Des Cordeli?res', '', '', 75013, 'PARIS', '1', 1, 1, '145353692', ''),
(9791, 'AMJ', '17 Rue Jean Daudin', '', '', 75015, 'PARIS', '1', 1, 1, '01 53 76 00 00', ''),
(10521, 'AAAAA', '8 Rue De La Terrasse', '', '', 75017, 'PARIS', '0', 1, 1, '0', ''),
(4617, 'ADFG', '63 Bis Boulevard Bessi?re', '', '', 75017, 'PARIS', '1', 1, 1, '', ''),
(10009, 'Apyyui', '131 Rue Docteur Perrimond', '', '', 83200, 'TOULON', '0', 3, 1, '03 8', ''),
(10072, 'aaaaaT', '580 Vallon Des Hirondelles', '', '', 83200, 'TOULON', '1', 3, 1, '', ''),
(10039, 'Aaggg', '190 Bis Chemin Hugues', '', '', 83500, 'LA SEYNE SUR MER', '1', 3, 1, '', ''),
(9548, 'AAAa2', 'Parc Activit? De Signes', 'Avenue De Berlin', '', 83870, 'SIGNES', '1', 3, 1, '', ''),
(10227, 'AP', '4 Avenue Carnot', 'Cs 20420', '', 85100, 'LES SABLES D OLONNE', '0', 2, 1, '0', ''),
(10372, 'arrr', '110 Avenue Victor Hugo', '', '', 92100, 'BOULOGNE-BILLANCOURT', '0', 1, 1, '', ''),
(8275, 'aarzz', '19 Rue Hispano Suiza', '', '', 92170, 'BOIS COLOMBES', '1', 1, 1, '06', ''),
(10111, 'AAAC', '13/21, Quai Des Gr?sillons', '', '', 92230, 'GENNEVILLIERS', '1', 1, 1, '9876543', ''),
(8457, 'A', '106 Avenue Albert 1er', '', '', 92500, 'RUEIL MALMAISON', '1', 1, 1, '76037', ''),
(10308, 'ar', 'Agent G?n?ral Allianz', '9 Rue Du Lieutenant Ohresser', '', 94130, 'NOGENT SUR MARNE', '0', 1, 1, '', ''),
(10350, 'ADFF', '6 Rue Christophe Colomb', '', '', 94370, 'SUCY-EN-BRIE', '1', 1, 1, '54', '');

-- --------------------------------------------------------

--
-- Structure de la table `etablissement`
--

CREATE TABLE `etablissement` (
  `etablissement_id` int(8) NOT NULL,
  `etablissement_nom` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `etablissement_adr1` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `etablissement_adr2` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `etablissement_cp` int(8) NOT NULL,
  `etablissement_ville` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `etablissement_num_urssaf` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `etablissement_designation_urssaf` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `etablissement_zone_mobilite` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `etablissement`
--

INSERT INTO `etablissement` (`etablissement_id`, `etablissement_nom`, `etablissement_adr1`, `etablissement_adr2`, `etablissement_cp`, `etablissement_ville`, `etablissement_num_urssaf`, `etablissement_designation_urssaf`, `etablissement_zone_mobilite`) VALUES
(1, 'Puteaux', '110 Avenue du Général de Gaulle', '', 92800, 'Puteaux', '116000001503933996 (Puteaux)', '', 'Ile de France (75,77,78,91,92,93,94,95)'),
(2, 'Marseille', '41 Rue Chateaubriand', '', 13007, 'Marseille', '116000003503933996 (Marseille)', '', 'Marseille et ses environs'),
(3, 'Six Fours Les Plages', '495 Boulevard de Lery', '', 83140, 'Six Fours Les Plages', '116000003503933996 (Six Fours)', '', 'Six Fours Les Plages et ses environs');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorie_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Index pour la table `etablissement`
--
ALTER TABLE `etablissement`
  ADD PRIMARY KEY (`etablissement_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorie_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10742;
--
-- AUTO_INCREMENT pour la table `etablissement`
--
ALTER TABLE `etablissement`
  MODIFY `etablissement_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
