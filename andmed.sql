
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kaubamaja`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`) VALUES
(1, 'Mari Juhanson'),
(2, 'Tiit Kajakas'),
(3, 'Heli Kopter'),
(4, 'Kurvis Kukkunen');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `profession` varchar(256) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `profession`, `store_id`) VALUES
(1, 'Malle Pilvik', 'Koristaja', 2),
(2, 'Juhan Ganzaõis', 'Müüja', 2),
(3, 'Mairo Serg', 'Müüja', 3),
(4, 'Karl Kont', 'Müüja', 3),
(5, 'Sirli Kaalep', 'Müüja', 4),
(6, 'Rauno Reep', 'Koristaja', 4);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `timestamp` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `client_id`, `product_id`, `timestamp`) VALUES
(1, 1, 1, 1452542222),
(2, 1, 2, 1452540000),
(3, 2, 1, 1452544662),
(4, 3, 1, 1452544662),
(5, 3, 2, 1452544662),
(6, 1, 5, 1452544662),
(7, 3, 3, 1452544662),
(8, 3, 4, 1452544662),
(9, 3, 5, 1452544662),
(10, 3, 6, 1452544662),
(11, 3, 7, 1452544662),
(12, 3, 8, 1452544662),
(13, 4, 7, 1452544662),
(14, 4, 8, 1452544662),
(15, 4, 9, 1452544662),
(16, 4, 10, 1452544662);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE IF NOT EXISTS `owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `name`, `username`, `password`) VALUES
(1, 'test owner', 'test', 'test'),
(2, 'Jalatsid', 'jalatsid', 'jalatsid'),
(3, 'Riided', 'riided', 'riided'),
(4, 'Toidukaubad', 'toidukaubad', 'toidukaubad');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `store_id`, `name`, `price`) VALUES
(1, 1, 'Nike, tossud', 127.2),
(2, 1, 'Adibas, sussid', 45),
(3, 2, 'Kampsun, puuvillane', 29.9),
(4, 2, 'Särk, roheline', 9.9),
(5, 2, 'Trussik, lilleline', 2.7),
(6, 2, '1 sokk', 1.95),
(7, 3, 'Red bull', 1.95),
(8, 3, 'Juustukook', 4.5),
(9, 3, 'Piim', 1.2),
(10, 3, 'Sai', 0.7),
(11, 4, 'test', 3333.33),
(12, 4, 'test2', 444.44);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `name`, `owner_id`) VALUES
(1, 'jalatsid', 2),
(2, 'riided', 3),
(3, 'toidukaubad', 4),
(4, 'test', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;