-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2018 at 09:06 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id7696135_skola`
--

-- --------------------------------------------------------

--
-- Table structure for table `baza_pitanja`
--

CREATE TABLE `baza_pitanja` (
  `id` int(5) NOT NULL,
  `id_tecaj_fk` int(255) NOT NULL,
  `id_lesson_fk` int(255) NOT NULL,
  `id_tip_pitanja_fk` int(100) NOT NULL,
  `pitanje` varchar(1000) NOT NULL,
  `ponudeni_odgovori` varchar(1000) NOT NULL,
  `rjesenje` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `baza_pitanja`
--

INSERT INTO `baza_pitanja` (`id`, `id_tecaj_fk`, `id_lesson_fk`, `id_tip_pitanja_fk`, `pitanje`, `ponudeni_odgovori`, `rjesenje`) VALUES
(1, 6, 5, 1, 'Ajax vise ponudenih', 'ajax1,ajax2,ajax3,ajax4', '0,3'),
(8, 8, 5, 1, 'Ajax vise ponudenih', 'ajax1,ajax1,ajax2,ajax13', '2,3'),
(21, 3, 3, 1, 'Ajax vise ponudenih', 'ajax1,ajax1,ajax1,ajax1', '2,3'),
(30, 6, 5, 2, 'Ajax vise ponudeno', 'ajax1,ajax1,ajax1,ajax1', '3'),
(31, 10, 6, 2, 'Koji je nastavak za 3.l.jd.?', '-st,-t,-est,-/', '1'),
(32, 1, 1, 2, 'Ajax vise ponudenih', 'ajax1,ajax1,ajax1,ajax1', '0'),
(33, 6, 4, 3, 'Test tekstualno pitanje', '', 'Neki odgovor'),
(34, 6, 5, 2, 'pitanje', 'asd,asd,asd,asd', '0'),
(35, 6, 5, 3, 'pitanje2', '', 'test'),
(36, 6, 5, 3, 'pitanje3', '', 'test'),
(37, 6, 5, 3, 'pitanje25', '', 'test'),
(38, 6, 5, 3, 'pitanje5', '', 'test'),
(39, 6, 5, 3, 'pitanje6', '', 'test'),
(40, 6, 5, 3, 'pitanje21', '', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `grupa`
--

CREATE TABLE `grupa` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) COLLATE utf8_croatian_ci NOT NULL,
  `id_predavac_fk` int(11) NOT NULL,
  `id_tecaj_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `grupa`
--

INSERT INTO `grupa` (`id`, `naziv`, `id_predavac_fk`, `id_tecaj_fk`) VALUES
(1, 'Novi smjer 1-1 A1.2', 2, 1),
(2, 'Web Coding 1-2', 2, 6),
(3, 'nova', 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `ispit`
--

CREATE TABLE `ispit` (
  `id` int(5) NOT NULL,
  `naziv` varchar(200) NOT NULL,
  `id_tecaj_fk` int(5) NOT NULL,
  `id_lesson_fk` int(5) NOT NULL,
  `pitanja_string` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ispit`
--

INSERT INTO `ispit` (`id`, `naziv`, `id_tecaj_fk`, `id_lesson_fk`, `pitanja_string`, `autor`) VALUES
(2, '', 6, 5, '1,8,30,33', 'admin'),
(3, '', 3, 3, '21', 'admin'),
(4, '', 1, 1, '32', 'admin'),
(5, '', 6, 4, '33', 'admin'),
(6, '', 6, 5, '1,8,30', 'admin'),
(7, 'admin', 6, 5, '1,8,30,34,35,36,37,38,39,40', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(5) NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `id_tecaj_fk` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `lesson_name`, `id_tecaj_fk`) VALUES
(1, 'Testna lekcija', 1),
(2, 'Druga testna lekcija', 1),
(3, 'Treća lekcija', 3),
(4, 'WP1', 6),
(5, 'Ajax test', 6),
(6, 'Deklinacija riječi &quot;Hoću&quot;', 10),
(7, 'Nova Lekcija', 4),
(8, 'Nova testna lekcija', 10);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(255) NOT NULL,
  `id_osobe_fk` int(255) NOT NULL,
  `id_ispit_fk` int(255) NOT NULL,
  `result` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `id_osobe_fk`, `id_ispit_fk`, `result`) VALUES
(16, 13, 6, '33.33%'),
(17, 13, 6, '66.67%'),
(18, 13, 6, '66.67%'),
(19, 13, 6, '0%'),
(20, 13, 2, '25%'),
(21, 13, 7, '60%');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `status` varchar(30) COLLATE utf8_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `status`) VALUES
(1, 'admin'),
(2, 'profesor'),
(3, 'polaznik');

-- --------------------------------------------------------

--
-- Table structure for table `tecaj`
--

CREATE TABLE `tecaj` (
  `id` int(11) NOT NULL,
  `smjer` varchar(100) COLLATE utf8_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `tecaj`
--

INSERT INTO `tecaj` (`id`, `smjer`) VALUES
(3, 'Novi smjer 1-2'),
(1, 'Novi Smjer 2-1'),
(8, 'Novi tečaj2'),
(10, 'Njemački jezik'),
(4, 'Testni smjer'),
(6, 'Web Coding 1-2');

-- --------------------------------------------------------

--
-- Table structure for table `tip_pitanja`
--

CREATE TABLE `tip_pitanja` (
  `id` int(5) NOT NULL,
  `type` varchar(500) NOT NULL,
  `opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tip_pitanja`
--

INSERT INTO `tip_pitanja` (`id`, `type`, `opis`) VALUES
(1, 'checkbox', 'Više točnih odgovora'),
(2, 'radio', 'Jedan točan odgovor'),
(3, 'text', 'Riječ ili kratka fraza');

-- --------------------------------------------------------

--
-- Table structure for table `upisi`
--

CREATE TABLE `upisi` (
  `id` int(11) NOT NULL,
  `id_users_fk` int(11) NOT NULL,
  `id_smjer_fk` int(255) NOT NULL,
  `id_grupa_fk` int(11) NOT NULL,
  `datum_upisa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `upisi`
--

INSERT INTO `upisi` (`id`, `id_users_fk`, `id_smjer_fk`, `id_grupa_fk`, `datum_upisa`) VALUES
(6, 6, 1, 1, '2018-08-19 20:12:40'),
(7, 6, 6, 2, '2018-08-20 12:00:24'),
(8, 14, 1, 1, '2018-08-20 13:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ime` varchar(30) COLLATE utf8_croatian_ci NOT NULL,
  `prezime` varchar(30) COLLATE utf8_croatian_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `oib` varchar(11) COLLATE utf8_croatian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_croatian_ci NOT NULL,
  `telefon` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `adresa` varchar(50) COLLATE utf8_croatian_ci NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `id_status_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ime`, `prezime`, `username`, `password`, `oib`, `email`, `telefon`, `adresa`, `datum_rodjenja`, `id_status_fk`) VALUES
(1, 'Zdravko', 'Petričušić', 'zdrava53', '179ad45c6ce2cb97cf1029e212046e81', '27359479322', 'chromaa19@gmail.com', '095/815-0749', 'Glagoljaška 12', '2018-07-11', 1),
(2, 'Nenad', 'Trivun', 'nenad', 'aee03111935944a5ad1f1c887bd141e2', '32165498732', 'zdrava53@gmail.com', '095/815-0748', 'Glagoljaška 24', '2018-07-05', 2),
(6, 'test', 'user', 'testuser', '179ad45c6ce2cb97cf1029e212046e81', '12345678998', 'zdrava54@net.hr', '098348886', 'Rojčani 21', '1997-08-19', 3),
(13, 'Admin', 'Test', 'admin', '179ad45c6ce2cb97cf1029e212046e81', '32165465412', 'admin@mail.com', '12345697512', 'Admin 52', '2018-08-08', 1),
(14, 'Test', 'User 2', 'testuser2', '179ad45c6ce2cb97cf1029e212046e81', '46554612300', 'e@mail.com', '654987651354', 'opawd', '2018-08-07', 3),
(15, 'Novi', 'Korisnik', '&lt;script&gt;alert(Hello);&lt;/script&gt;', '179ad45c6ce2cb97cf1029e212046e81', '32165498798', 'xds@mail.com', '09598451651', 'neka', '2018-11-03', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baza_pitanja`
--
ALTER TABLE `baza_pitanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_tip_pitanja_fk` (`id_tip_pitanja_fk`),
  ADD KEY `id_lesson_fk` (`id_lesson_fk`),
  ADD KEY `smjer_id_fk` (`id_tecaj_fk`);

--
-- Indexes for table `grupa`
--
ALTER TABLE `grupa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_predavac_fk` (`id_predavac_fk`),
  ADD KEY `id_smjer_fk` (`id_tecaj_fk`);

--
-- Indexes for table `ispit`
--
ALTER TABLE `ispit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pitanja_string` (`pitanja_string`),
  ADD KEY `smjer_id_fk` (`id_tecaj_fk`),
  ADD KEY `id` (`id`),
  ADD KEY `lesson_id_fk` (`id_lesson_fk`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lesson_name_2` (`lesson_name`),
  ADD KEY `lesson_name` (`lesson_name`),
  ADD KEY `id` (`id`),
  ADD KEY `smjer_id_fk` (`id_tecaj_fk`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_fk` (`id_osobe_fk`),
  ADD KEY `id_ispit_fk` (`id_ispit_fk`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tecaj`
--
ALTER TABLE `tecaj`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `naziv` (`smjer`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tip_pitanja`
--
ALTER TABLE `tip_pitanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `upisi`
--
ALTER TABLE `upisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_osobe_fk` (`id_users_fk`),
  ADD KEY `id_grupa_fk` (`id_grupa_fk`),
  ADD KEY `id_smjer_fk` (`id_smjer_fk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `oib` (`oib`),
  ADD KEY `id_status_fk` (`id_status_fk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baza_pitanja`
--
ALTER TABLE `baza_pitanja`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `grupa`
--
ALTER TABLE `grupa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ispit`
--
ALTER TABLE `ispit`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tecaj`
--
ALTER TABLE `tecaj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tip_pitanja`
--
ALTER TABLE `tip_pitanja`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `upisi`
--
ALTER TABLE `upisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baza_pitanja`
--
ALTER TABLE `baza_pitanja`
  ADD CONSTRAINT `baza_pitanja_ibfk_1` FOREIGN KEY (`id_tip_pitanja_fk`) REFERENCES `tip_pitanja` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `baza_pitanja_ibfk_2` FOREIGN KEY (`id_tecaj_fk`) REFERENCES `tecaj` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `baza_pitanja_ibfk_3` FOREIGN KEY (`id_lesson_fk`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grupa`
--
ALTER TABLE `grupa`
  ADD CONSTRAINT `grupa_ibfk_1` FOREIGN KEY (`id_tecaj_fk`) REFERENCES `tecaj` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grupa_ibfk_2` FOREIGN KEY (`id_predavac_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ispit`
--
ALTER TABLE `ispit`
  ADD CONSTRAINT `ispit_ibfk_1` FOREIGN KEY (`id_tecaj_fk`) REFERENCES `tecaj` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ispit_ibfk_2` FOREIGN KEY (`id_lesson_fk`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`id_tecaj_fk`) REFERENCES `tecaj` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`id_osobe_fk`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`id_ispit_fk`) REFERENCES `ispit` (`id`);

--
-- Constraints for table `upisi`
--
ALTER TABLE `upisi`
  ADD CONSTRAINT `upisi_ibfk_1` FOREIGN KEY (`id_grupa_fk`) REFERENCES `grupa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `upisi_ibfk_2` FOREIGN KEY (`id_users_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `upisi_ibfk_3` FOREIGN KEY (`id_smjer_fk`) REFERENCES `tecaj` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_status_fk`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
