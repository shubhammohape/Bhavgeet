-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2021 at 02:27 PM
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
-- Table structure for table `saveplaylist`
--

CREATE TABLE `saveplaylist` (
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
-- Dumping data for table `saveplaylist`
--

INSERT INTO `saveplaylist` (`id`, `playlistname`, `Artistname`, `Trackname`, `duration`, `src`, `img`, `reldate`, `playlisturl`, `Artist2`) VALUES
(1, 'Best Hindi songs 2020', 'Amaal Mallik', '\"Hua Hain Aaj Pehli Baar (From \"Sanam Re\")\"', 309272, 'https://open.spotify.com/track/4TAdD9qxGEZR8hQQL3DXH8', 'https://i.scdn.co/image/ab67616d0000b273c984ac61b5a07326764875e0', '2016-12-30', 'https://open.spotify.com/playlist/71NI5fW6GZdHiaFu3HPKHO', 'Armaan Malik'),
(2, 'Best Hindi songs 2020', 'Sonu Nigam', '\"Tainu Leke (From \"Salaam-E-Ishq\")\"', 273577, 'https://open.spotify.com/track/3CA3O0hv3OT3NUSu7e9sH2', 'https://i.scdn.co/image/ab67616d0000b2737f6c2e0a0fb5f623db7ee0f8', '2019-06-18', 'https://open.spotify.com/playlist/71NI5fW6GZdHiaFu3HPKHO', 'Mahalakshmi Iyer'),
(3, 'Best Hindi songs 2020', 'Mohit Chauhan', '\"Tujhe Bhula Diya\"', 279429, 'https://open.spotify.com/track/4r8JqkhpTb5tzSKKHnVJIJ', 'https://i.scdn.co/image/ab67616d0000b2731da0a37c5bad81580d49ef05', '2010-08-19', 'https://open.spotify.com/playlist/71NI5fW6GZdHiaFu3HPKHO', 'Shekhar Ravjiani'),
(4, 'Best Hindi songs 2020', 'Ali Zafar', '\"Madhubala\"', 263235, 'https://open.spotify.com/track/44OZwf1pS0nnoPJEz2pqAX', 'https://i.scdn.co/image/ab67616d0000b273022e2e2a881fe6e83770515d', '2011-08-09', 'https://open.spotify.com/playlist/71NI5fW6GZdHiaFu3HPKHO', 'Shweta Pandit');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saveplaylist`
--
ALTER TABLE `saveplaylist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saveplaylist`
--
ALTER TABLE `saveplaylist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
