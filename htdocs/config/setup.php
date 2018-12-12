<?php 
require_once("config/database.php");
$db_con = dbConnect();
$db_con->exec("
CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `camagru`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `postid` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `text` text DEFAULT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cle` varchar(100) DEFAULT NULL,
  `actif` int(1) DEFAULT '0',
  `mailcom` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `mail`, `password`, `cle`, `actif`, `mailcom`) VALUES
(2, 'testtest', 'ljef@hotmail.fr', '989bac194dc428df07bd8f455326765ad001c7b3909c86b63400641fddc9bc4a205ca18458e112e978e6c9576a6a397fa2203cf458ca0412886b57c23b386f76', '2606279875ba50bf00698e8.66088820', 1, NULL),
(5, 'testactiF1', 'salome.hazan@yahoo.fr', '5aa049ff47a6746b92ee55aea5778a87d0f044169a7f5b0c12279c776fbbafd5d6bd3528466e967d7b619bb512b2efee41c6133c6d4b3b7c77c4f26a237c1231', '15318007935bb7317152f2d1.28684397', 1, 1),
(6, 'Pierre', 'kljdqkj@hoj.fr', '6a81a9684f4c8cfb3816db6f435eb78a8742d293e551aea588e189d1bfcbe0d4fd435d87f738c7b76c6cad37df55312fbadf784147178d3366606877df2d7a54', '19006022385bb73305782de2.73310011', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

"
);
?>


<!--  Structure de la table `data

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `picture` text COLLATE utf8_unicode_ci NOT NULL,
  `likes` int(11) DEFAULT '0',
  `liker` text COLLATE utf8_unicode_ci,
  `comments` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 -->


