/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.0.51b-community-nt : Database - soysocom_demo
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*CREATE DATABASE /*!32312 IF NOT EXISTS`tienda` /*!40100 DEFAULT CHARACTER SET latin1 ;*/

USE `tienda`;

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id_compra` bigint(50) NOT NULL auto_increment,
  `id_producto` varchar(255) default NULL,
  `nom_producto` varchar(255) NOT NULL,
  `num_remision` varchar(255) NOT NULL,
  `cantidad` bigint(50) default NULL,
  `fecha` varchar(255) default NULL,
  `costo` varchar(255) NOT NULL,
  `venta` varchar(255) NOT NULL,
  `dir_file` varchar(500) NOT NULL,
  PRIMARY KEY  (`id_compra`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
