-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para zipdev
CREATE DATABASE IF NOT EXISTS `Vb2Rsxjesy` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Vb2Rsxjesy`;

-- Volcando estructura para tabla zipdev.contact
CREATE TABLE IF NOT EXISTS `Contact` (
  `idContacto` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `surNames` varchar(100) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla zipdev.emails
CREATE TABLE IF NOT EXISTS `Emails` (
  `idEmail` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `idContacto` int(11) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla zipdev.phones
CREATE TABLE IF NOT EXISTS `Phones` (
  `idPhoneNumber` int(11) NOT NULL AUTO_INCREMENT,
  `phoneNumber` varchar(50) DEFAULT NULL,
  `idContacto` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT '1',
  PRIMARY KEY (`idPhoneNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
