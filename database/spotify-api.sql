-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2021 at 07:02 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotify-api`
--

-- --------------------------------------------------------

--
-- Table structure for table `musicinfo`
--

CREATE TABLE `musicinfo` (
  `id` int(11) NOT NULL,
  `playlistname` varchar(40) NOT NULL,
  `Artistname` varchar(30) NOT NULL,
  `Trackname` varchar(60) NOT NULL,
  `duration` int(15) NOT NULL,
  `src` varchar(200) NOT NULL,
  `img` varchar(120) NOT NULL,
  `reldate` varchar(20) NOT NULL,
  `playlisturl` varchar(200) NOT NULL,
  `Artist2` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `musicinfo`
--

INSERT INTO `musicinfo` (`id`, `playlistname`, `Artistname`, `Trackname`, `duration`, `src`, `img`, `reldate`, `playlisturl`, `Artist2`) VALUES
(7, 'surprised', 'Arijit Singh', '\"Tera Yaar Hoon Main\"', 264805, 'https://open.spotify.com/track/4ZTx87kAgEwlPMzoojFZWg', 'https://i.scdn.co/image/ab67616d0000b27322927ab54277255e23fc4756', '2018-02-14', 'https://open.spotify.com/playlist/6gCRQkxRhmoXAPjYUFFFLz', ''),
(8, 'surprised', 'Akano', '\"Kamado Tanjirou no Uta (From \"Demon Slayer: Kimetsu no Yaib', 328548, 'https://open.spotify.com/track/0NsMgzCzCuedQKqIWSOF34', 'https://i.scdn.co/image/ab67616d0000b2736c781781e5f1b9c55b2cfc7a', '2019-09-19', 'https://open.spotify.com/playlist/6gCRQkxRhmoXAPjYUFFFLz', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `musicinfo`
--
ALTER TABLE `musicinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `musicinfo`
--
ALTER TABLE `musicinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
