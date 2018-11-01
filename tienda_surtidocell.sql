/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.6.21 : Database - tienda_surtidocell
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`tienda_surtidocell` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tienda_surtidocell`;

/*Table structure for table `afavor` */

DROP TABLE IF EXISTS `afavor`;

CREATE TABLE `afavor` (
  `Id` bigint(50) NOT NULL AUTO_INCREMENT,
  `IdFactura` bigint(50) NOT NULL,
  `RfcCliente` varchar(20) NOT NULL,
  `PrecioProducto` double NOT NULL,
  `Sobrante` double NOT NULL,
  `CantidadRecibida` double NOT NULL,
  `FechaVenta` date NOT NULL,
  `FechaPago` date NOT NULL,
  `Estatus` tinyint(1) NOT NULL,
  `Tipo` tinyint(1) NOT NULL,
  `NumPagos` bigint(50) NOT NULL,
  `IdSucursal` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `afavor` */

insert  into `afavor`(`Id`,`IdFactura`,`RfcCliente`,`PrecioProducto`,`Sobrante`,`CantidadRecibida`,`FechaVenta`,`FechaPago`,`Estatus`,`Tipo`,`NumPagos`,`IdSucursal`) values (1,0,'GRGE920120',65,5,65,'2016-12-05','0000-00-00',0,0,0,'1');

/*Table structure for table `billetes_monedas` */

DROP TABLE IF EXISTS `billetes_monedas`;

CREATE TABLE `billetes_monedas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cajero` varchar(20) NOT NULL,
  `b20` varchar(20) NOT NULL,
  `b50` varchar(20) NOT NULL,
  `b100` varchar(20) NOT NULL,
  `b200` varchar(20) NOT NULL,
  `b500` varchar(20) NOT NULL,
  `b1000` varchar(20) NOT NULL,
  `m050` varchar(20) NOT NULL,
  `m1` varchar(20) NOT NULL,
  `m2` varchar(20) NOT NULL,
  `m5` varchar(20) NOT NULL,
  `m10` varchar(20) NOT NULL,
  `m20` varchar(20) NOT NULL,
  `HoraCierre` time NOT NULL,
  `Fecha` date NOT NULL,
  `sucursal` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `billetes_monedas` */

insert  into `billetes_monedas`(`id`,`id_cajero`,`b20`,`b50`,`b100`,`b200`,`b500`,`b1000`,`m050`,`m1`,`m2`,`m5`,`m10`,`m20`,`HoraCierre`,`Fecha`,`sucursal`) values (1,'123','5','5','5','5','5','5','5','5','5','5','5','5','11:08:00','2016-11-18',''),(2,'123','1','2','23','1','2','85','8','8','8','8','8','8','11:42:00','2016-11-18','MATRIZ'),(3,'123','1','2','3','4','5','6','7','8','9','10','11','12','11:43:00','2016-11-18','MATRIZ'),(4,'123','0','0','0','0','0','0','0','0','0','0','0','0','05:57:00','2016-11-22','MATRIZ'),(5,'123','0','0','0','0','0','0','0','0','0','00','0','0','02:06:00','2016-11-23','MATRIZ'),(6,'123','10','1','2','3','1','4','4','2','6','1','2','0','01:21:00','2016-12-05','MATRIZ');

/*Table structure for table `caja` */

DROP TABLE IF EXISTS `caja`;

CREATE TABLE `caja` (
  `id_cajero` varchar(20) NOT NULL,
  `apertura` varchar(20) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `horainicio` varchar(20) NOT NULL,
  `horafin` varchar(20) NOT NULL,
  `cantidad` varchar(100) NOT NULL,
  `IP` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `caja` */

insert  into `caja`(`id_cajero`,`apertura`,`estado`,`horainicio`,`horafin`,`cantidad`,`IP`) values ('123','0','1','1:21','1:21','2316',''),('','','0','10:18','5:40','',''),('abc','0','0','11:09','11:09','0',''),('74U8FHOUGRU8GS8G','250','0','5:53','5:58','0',''),('BEME910904HMCCRD05','0','0','11:11','11:12','65','');

/*Table structure for table `caja_tmp` */

DROP TABLE IF EXISTS `caja_tmp`;

CREATE TABLE `caja_tmp` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `venta` varchar(255) NOT NULL,
  `cant` varchar(255) NOT NULL,
  `importe` varchar(255) NOT NULL,
  `exitencia` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL,
  `imei` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `iccid` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `n_ficha` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `caja_tmp` */

/*Table structure for table `camion` */

DROP TABLE IF EXISTS `camion`;

CREATE TABLE `camion` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `year_mod` varchar(255) NOT NULL,
  `placa` varchar(255) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `camion` */

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `codigo` bigint(50) NOT NULL AUTO_INCREMENT,
  `rfc` varchar(15) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `cel` varchar(20) NOT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `pais` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `municipio` varchar(200) NOT NULL,
  `colonia` varchar(200) NOT NULL,
  `cp` bigint(50) NOT NULL,
  `next` bigint(10) DEFAULT NULL,
  `nint` bigint(10) DEFAULT NULL,
  `regimen` varchar(100) NOT NULL,
  `calle` varchar(200) NOT NULL,
  `estatus` varchar(2) DEFAULT NULL,
  `fecha` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cliente` */

insert  into `cliente`(`codigo`,`rfc`,`nom`,`correo`,`tel`,`cel`,`empresa`,`pais`,`estado`,`municipio`,`colonia`,`cp`,`next`,`nint`,`regimen`,`calle`,`estatus`,`fecha`) values (1,'GRGE920120','ELYUD FABIAN GRANDA GUTIERREZ','LIGHTUM@OUTLOOK.COM','7222469548','7222469548','AIKO SOLUCIONES','MEXICO','MEXICO','LERMA','STA CATARINA',52050,1,5,'NA','JUAREZ','s','1992-01-20'),(3,'GRGE161205','ELYUD FABIAN','LIGHTUM7@OUTLOOK.COM','7222222222','7222222222','ELYUD FABIAN GRANDA GUTIERREZ','TOLUCA','MEXICO','LERMA','SANTA CATARINA',52050,2,3,'','JUAREZ','s','2016-12-05');

/*Table structure for table `codigo_producto` */

DROP TABLE IF EXISTS `codigo_producto`;

CREATE TABLE `codigo_producto` (
  `id_codigo` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_producto` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `tipo_identificador` varchar(255) NOT NULL,
  `identificador` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(10) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  PRIMARY KEY (`id_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `codigo_producto` */

/*Table structure for table `codigo_producto_temp` */

DROP TABLE IF EXISTS `codigo_producto_temp`;

CREATE TABLE `codigo_producto_temp` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `identificador` varchar(255) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  `id_movimiento` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `codigo_producto_temp` */

/*Table structure for table `comision` */

DROP TABLE IF EXISTS `comision`;

CREATE TABLE `comision` (
  `id_comision` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `porcentaje` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  PRIMARY KEY (`id_comision`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `comision` */

insert  into `comision`(`id_comision`,`nombre`,`tipo`,`porcentaje`,`descripcion`,`codigo`) values (10,'VENTA DE REFACCIONES','REFACCION','10','VENTA DE REFACCIONES PARA LAS REPARACIONES',''),(3,'VENTA DE TELEFONIA','TELEFONO','5','VENTA DE EQUIPOS TELEFONICOS',''),(4,'VENTA DE FICHAS','FICHA','7','VENTA DE FICHAS TELEFONICAS',''),(5,'VENTA DE CHIPS','CHIP','8','VENTA DE CHIPS PARA NUEVO USO',''),(6,'VENTA DE ACCESORIOS','ACCESORIO','5','VENTA DE ACCESORIOS PARA TODO TIPO DE EQUIPO TELEFONICO',''),(8,'VENTA DE REPARACIONES','REPARACION','10','COMISIONES POR REPARACION',''),(14,'VENTA TAE TELCEL','RECARGA','5','SE ASIGNA UN PORCENTAJE POR CADA RECARGA QUE SE REALICE','TL'),(15,'VENTA TAE MOVISTAR','RECARGA','5','VENTA DE TAE MOVISTAR','A'),(16,'VENTA TAE NEXTEL','RECARGA','5','VENTA DE TAE PARA NEXTEL','NX'),(17,'VENTA TAE IUSACELL','RECARGA','3','VENTA DE TAE PARA IUSACELL','I'),(18,'VENTA TAE UNEFON','RECARGA','2','VENTA DE TAE PARA UNEFON','U'),(19,'VENTA TAE VIRGIN MOBILE','RECARGA','3','VENTA DE TAE PARA VIRGIN MOBILE','VM'),(20,'VENTA TAE TUENTI','RECARGA','3','VENTA TAE PARA TUENTI','TU'),(21,'VENTA TAE MAS RECARGA','RECARGA','3','VENTA TAE PARA MAS RECARGA','MR'),(22,'VENTA TAE ALO','RECARGA','3','VENTA TAE PARA ALO','ALO'),(23,'VENTA TAE TELCEL MAYOREO','RECARGA','5','VENTA DE TAE TELCEL MAYOREO','TLM'),(24,'VENTA TAE MULTIRECARGAS MAYOREO','RECARGA','5','VENTA DE TAE MULTIRECARGAS MAYOREO','MUL');

/*Table structure for table `compania_tl` */

DROP TABLE IF EXISTS `compania_tl`;

CREATE TABLE `compania_tl` (
  `id_compania` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_comision` bigint(50) NOT NULL,
  `com_asig` varchar(50) NOT NULL,
  `tipo` varchar(70) NOT NULL,
  PRIMARY KEY (`id_compania`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `compania_tl` */

insert  into `compania_tl`(`id_compania`,`nombre`,`codigo`,`id_comision`,`com_asig`,`tipo`) values (1,'Movistar','A',15,'1.06','RECARGA'),(2,'Nextel','NX',16,'1.06','RECARGA'),(3,'AT&T/Iusacell','I',17,'1.06','RECARGA'),(4,'Unefon','U',18,'1.06','RECARGA'),(5,'Telcel','TL',14,'1.07','RECARGA'),(6,'Virgin Mobile','VM',19,'1.06','RECARGA'),(7,'TUENTI','TU',20,'1.06','RECARGA'),(8,'MAS RECARGA','MR',21,'1.06','RECARGA'),(9,'ALO','ALO',22,'1.06','RECARGA'),(10,'TELCEL MAYOREO','TLM',23,'1.06','RECARGA'),(11,'MULTIRECARGAS','MUL',24,'1.06','RECARGA'),(18,'Internet Telcel Bajo','TLDB',14,'1.06','DATOS'),(19,'Internet Telcel Medio','TLDM',14,'1.06','DATOS'),(20,'Internet Telcel Alto','TLBA',14,'1.06','DATOS'),(21,'Blackberry Bajo','TLBB',14,'1.06','DATOS'),(22,'Blackberry Medio','TLBB',14,'1.06','DATOS'),(23,'Blackberry Alto','TLBA',14,'1.06','DATOS');

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id_compra` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_producto` varchar(255) DEFAULT NULL,
  `nom_producto` varchar(255) NOT NULL,
  `num_remision` varchar(255) NOT NULL,
  `cantidad` bigint(50) DEFAULT NULL,
  `fecha` varchar(255) DEFAULT NULL,
  `costo` varchar(255) NOT NULL,
  `venta` varchar(255) NOT NULL,
  `dir_file` varchar(500) NOT NULL,
  PRIMARY KEY (`id_compra`)
) ENGINE=MyISAM AUTO_INCREMENT=172 DEFAULT CHARSET=latin1;

/*Data for the table `compras` */

/*Table structure for table `credito` */

DROP TABLE IF EXISTS `credito`;

CREATE TABLE `credito` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_factura` bigint(50) NOT NULL,
  `rfc_cliente` varchar(20) NOT NULL,
  `total` varchar(255) NOT NULL,
  `adelanto` varchar(255) NOT NULL,
  `resto` varchar(255) NOT NULL,
  `fecha_venta` date NOT NULL,
  `fecha_pago` date NOT NULL,
  `estatus` tinyint(1) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `num_pagos` bigint(50) NOT NULL,
  `id_sucursal` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `credito` */

insert  into `credito`(`id`,`id_factura`,`rfc_cliente`,`total`,`adelanto`,`resto`,`fecha_venta`,`fecha_pago`,`estatus`,`tipo`,`num_pagos`,`id_sucursal`) values (1,1059,'GRGE920120','58.5','58.5','0','2016-12-05','2016-12-05',1,0,1,'1'),(2,1066,'GRGE920120','65','65','0','2016-12-05','2016-12-05',1,0,1,'1');

/*Table structure for table `creditos` */

DROP TABLE IF EXISTS `creditos`;

CREATE TABLE `creditos` (
  `id_creditos` int(11) NOT NULL AUTO_INCREMENT,
  `rfc_cliente` varchar(20) DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `consumidos` int(11) DEFAULT NULL,
  `fecha_asignacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_creditos`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `creditos` */

insert  into `creditos`(`id_creditos`,`rfc_cliente`,`creditos`,`estatus`,`consumidos`,`fecha_asignacion`) values (1,'TW5RFWFD',20,1,4,'2016-02-26 00:00:00');

/*Table structure for table `dat_fiscal` */

DROP TABLE IF EXISTS `dat_fiscal`;

CREATE TABLE `dat_fiscal` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `rfc` varchar(15) DEFAULT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `pais` varchar(20) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `municipio` varchar(20) DEFAULT NULL,
  `colonia` varchar(50) DEFAULT NULL,
  `calle` varchar(50) DEFAULT NULL,
  `cp` int(5) DEFAULT NULL,
  `next` varchar(20) DEFAULT NULL,
  `nint` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `num_certificado` varchar(50) DEFAULT NULL,
  `archivo_cer` varchar(50) DEFAULT NULL,
  `archivo_pem` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `user_pass` varchar(50) DEFAULT NULL,
  `regimen` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dat_fiscal` */

/*Table structure for table `denominacion` */

DROP TABLE IF EXISTS `denominacion`;

CREATE TABLE `denominacion` (
  `id_denominacion` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_compania` bigint(50) NOT NULL,
  `valor` varchar(255) NOT NULL,
  PRIMARY KEY (`id_denominacion`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;

/*Data for the table `denominacion` */

insert  into `denominacion`(`id_denominacion`,`id_compania`,`valor`) values (1,1,'10'),(2,1,'20'),(3,1,'30'),(4,1,'50'),(5,1,'60'),(6,1,'100'),(7,1,'120'),(8,1,'150'),(9,1,'200'),(10,1,'250'),(11,1,'300'),(12,1,'400'),(13,1,'500'),(14,2,'20'),(15,2,'30'),(16,2,'50'),(17,2,'100'),(18,2,'150'),(19,2,'200'),(20,2,'300'),(21,2,'500'),(22,3,'10'),(23,3,'20'),(24,3,'30'),(25,3,'50'),(26,3,'100'),(27,3,'150'),(28,3,'200'),(29,3,'300'),(30,3,'500'),(31,4,'10'),(32,4,'20'),(33,4,'30'),(34,4,'50'),(35,4,'100'),(36,4,'150'),(37,4,'200'),(38,4,'300'),(39,4,'500'),(40,5,'10'),(41,5,'20'),(42,5,'30'),(43,5,'50'),(44,5,'100'),(45,5,'150'),(46,5,'200'),(47,5,'300'),(48,5,'500'),(49,6,'20'),(50,6,'30'),(51,6,'40'),(52,6,'50'),(53,6,'100'),(54,6,'150'),(55,6,'200'),(56,3,'300'),(57,6,'500'),(58,7,'50'),(59,7,'80'),(60,7,'100'),(61,7,'150'),(62,7,'250'),(63,7,'300'),(65,8,'10'),(66,8,'20'),(67,8,'30'),(68,8,'40'),(69,8,'50'),(70,8,'60'),(71,8,'70'),(72,8,'80'),(73,8,'90'),(74,8,'100'),(75,8,'120'),(76,8,'150'),(77,8,'200'),(78,8,'250'),(79,8,'300'),(80,8,'400'),(81,8,'500'),(82,9,'10'),(83,9,'20'),(84,9,'30'),(85,9,'50'),(92,1,'65'),(90,1,'35'),(91,1,'40'),(93,1,'105'),(94,1,'125'),(95,1,'155'),(96,1,'205'),(98,2,'10'),(99,2,'70'),(101,4,'1000'),(102,3,'70'),(103,6,'300');

/*Table structure for table `detalle` */

DROP TABLE IF EXISTS `detalle`;

CREATE TABLE `detalle` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `factura` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `importe` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `ICCID` varchar(50) NOT NULL,
  `IMEI` varchar(50) NOT NULL,
  `fecha_op` datetime NOT NULL,
  `usu` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  `garantia` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

/*Data for the table `detalle` */

insert  into `detalle`(`id`,`factura`,`codigo`,`nombre`,`cantidad`,`valor`,`importe`,`tipo`,`ICCID`,`IMEI`,`fecha_op`,`usu`,`id_sucursal`,`garantia`) values (1,'1013','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CONTADO','','','2016-11-22 17:35:05','Admin','1',''),(2,'1013','0040020000028','MICA CRISTAL / LG GPRO LITE / D680','1','65','65','CONTADO','','','2016-11-22 17:35:05','Admin','1',''),(3,'1014','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CONTADO','','','2016-11-22 17:37:37','Admin','1',''),(4,'1014','0040020000125','MICA CRISTAL / LG K4','1','65','65','CONTADO','','','2016-11-22 17:37:37','Admin','1',''),(5,'1015','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CONTADO','','','2016-11-22 17:39:36','Admin','1',''),(6,'1015','842799519796','MICA CRISTAL / MOT XT1021','1','65','65','CONTADO','','','2016-11-22 17:39:37','Admin','1',''),(7,'1016','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','120','CONTADO','','','2016-11-22 17:44:34','Admin','1',''),(8,'1016','0040020000028','MICA CRISTAL / LG GPRO LITE / D680','1','65','65','CONTADO','','','2016-11-22 17:44:34','Admin','1',''),(9,'1017','0040020000125','MICA CRISTAL / LG K4','1','65','65','CONTADO','','','2016-11-22 17:48:34','Admin','1',''),(10,'1018','0040020000069','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','1','65','65','CONTADO','','','2016-11-22 17:49:15','Admin','1',''),(11,'1019','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','108','CONTADO','','','2016-11-22 17:51:20','Admin','1',''),(12,'1020','842799519796','MICA CRISTAL / MOT XT1021','1','65','58.5','CONTADO','','','2016-11-22 17:52:52','Admin','1',''),(13,'1020','0040020000028','MICA CRISTAL / LG GPRO LITE / D680','1','65','58.5','CONTADO','','','2016-11-22 17:52:52','Admin','1',''),(14,'1021','0040020000087','MICA CRISTAL / LG V10 / G4 PRO / H960P','1','65','58.5','CONTADO','','','2016-11-22 17:56:27','Admin','1',''),(15,'1021','0040020000069','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','1','65','58.5','CONTADO','','','2016-11-22 17:56:27','Admin','1',''),(16,'1022','842799519796','MICA CRISTAL / MOT XT1021','1','65','58.5','CONTADO','','','2016-11-22 17:58:22','Admin','1',''),(17,'1022','0040020000088','MICA CRISTAL / LG ZERO / H650','1','65','58.5','CONTADO','','','2016-11-22 17:58:22','Admin','1',''),(18,'1023','0040020000087','MICA CRISTAL / LG V10 / G4 PRO / H960P','1','65','58.5','CONTADO','','','2016-11-23 09:54:41','Admin','1',''),(19,'1023','0040020000125','MICA CRISTAL / LG K4','1','65','58.5','CONTADO','','','2016-11-23 09:54:41','Admin','1',''),(20,'1024','0040020000069','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','1','65','58.5','CONTADO','','','2016-11-23 10:02:50','Admin','1',''),(21,'1024','0040020000059','MICA CRISTAL / XPERIA M4 AQUA','1','65','58.5','CONTADO','','','2016-11-23 10:02:50','Admin','1',''),(22,'1025','0040020000028','MICA CRISTAL / LG GPRO LITE / D680','1','65','58.5','CONTADO','','','2016-11-23 10:06:52','Admin','1',''),(23,'1025','0040020000088','MICA CRISTAL / LG ZERO / H650','1','65','58.5','CONTADO','','','2016-11-23 10:06:52','Admin','1',''),(24,'1026','0040020000125','MICA CRISTAL / LG K4','1','65','58.5','CONTADO','','','2016-11-23 10:09:13','Admin','1',''),(25,'1026','0040020000089','MICA CRISTAL / SAMSUM A3 / A310 / 2016','1','65','58.5','CONTADO','','','2016-11-23 10:09:13','Admin','1',''),(26,'1027','842799519796','MICA CRISTAL / MOT XT1021','1','65','58.5','CONTADO','','','2016-11-23 10:14:14','Admin','1',''),(27,'1027','0040020000028','MICA CRISTAL / LG GPRO LITE / D680','1','65','58.5','CONTADO','','','2016-11-23 10:14:14','Admin','1',''),(28,'1028','0040020000087','MICA CRISTAL / LG V10 / G4 PRO / H960P','1','65','58.5','CONTADO','','','2016-11-23 10:22:21','Admin','1',''),(29,'1028','0040020000088','MICA CRISTAL / LG ZERO / H650','1','65','58.5','CONTADO','','','2016-11-23 10:22:21','Admin','1',''),(30,'1029','0040020000087','MICA CRISTAL / LG V10 / G4 PRO / H960P','1','65','58.5','CONTADO','','','2016-11-23 10:28:43','Admin','1',''),(31,'1029','842799519796','MICA CRISTAL / MOT XT1021','1','65','58.5','CONTADO','','','2016-11-23 10:28:43','Admin','1',''),(32,'1030','842799536366','MICA CRISTAL/LUMIA 535','1','65','58.5','CONTADO','','','2016-11-23 10:36:38','Admin','1',''),(33,'1030','0040020000125','MICA CRISTAL / LG K4','1','65','58.5','CONTADO','','','2016-11-23 10:36:38','Admin','1',''),(34,'1031','842799519796','MICA CRISTAL / MOT XT1021','1','65','58.5','CONTADO','','','2016-11-23 10:37:59','Admin','1',''),(35,'1031','0040020000069','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','1','65','58.5','CONTADO','','','2016-11-23 10:37:59','Admin','1',''),(37,'1033','0040020000069','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','1','65','65','CONTADO','','','2016-12-05 11:08:49','Admin','1',''),(38,'1034','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','120','CREDITO','','','2016-12-05 11:09:39','Admin','1',''),(39,'1035','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 11:14:18','Admin','1',''),(40,'1036','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','120','CREDITO','','','2016-12-05 11:21:34','Admin','1',''),(41,'1037','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 11:30:33','Admin','1',''),(42,'1038','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 11:31:48','Admin','1',''),(43,'1039','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','120','CREDITO','','','2016-12-05 11:32:31','Admin','1',''),(44,'1040','0040020000125','MICA CRISTAL / LG K4','1','65','65','CREDITO','','','2016-12-05 11:35:41','Admin','1',''),(45,'1041','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 11:36:16','Admin','1',''),(46,'1042','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','120','CREDITO','','','2016-12-05 11:37:53','Admin','1',''),(47,'1043','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 11:40:16','Admin','1',''),(48,'1044','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','120','CREDITO','','','2016-12-05 11:47:47','Admin','1',''),(49,'1045','842799519796','MICA CRISTAL / MOT XT1021','1','65','65','CONTADO','','','2016-12-05 13:03:48','Admin','1',''),(50,'1046','0040020000125','MICA CRISTAL / LG K4','1','65','58.5','CONTADO','','','2016-12-05 13:04:11','Admin','1',''),(51,'1047','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','120','CREDITO','','','2016-12-05 13:07:11','Admin','1',''),(52,'1048','0040020000059','MICA CRISTAL / XPERIA M4 AQUA','1','65','65','CREDITO','','','2016-12-05 13:07:44','Admin','1',''),(53,'1049','0040020000125','MICA CRISTAL / LG K4','1','65','65','CREDITO','','','2016-12-05 13:10:13','Admin','1',''),(54,'1050','842799536366','MICA CRISTAL/LUMIA 535','1','65','58.5','CONTADO','','','2016-12-05 13:14:01','Admin','1',''),(55,'1050','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','1','120','108','CONTADO','','','2016-12-05 13:14:01','Admin','1',''),(56,'1051','842799531811','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','2','120','216','CONTADO','','','2016-12-05 13:18:17','Admin','1',''),(57,'1051','0040020000088','MICA CRISTAL / LG ZERO / H650','2','65','117','CONTADO','','','2016-12-05 13:18:17','Admin','1',''),(58,'1052','842799536366','MICA CRISTAL/LUMIA 535','2','65','130','CONTADO','','','2016-12-05 13:21:58','Admin','1',''),(59,'1052','0040020000087','MICA CRISTAL / LG V10 / G4 PRO / H960P','2','65','130','CONTADO','','','2016-12-05 13:21:58','Admin','1',''),(60,'1054','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CONTADO','','','2016-12-05 13:22:29','Admin','1',''),(61,'1055','842799536366','MICA CRISTAL/LUMIA 535','2','65','117','CONTADO','','','2016-12-05 13:23:08','Admin','1',''),(62,'1056','842799536366','MICA CRISTAL/LUMIA 535','2','65','117','CONTADO','','','2016-12-05 13:23:51','Admin','1',''),(63,'1056','0040020000125','MICA CRISTAL / LG K4','1','65','58.5','CONTADO','','','2016-12-05 13:23:51','Admin','1',''),(64,'1057','842799536366','MICA CRISTAL/LUMIA 535','8','65','520','CREDITO','','','2016-12-05 14:16:07','Admin','1',''),(65,'1057','842799519796','MICA CRISTAL / MOT XT1021','6','65','390','CREDITO','','','2016-12-05 14:16:07','Admin','1',''),(66,'1058','842799536366','MICA CRISTAL/LUMIA 535','1','65','58.5','CONTADO','','','2016-12-05 14:21:04','Admin','1',''),(67,'1059','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 14:21:49','Admin','1',''),(68,'1060','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 14:23:45','Admin','1',''),(69,'1061','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 14:27:16','Admin','1',''),(70,'1062','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CONTADO','','','2016-12-05 14:28:19','Admin','1',''),(71,'1063','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 14:28:38','Admin','1',''),(72,'1064','0040020000087','MICA CRISTAL / LG V10 / G4 PRO / H960P','1','65','65','CREDITO','','','2016-12-05 14:30:13','Admin','1',''),(73,'1065','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 14:31:15','Admin','1',''),(74,'1066','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 14:36:51','Admin','1',''),(75,'1067','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CREDITO','','','2016-12-05 14:38:44','Admin','1',''),(76,'1068','842799536366','MICA CRISTAL/LUMIA 535','1','65','65','CONTADO','','','2016-12-08 13:17:23','Admin','1','');

/*Table structure for table `detalle_caja` */

DROP TABLE IF EXISTS `detalle_caja`;

CREATE TABLE `detalle_caja` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_cajero` varchar(20) NOT NULL,
  `apertura` varchar(20) NOT NULL,
  `ventas` varchar(100) NOT NULL,
  `cierre` varchar(255) NOT NULL,
  `horainicio` varchar(10) NOT NULL,
  `horacierre` varchar(10) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `autoriza` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `detalle_caja` */

insert  into `detalle_caja`(`id`,`id_cajero`,`apertura`,`ventas`,`cierre`,`horainicio`,`horacierre`,`fecha`,`autoriza`) values (1,'123','8110','1080.3','9190.3','11:30','5:57','2016-11-22','admin'),(2,'123','0','468','468','5:57','10:08','2016-11-23',''),(3,'123','468','702','702','10:08','10:44','2016-11-23',''),(4,'123','1170','0','1170','2:06','2:06','2016-11-23','admin'),(5,'','','','0','10:18','5:40','2016-11-23',''),(6,'123','0','0','0','2:06','2:25','2016-11-25',''),(7,'123','0','1852','1852','2:25','1:21','2016-12-05','admin');

/*Table structure for table `detallerecargassucursal` */

DROP TABLE IF EXISTS `detallerecargassucursal`;

CREATE TABLE `detallerecargassucursal` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdSucursal` int(11) NOT NULL,
  `Sucursal` varchar(90) NOT NULL,
  `Saldo` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `detallerecargassucursal` */

insert  into `detallerecargassucursal`(`Id`,`IdSucursal`,`Sucursal`,`Saldo`,`Fecha`,`Hora`) values (1,1,'MATRIZ',10000,'2016-11-08','11:28:16');

/*Table structure for table `empresa` */

DROP TABLE IF EXISTS `empresa`;

CREATE TABLE `empresa` (
  `id` int(255) NOT NULL,
  `empresa` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tel1` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tel2` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `web` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `iva` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tamano` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_pago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `empresa` */

insert  into `empresa`(`id`,`empresa`,`nit`,`direccion`,`ciudad`,`tel1`,`tel2`,`web`,`correo`,`iva`,`tamano`,`fecha_pago`) values (1,'MATRIZ','234','AV. GUSTAVO BAZ PRADA SUR NO. 304 COL. CENTRO, IXTLAHUACA, EDO. MEX. C.P.: 50740','MEXICO','(712)283-09-07','-','www.surticel.COM','surticel@mail.com','-','-','2016-12-31'),(2,'RAYON','27','Xonacatlan Colonia Centro','Mexico','123456789','','www.surticel.com','surticel@mail.com','','',NULL),(203,'CONDESA1','2','Isidro fabela','Mexico','987654321','','www.surticel.com','surticel@mail.com','','',NULL),(988,'NICOLAS','23','Alfredo del Mazo','Mexico','657438291','','www.surticel.com','surticel@mail.com','','',NULL),(543,'PREMIER','293','COLONIA CENTRO','MEXICO','765424312','','surticel.com.mx','jmorales@aiko.com.mx','','',NULL),(10,'NUEVA','5','DEMO','DEMO','12345','','12345','12345@HDF.COM','','',NULL),(1234,'OTRO','1','OTRO','OTRO','123123123213123','','SADADSAD234234234234234234234234','lightum@outlook.com','','',NULL);

/*Table structure for table `factura` */

DROP TABLE IF EXISTS `factura`;

CREATE TABLE `factura` (
  `factura` varchar(255) NOT NULL,
  `cajera` varchar(255) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `tipo_pago` varchar(20) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `factura` */

insert  into `factura`(`factura`,`cajera`,`fecha`,`estado`,`tipo_pago`,`id_sucursal`) values ('1000','Admin','2016-11-07','s','Efectivo','1'),('1001','Admin','2016-11-07','s','Efectivo','1'),('1002','Admin','2016-11-07','s','Efectivo','1'),('1003','Admin','2016-11-07','s','Efectivo','1'),('1004','Admin','2016-11-08','s','CONTADO','1'),('1005','Admin','2016-11-08','s','CONTADO','1'),('1006','Admin','2016-11-08','s','CONTADO','1'),('1000','cajero2','2016-11-08','s','Efectivo','2'),('1001','cajero2','2016-11-08','s','CONTADO','2'),('1007','Admin','2016-11-16','s','Efectivo','1'),('1008','Admin','2016-11-16','s','Efectivo','1'),('1009','Admin','2016-11-18','s','Efectivo','1'),('1010','Admin','2016-11-22','s','Efectivo','1'),('1011','cajero','2016-11-22','s','Efectivo','1'),('1012','Admin','2016-11-22','s','Efectivo','1'),('1013','Admin','2016-11-22','s','Efectivo','1'),('1014','Admin','2016-11-22','s','Efectivo','1'),('1015','Admin','2016-11-22','s','Efectivo','1'),('1016','Admin','2016-11-22','s','Efectivo','1'),('1017','Admin','2016-11-22','s','Efectivo','1'),('1018','Admin','2016-11-22','s','Efectivo','1'),('1019','Admin','2016-11-22','s','Efectivo','1'),('1020','Admin','2016-11-22','s','Efectivo','1'),('1021','Admin','2016-11-22','s','Efectivo','1'),('1022','Admin','2016-11-22','s','117','1'),('1023','Admin','2016-11-23','s','Efectivo','1'),('1024','Admin','2016-11-23','s','Efectivo','1'),('1025','Admin','2016-11-23','s','Efectivo','1'),('1026','Admin','2016-11-23','s','Efectivo','1'),('1027','Admin','2016-11-23','s','Efectivo','1'),('1028','Admin','2016-11-23','s','Efectivo','1'),('1029','Admin','2016-11-23','s','Efectivo','1'),('1030','Admin','2016-11-23','s','Efectivo','1'),('1031','Admin','2016-11-23','s','Efectivo','1'),('1032','Admin','2016-12-05','s','Efectivo','1'),('1033','Admin','2016-12-05','s','Efectivo','1'),('1034','Admin','2016-12-05','s','Efectivo','1'),('1035','Admin','2016-12-05','s','Efectivo','1'),('1036','Admin','2016-12-05','s','Efectivo','1'),('1037','Admin','2016-12-05','s','Efectivo','1'),('1038','Admin','2016-12-05','s','Efectivo','1'),('1039','Admin','2016-12-05','s','Efectivo','1'),('1040','Admin','2016-12-05','s','Efectivo','1'),('1041','Admin','2016-12-05','s','Efectivo','1'),('1042','Admin','2016-12-05','s','Efectivo','1'),('1043','Admin','2016-12-05','s','Efectivo','1'),('1044','Admin','2016-12-05','s','Efectivo','1'),('1045','Admin','2016-12-05','s','Efectivo','1'),('1046','Admin','2016-12-05','s','Efectivo','1'),('1047','Admin','2016-12-05','s','Efectivo','1'),('1048','Admin','2016-12-05','s','Efectivo','1'),('1049','Admin','2016-12-05','s','Efectivo','1'),('1050','Admin','2016-12-05','s','Efectivo','1'),('1051','Admin','2016-12-05','s','Efectivo','1'),('1052','Admin','2016-12-05','s','Efectivo','1'),('1053','Admin','2016-12-05','s','Efectivo','1'),('1054','Admin','2016-12-05','s','Efectivo','1'),('1055','Admin','2016-12-05','s','Efectivo','1'),('1056','Admin','2016-12-05','s','Efectivo','1'),('1057','Admin','2016-12-05','s','Efectivo','1'),('1058','Admin','2016-12-05','s','Efectivo','1'),('1059','Admin','2016-12-05','s','Efectivo','1'),('1060','Admin','2016-12-05','s','Efectivo','1'),('1061','Admin','2016-12-05','s','Efectivo','1'),('1062','Admin','2016-12-05','s','Efectivo','1'),('1063','Admin','2016-12-05','s','Efectivo','1'),('1064','Admin','2016-12-05','s','Efectivo','1'),('1065','Admin','2016-12-05','s','Efectivo','1'),('1066','Admin','2016-12-05','s','Efectivo','1'),('1067','Admin','2016-12-05','s','Efectivo','1'),('1068','Admin','2016-12-08','s','Efectivo','1');

/*Table structure for table `gastos` */

DROP TABLE IF EXISTS `gastos`;

CREATE TABLE `gastos` (
  `id_gasto` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_camion` bigint(50) NOT NULL,
  `concepto` varchar(500) CHARACTER SET latin1 NOT NULL,
  `numero_fact` varchar(100) CHARACTER SET latin1 NOT NULL,
  `fecha` date NOT NULL,
  `total` varchar(100) CHARACTER SET latin1 NOT NULL,
  `iva` varchar(100) CHARACTER SET latin1 NOT NULL,
  `descripcion` varchar(500) CHARACTER SET latin1 NOT NULL,
  `documento` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `id_sucursal` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_gasto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `gastos` */

/*Table structure for table `historial_creditos` */

DROP TABLE IF EXISTS `historial_creditos`;

CREATE TABLE `historial_creditos` (
  `id_historial` int(11) NOT NULL AUTO_INCREMENT,
  `folio` varchar(80) DEFAULT NULL,
  `operacion` varchar(10) DEFAULT NULL,
  `fecha_operacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_historial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `historial_creditos` */

/*Table structure for table `marca` */

DROP TABLE IF EXISTS `marca`;

CREATE TABLE `marca` (
  `id_marca` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `marca` */

insert  into `marca`(`id_marca`,`nombre`,`estado`) values (1,'LG','s'),(2,'MOTOROLA','s'),(3,'SAMSUNG','s'),(5,'SONY','s'),(6,'alcatel','s'),(7,'AZUMI','s'),(8,'zte','s'),(9,'zumm','s'),(10,'Huawei','s'),(11,'MOBO','s');

/*Table structure for table `modelo` */

DROP TABLE IF EXISTS `modelo`;

CREATE TABLE `modelo` (
  `id_modelo` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_marca` bigint(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `modelo` */

insert  into `modelo`(`id_modelo`,`id_marca`,`nombre`,`estado`) values (2,3,'SM-G930F','s'),(3,5,'xperia','s'),(4,6,'OT-1011','s'),(5,7,'A35S LITE','s');

/*Table structure for table `movimiento` */

DROP TABLE IF EXISTS `movimiento`;

CREATE TABLE `movimiento` (
  `id_movimiento` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `id_suc_salida` varchar(255) NOT NULL,
  `id_suc_entrada` varchar(255) NOT NULL,
  `usu_salida` varchar(255) NOT NULL,
  `usu_entrada` varchar(255) NOT NULL,
  `id_producto` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha2` datetime NOT NULL,
  `estado` varchar(10) NOT NULL,
  PRIMARY KEY (`id_movimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `movimiento` */

/*Table structure for table `movimientosxlote` */

DROP TABLE IF EXISTS `movimientosxlote`;

CREATE TABLE `movimientosxlote` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdLote` int(11) NOT NULL,
  `Tipo` varchar(255) NOT NULL,
  `IdSucSalida` int(11) NOT NULL,
  `IdSucEntrada` int(11) NOT NULL,
  `UsuSalida` varchar(255) NOT NULL,
  `UsuEntrada` varchar(255) NOT NULL,
  `IdProducto` varchar(255) NOT NULL,
  `IMEI` varchar(255) DEFAULT NULL,
  `ICCID` varchar(255) DEFAULT NULL,
  `IdFicha` varchar(255) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL,
  `CantRecibida` int(11) NOT NULL,
  `FechaSalida` datetime NOT NULL,
  `FechaEntrada` datetime NOT NULL,
  `Recibido` int(1) NOT NULL DEFAULT '0',
  `RazonRechazo` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `movimientosxlote` */

insert  into `movimientosxlote`(`Id`,`IdLote`,`Tipo`,`IdSucSalida`,`IdSucEntrada`,`UsuSalida`,`UsuEntrada`,`IdProducto`,`IMEI`,`ICCID`,`IdFicha`,`Cantidad`,`CantRecibida`,`FechaSalida`,`FechaEntrada`,`Recibido`,`RazonRechazo`) values (1,1,'traslado',1,2,'Admin','CAJERO1','842799519796','','','',1,1,'2016-11-07 16:31:17','2016-11-07 16:33:23',1,''),(2,1,'traslado',1,2,'Admin','CAJERO1','0040020000059','','','',2,1,'2016-11-07 16:31:17','2016-11-07 16:34:37',2,'usado'),(3,1,'traslado',1,2,'Admin','CAJERO1','0040020000089','','','',3,3,'2016-11-07 16:31:17','2016-11-07 16:36:48',2,'No coincide'),(4,3,'traslado',1,2,'Admin','CAJERO1','0040020000089','','','',5,5,'2016-11-07 16:40:34','2016-11-07 16:41:05',2,'EstÃ¡ roto'),(5,3,'traslado',1,2,'Admin','CAJERO1','842799531811','','','',3,3,'2016-11-07 16:40:34','2016-11-07 16:46:39',2,'EstÃ¡ roto'),(6,3,'traslado',1,2,'Admin','CAJERO1','0040020000125','','','',3,0,'2016-11-07 16:40:34','2016-11-07 16:51:59',2,'No coincide'),(7,6,'traslado',1,2,'Admin','CAJERO1','0040020000059','','','',4,3,'2016-11-07 16:53:41','2016-11-07 16:54:18',2,'No coincide'),(8,7,'traslado',1,2,'Admin','CAJERO1','842799531811','','','',5,3,'2016-11-07 17:03:48','2016-11-07 17:04:31',1,''),(9,7,'traslado',1,2,'Admin','CAJERO1','0040020000125','','','',4,2,'2016-11-07 17:03:48','2016-11-07 17:05:21',2,'EstÃ¡ roto'),(10,7,'traslado',1,2,'Admin','cajero2','0040020000028','','','',2,1,'2016-11-07 17:03:48','2016-11-08 12:04:11',2,'No coincide'),(11,7,'traslado',1,2,'Admin','Admin','0040020000089','','','',4,4,'2016-11-07 17:03:48','2016-11-15 10:32:46',1,''),(12,11,'traslado',1,2,'Admin','','0040020000125','','','',2,0,'2016-11-08 12:03:47','0000-00-00 00:00:00',0,''),(13,12,'traslado',1,2,'Admin','','0040020000087','','','',3,0,'2016-11-08 12:05:01','0000-00-00 00:00:00',0,'');

/*Table structure for table `pagoservicios` */

DROP TABLE IF EXISTS `pagoservicios`;

CREATE TABLE `pagoservicios` (
  `IdServicio` int(11) NOT NULL AUTO_INCREMENT,
  `NombreServicio` varchar(150) NOT NULL,
  `CodigoProducto` varchar(30) NOT NULL,
  `MontoUnico` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdServicio`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

/*Data for the table `pagoservicios` */

insert  into `pagoservicios`(`IdServicio`,`NombreServicio`,`CodigoProducto`,`MontoUnico`) values (1,'Telmex','S-Telmex',NULL),(2,'Sky','S-Sky',NULL),(3,'Maxcom','S-Maxcom',NULL),(14,'CFE','S-CFE',NULL),(15,'Infonavit','S-INFONAVIT',NULL),(16,'Agua y Drenaje de Monterrey','S-AGUAMTY',NULL),(17,'Agua de Oaxaca','S-ADOSPACO',NULL),(18,'Megacable','S-Megacable',NULL),(19,'Multimedios','S-Multimedios',NULL),(20,'Ecogas','S-ECOGAS',NULL),(21,'CableMas','S-CABLEMAS',NULL),(22,'Fomerrey','S-Fomerrey',NULL),(23,'Senda','S-Senda',NULL),(25,'Club America','ZPAM',100),(26,'Club Penguin','ZCP',60),(27,'Bajalibros','ZBJ',200),(29,'Convergia LD (Andale)','ZAND',50),(31,'Cinepoilis 5Pax','ZCINE5',239),(32,'Skype 100','ZSKYPE',100),(34,'Play Station SEN $20','ZPS20',286),(36,'Factura Fiel 100','ZFIEL',100),(37,'Nintendo 200','ZNIN',200),(41,'iTunes','ZIT',300),(45,'Xbox Live','ZXB',150),(47,'Cinepolis','ZCINE',49),(50,'Play Station SEN $50','ZPS50',715),(52,'Sony Plus 3 meses','ZSONY',258),(55,'Kaspersky 1 PC','ZKAS',299),(56,'Facebook 150','ZFB',150),(57,'Todito Cash','TC',NULL),(58,'Pase Urbano / IAVE','PURB',NULL),(59,'VIAPASS (150, 300, 500)','VP',NULL),(60,'Televia (100, 200, 300)','VB',NULL);

/*Table structure for table `paquetes_datos` */

DROP TABLE IF EXISTS `paquetes_datos`;

CREATE TABLE `paquetes_datos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `costo` varchar(70) NOT NULL,
  `vigencia` varchar(70) NOT NULL,
  `codigo` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `paquetes_datos` */

insert  into `paquetes_datos`(`id`,`nombre`,`costo`,`vigencia`,`codigo`) values (1,'Internet Bajo 10 MB','5','1 HORA','TLDB'),(2,'Internet Bajo 30 MB','19','1 D&iacute;a','TLDB'),(3,'Internet Bajo 50 MB','39','2 D&iacute;as','TLDB'),(4,'Internet Bajo 200 MB','59','7 D&iacute;as','TLDB'),(5,'Internet Bajo 600 MB','199','15 D&iacute;as','TLDB'),(6,'Internet Bajo 1GB','299','30 D&iacute;as','TLDB'),(7,'Internet Medio 30 MB','9','1 HORA','TLDM'),(8,'Internet Medio 50 MB','29','1 D&iacute;a','TLDM'),(9,'Internet Medio 100 MB','59','2 D&iacute;as','TLDM'),(10,'Internet Medio 400 MB','99','7 D&iacute;as','TLDM'),(11,'Internet Medio 1GB','299','15 D&iacute;as','TLDM'),(12,'Internet Medio 2 GB','399','30 D&iacute;as','TLDM'),(13,'Internet Alto 100 MB','12','1 Hora','TLDA'),(14,'Internet Alto 150 MB','49','1 D&iacute;a','TLDA'),(15,'Internet Alto 300 MB','79','1 D&iacute;a','TLDA'),(16,'Internet Alto 1GB','169','7 D&iacute;as','TLDA'),(17,'Internet Alto 1.5 GB','249','15 D&iacute;as','TLDA'),(18,'Internet Alto 3 GB','399','30 D&iacute;as','TLDA'),(19,'Blackberry Bajo 30 MB','19','1 D&iacute;a','TLBB'),(20,'Blackberry Bajo 50 MB','39','2 D&iacute;as','TLBB'),(21,'Blackberry bajo 200 MB','59','7 D&iacute;as','TLBB'),(22,'Blackberry bajo 600 MB','199','15 D&iacute;as','TLBB'),(23,'Blackberry bajo 1 GB','299','30 D&iacute;as','TLBB'),(24,'Blackberry Medio 50 MB','29','1 D&iacute;a','TLBB'),(25,'Blackberry Medio 100 MB','59','2 D&iacute;as','TLBB'),(26,'Blackberry Medio 400 MB','99','7 D&iacute;as','TLBB'),(27,'Blackberry Medio 1GB','59','15 D&iacute;as','TLBB'),(28,'Blackberry Medio 2GB','399','30 D&iacute;as','TLBB'),(29,'Blackberry Alto 150 MB','49','1 D&iacute;a','TLBA'),(30,'Blackberry Alto 200 MB','79','2 D&iacute;as','TLBA'),(31,'Blackberry Alto 1GB','169','7 D&iacute;as','TLBA'),(32,'Blackberry Alto 1.5GB','249','15 D&iacute;as','TLBA'),(33,'Blackberry Alto 3GB','399','30 D&iacute;as','TLBA');

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `cod` varchar(255) NOT NULL,
  `prov` varchar(255) NOT NULL,
  `cprov` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `costo` varchar(255) NOT NULL,
  `mayor` varchar(255) NOT NULL,
  `venta` varchar(255) NOT NULL,
  `especial` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `minimo` varchar(255) NOT NULL,
  `seccion` varchar(255) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `id_comision` varchar(255) NOT NULL,
  `unidad` bigint(50) NOT NULL,
  `id_sucursal` varchar(255) DEFAULT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `compania` varchar(255) DEFAULT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `tipo_ficha` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) NOT NULL,
  `faltantes` bigint(50) DEFAULT NULL,
  `sobrantes` bigint(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `producto` */

insert  into `producto`(`cod`,`prov`,`cprov`,`nom`,`costo`,`mayor`,`venta`,`especial`,`cantidad`,`minimo`,`seccion`,`fecha`,`estado`,`id_comision`,`unidad`,`id_sucursal`,`marca`,`modelo`,`compania`,`valor`,`tipo_ficha`,`color`,`categoria`,`faltantes`,`sobrantes`) values ('842799536366','AIKO','','MICA CRISTAL/LUMIA 535','20','30','65','28','49968','2','1','2016-10-20','s','6',1,'1','MOBO','','','','','','',NULL,NULL),('842799536366','AIKO','','MICA CRISTAL/LUMIA 535','20','30','65','28','0','2','1','2016-10-20','s','6',1,'2','MOBO','','','','','','',NULL,NULL),('842799536366','AIKO','','MICA CRISTAL/LUMIA 535','20','30','65','28','0','2','1','2016-10-20','s','6',1,'203','MOBO','','','','','','',NULL,NULL),('842799536366','AIKO','','MICA CRISTAL/LUMIA 535','20','30','65','28','0','2','1','2016-10-20','s','6',1,'988','MOBO','','','','','','',NULL,NULL),('842799536366','AIKO','','MICA CRISTAL/LUMIA 535','20','30','65','28','0','2','1','2016-10-20','s','6',1,'543','MOBO','','','','','','',NULL,NULL),('842799536366','AIKO','','MICA CRISTAL/LUMIA 535','20','30','65','28','0','2','1','2016-10-20','s','6',1,'10','MOBO','','','','','','',NULL,NULL),('842799536366','AIKO','','MICA CRISTAL/LUMIA 535','20','30','65','28','0','2','1','2016-10-20','s','6',1,'1234','MOBO','','','','','','',NULL,NULL),('842799531811','24','','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','50','65','120','60','49995','2','1','2016-10-20','s','6',1,'1','MOBO','','','','','','',NULL,NULL),('842799531811','24','','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','50','65','120','60','4','2','1','2016-10-20','s','6',1,'2','MOBO','','','','','','',NULL,NULL),('842799531811','24','','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','50','65','120','60','0','2','1','2016-10-20','s','6',1,'203','MOBO','','','','','','',NULL,NULL),('842799531811','24','','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','50','65','120','60','0','2','1','2016-10-20','s','6',1,'988','MOBO','','','','','','',NULL,NULL),('842799531811','24','','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','50','65','120','60','0','2','1','2016-10-20','s','6',1,'543','MOBO','','','','','','',NULL,NULL),('842799531811','24','','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','50','65','120','60','0','2','1','2016-10-20','s','6',1,'10','MOBO','','','','','','',NULL,NULL),('842799531811','24','','MICA CRISTAL/DISEÃ±O IPHONE 5 MINIONS','50','65','120','60','0','2','1','2016-10-20','s','6',1,'1234','MOBO','','','','','','',NULL,NULL),('842799519796','24','','MICA CRISTAL / MOT XT1021','17','30','65','28','4993','2','1','2016-10-20','s','6',1,'1','MOBO','','','','','','',NULL,NULL),('842799519796','24','','MICA CRISTAL / MOT XT1021','17','30','65','28','2','2','1','2016-10-20','s','6',1,'2','MOBO','','','','','','',NULL,NULL),('842799519796','24','','MICA CRISTAL / MOT XT1021','17','30','65','28','0','2','1','2016-10-20','s','6',1,'203','MOBO','','','','','','',NULL,NULL),('842799519796','24','','MICA CRISTAL / MOT XT1021','17','30','65','28','0','2','1','2016-10-20','s','6',1,'988','MOBO','','','','','','',NULL,NULL),('842799519796','24','','MICA CRISTAL / MOT XT1021','17','30','65','28','0','2','1','2016-10-20','s','6',1,'543','MOBO','','','','','','',NULL,NULL),('842799519796','24','','MICA CRISTAL / MOT XT1021','17','30','65','28','0','2','1','2016-10-20','s','6',1,'10','MOBO','','','','','','',NULL,NULL),('842799519796','24','','MICA CRISTAL / MOT XT1021','17','30','65','28','0','2','1','2016-10-20','s','6',1,'1234','MOBO','','','','','','',NULL,NULL),('0040020000125','21','','MICA CRISTAL / LG K4','13','26','65','24','4998','1','1','2016-10-20','s','6',1,'1','LG','','','','','','',NULL,NULL),('0040020000125','21','','MICA CRISTAL / LG K4','13','26','65','24','1','1','1','2016-10-20','s','6',1,'2','LG','','','','','','',NULL,NULL),('0040020000125','21','','MICA CRISTAL / LG K4','13','26','65','24','0','1','1','2016-10-20','s','6',1,'203','LG','','','','','','',NULL,NULL),('0040020000125','21','','MICA CRISTAL / LG K4','13','26','65','24','0','1','1','2016-10-20','s','6',1,'988','LG','','','','','','',NULL,NULL),('0040020000125','21','','MICA CRISTAL / LG K4','13','26','65','24','0','1','1','2016-10-20','s','6',1,'543','LG','','','','','','',NULL,NULL),('0040020000125','21','','MICA CRISTAL / LG K4','13','26','65','24','0','1','1','2016-10-20','s','6',1,'10','LG','','','','','','',NULL,NULL),('0040020000125','21','','MICA CRISTAL / LG K4','13','26','65','24','0','1','1','2016-10-20','s','6',1,'1234','LG','','','','','','',NULL,NULL),('0040020000087','21','','MICA CRISTAL / LG V10 / G4 PRO / H960P','13','26','65','24','4999','1','1','2016-10-20','s','6',1,'1','LG','','','','','','',NULL,NULL),('0040020000087','21','','MICA CRISTAL / LG V10 / G4 PRO / H960P','13','26','65','24','1','1','1','2016-10-20','s','6',1,'2','LG','','','','','','',NULL,NULL),('0040020000087','21','','MICA CRISTAL / LG V10 / G4 PRO / H960P','13','26','65','24','0','1','1','2016-10-20','s','6',1,'203','LG','','','','','','',NULL,NULL),('0040020000087','21','','MICA CRISTAL / LG V10 / G4 PRO / H960P','13','26','65','24','0','1','1','2016-10-20','s','6',1,'988','LG','','','','','','',NULL,NULL),('0040020000087','21','','MICA CRISTAL / LG V10 / G4 PRO / H960P','13','26','65','24','0','1','1','2016-10-20','s','6',1,'543','LG','','','','','','',NULL,NULL),('0040020000087','21','','MICA CRISTAL / LG V10 / G4 PRO / H960P','13','26','65','24','0','1','1','2016-10-20','s','6',1,'10','LG','','','','','','',NULL,NULL),('0040020000087','21','','MICA CRISTAL / LG V10 / G4 PRO / H960P','13','26','65','24','0','1','1','2016-10-20','s','6',1,'1234','LG','','','','','','',NULL,NULL),('0040020000028','21','','MICA CRISTAL / LG GPRO LITE / D680','13','26','65','24','5003','1','1','2016-10-20','s','6',1,'1','LG','','','','','','',NULL,NULL),('0040020000028','21','','MICA CRISTAL / LG GPRO LITE / D680','13','26','65','24','2','1','1','2016-10-20','s','6',1,'2','LG','','','','','','',NULL,NULL),('0040020000028','21','','MICA CRISTAL / LG GPRO LITE / D680','13','26','65','24','0','1','1','2016-10-20','s','6',1,'203','LG','','','','','','',NULL,NULL),('0040020000028','21','','MICA CRISTAL / LG GPRO LITE / D680','13','26','65','24','0','1','1','2016-10-20','s','6',1,'988','LG','','','','','','',NULL,NULL),('0040020000028','21','','MICA CRISTAL / LG GPRO LITE / D680','13','26','65','24','0','1','1','2016-10-20','s','6',1,'543','LG','','','','','','',NULL,NULL),('0040020000028','21','','MICA CRISTAL / LG GPRO LITE / D680','13','26','65','24','0','1','1','2016-10-20','s','6',1,'10','LG','','','','','','',NULL,NULL),('0040020000028','21','','MICA CRISTAL / LG GPRO LITE / D680','13','26','65','24','0','1','1','2016-10-20','s','6',1,'1234','LG','','','','','','',NULL,NULL),('0040020000069','21','','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','13','26','65','24','5004','1','1','2016-10-20','s','6',1,'1','LG','','','','','','',NULL,NULL),('0040020000069','21','','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','13','26','65','24','1','1','1','2016-10-20','s','6',1,'2','LG','','','','','','',NULL,NULL),('0040020000069','21','','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','13','26','65','24','0','1','1','2016-10-20','s','6',1,'203','LG','','','','','','',NULL,NULL),('0040020000069','21','','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','13','26','65','24','0','1','1','2016-10-20','s','6',1,'988','LG','','','','','','',NULL,NULL),('0040020000069','21','','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','13','26','65','24','0','1','1','2016-10-20','s','6',1,'543','LG','','','','','','',NULL,NULL),('0040020000069','21','','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','13','26','65','24','0','1','1','2016-10-20','s','6',1,'10','LG','','','','','','',NULL,NULL),('0040020000069','21','','MICA CRISTAL / LG G4 STYLUS / G4 S / H542','13','26','65','24','0','1','1','2016-10-20','s','6',1,'1234','LG','','','','','','',NULL,NULL),('0040020000059','21','','MICA CRISTAL / XPERIA M4 AQUA','13','26','65','24','5001','1','1','2016-10-20','s','6',1,'1','XPERIA','','','','','','',NULL,NULL),('0040020000059','21','','MICA CRISTAL / XPERIA M4 AQUA','13','26','65','24','7','1','1','2016-10-20','s','6',1,'2','XPERIA','','','','','','',NULL,NULL),('0040020000059','21','','MICA CRISTAL / XPERIA M4 AQUA','13','26','65','24','0','1','1','2016-10-20','s','6',1,'203','XPERIA','','','','','','',NULL,NULL),('0040020000059','21','','MICA CRISTAL / XPERIA M4 AQUA','13','26','65','24','0','1','1','2016-10-20','s','6',1,'988','XPERIA','','','','','','',NULL,NULL),('0040020000059','21','','MICA CRISTAL / XPERIA M4 AQUA','13','26','65','24','0','1','1','2016-10-20','s','6',1,'543','XPERIA','','','','','','',NULL,NULL),('0040020000059','21','','MICA CRISTAL / XPERIA M4 AQUA','13','26','65','24','0','1','1','2016-10-20','s','6',1,'10','XPERIA','','','','','','',NULL,NULL),('0040020000059','21','','MICA CRISTAL / XPERIA M4 AQUA','13','26','65','24','0','1','1','2016-10-20','s','6',1,'1234','XPERIA','','','','','','',NULL,NULL),('0040020000088','21','','MICA CRISTAL / LG ZERO / H650','13','26','65','24','5004','1','1','2016-10-20','s','6',1,'1','LG','','','','','','',NULL,NULL),('0040020000088','21','','MICA CRISTAL / LG ZERO / H650','13','26','65','24','0','1','1','2016-10-20','s','6',1,'2','LG','','','','','','',NULL,NULL),('0040020000088','21','','MICA CRISTAL / LG ZERO / H650','13','26','65','24','0','1','1','2016-10-20','s','6',1,'203','LG','','','','','','',NULL,NULL),('0040020000088','21','','MICA CRISTAL / LG ZERO / H650','13','26','65','24','0','1','1','2016-10-20','s','6',1,'988','LG','','','','','','',NULL,NULL),('0040020000088','21','','MICA CRISTAL / LG ZERO / H650','13','26','65','24','0','1','1','2016-10-20','s','6',1,'543','LG','','','','','','',NULL,NULL),('0040020000088','21','','MICA CRISTAL / LG ZERO / H650','13','26','65','24','0','1','1','2016-10-20','s','6',1,'10','LG','','','','','','',NULL,NULL),('0040020000088','21','','MICA CRISTAL / LG ZERO / H650','13','26','65','24','0','1','1','2016-10-20','s','6',1,'1234','LG','','','','','','',NULL,NULL),('0040020000089','21','','MICA CRISTAL / SAMSUM A3 / A310 / 2016','13','26','65','24','5004','1','1','2016-10-20','s','6',1,'1','SAMSUM','','','','','','',NULL,NULL),('0040020000089','21','','MICA CRISTAL / SAMSUM A3 / A310 / 2016','13','26','65','24','5','1','1','2016-10-20','s','6',1,'2','SAMSUM','','','','','','',NULL,NULL),('0040020000089','21','','MICA CRISTAL / SAMSUM A3 / A310 / 2016','13','26','65','24','0','1','1','2016-10-20','s','6',1,'203','SAMSUM','','','','','','',NULL,NULL),('0040020000089','21','','MICA CRISTAL / SAMSUM A3 / A310 / 2016','13','26','65','24','0','1','1','2016-10-20','s','6',1,'988','SAMSUM','','','','','','',NULL,NULL),('0040020000089','21','','MICA CRISTAL / SAMSUM A3 / A310 / 2016','13','26','65','24','0','1','1','2016-10-20','s','6',1,'543','SAMSUM','','','','','','',NULL,NULL),('0040020000089','21','','MICA CRISTAL / SAMSUM A3 / A310 / 2016','13','26','65','24','0','1','1','2016-10-20','s','6',1,'10','SAMSUM','','','','','','',NULL,NULL),('0040020000089','21','','MICA CRISTAL / SAMSUM A3 / A310 / 2016','13','26','65','24','0','1','1','2016-10-20','s','6',1,'1234','SAMSUM','','','','','','',NULL,NULL),('LCDPRIME','21','','G530 / PRIME','300','370','550','350','5000000','1','1','2016-10-20','s','10',1,'1','SAMSUNG','','','','','SN','LCD',NULL,NULL),('LCDPRIME','21','','G530 / PRIME','300','370','550','350','4','1','1','2016-10-20','s','10',1,'2','SAMSUNG','','','','','SN','LCD',NULL,NULL),('LCDPRIME','21','','G530 / PRIME','300','370','550','350','0','1','1','2016-10-20','s','10',1,'203','SAMSUNG','','','','','SN','LCD',NULL,NULL),('LCDPRIME','21','','G530 / PRIME','300','370','550','350','0','1','1','2016-10-20','s','10',1,'988','SAMSUNG','','','','','SN','LCD',NULL,NULL),('LCDPRIME','21','','G530 / PRIME','300','370','550','350','0','1','1','2016-10-20','s','10',1,'543','SAMSUNG','','','','','SN','LCD',NULL,NULL),('LCDPRIME','21','','G530 / PRIME','300','370','550','350','0','1','1','2016-10-20','s','10',1,'10','SAMSUNG','','','','','SN','LCD',NULL,NULL),('LCDPRIME','21','','G530 / PRIME','300','370','550','350','0','1','1','2016-10-20','s','10',1,'1234','SAMSUNG','','','','','SN','LCD',NULL,NULL);

/*Table structure for table `proveedor` */

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor` (
  `codigo` int(255) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `cel` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `obs` varchar(255) NOT NULL,
  `estado` text NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `calle` varchar(500) NOT NULL,
  `colonia` varchar(200) NOT NULL,
  `lestado` varchar(100) NOT NULL,
  `next` bigint(10) NOT NULL,
  `nint` bigint(10) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `cp` bigint(50) NOT NULL,
  `regimen` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Data for the table `proveedor` */

insert  into `proveedor`(`codigo`,`empresa`,`nom`,`dir`,`ciudad`,`tel`,`cel`,`correo`,`obs`,`estado`,`rfc`,`calle`,`colonia`,`lestado`,`next`,`nint`,`pais`,`cp`,`regimen`) values (21,'AIKO','AIKO','','TOLUCA','722536464','722536464','aiko@aiko.com','','s','B6W4GBF634G3G9C','VERTICE','VERTICE NORTE','MEXICO',203,203,'MEXICO',2030,''),(22,'TELMEX','TELMEX','','ATLACOMULCO','722830123','722830123','telmex@telmex.com','','s','telmex','CAMINO A SAN FELIPE','CENTRO','michoacan',0,0,'MEXICO',5000,'PERSONA MORAL'),(23,'AX COMUNICACIONES','OFICINA','','','5555555555','5555555555','axcomunicaciones@axcomunicaciones.com','','s','AX','COLONIA CENTRO','','',0,0,'',6000,'PERSONA MORAL'),(24,'MOBO','MOBO','','','12345','12345','MOBO@MOBO.COM','','s','MOBO','S/N','','',0,0,'',0,'PERSONA MORAL'),(25,'PROVEEDOR PILOTO','PCONTACT','','TOLUCA','63645345','6354653645234','correo@gsvd.com','','s','643EFEYWYFG','CONOCIDA','TOLUCA','MEXICO',4,4,'MEXICO',73467,'PERSONA FISICA'),(26,'NUEVA','SDF','','','2364572354','623463434','gsdvfsvf@hgf.com','','s','36GYW78DGE78DG7','HDVFHSDBF','','',0,0,'',3547354,''),(27,'NBDFVHSDBVCHVXVHDBV','SGDCGSD','','','63546354','36456354','shdgcvhdcvd@shdg.com','','s','GHSDVFHJSDGHDGF','JHSCVHSDVCHS','','',0,0,'',0,''),(28,'MEZURASHI ANIME','MEZURASHI ANIME','','LERMA','7222222222','7222222222','LIGHTUM7@OUTLOOK.COM','','s','MMEASDIIIOIOOI','JUARE','SANTA CATARINA','MEXICO',2,3,'MEXICO',52050,'AESDASD');

/*Table structure for table `recarga` */

DROP TABLE IF EXISTS `recarga`;

CREATE TABLE `recarga` (
  `id_recarga` bigint(50) NOT NULL AUTO_INCREMENT,
  `monto` varchar(50) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `compania` varchar(255) NOT NULL,
  `estatus` varchar(10) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  PRIMARY KEY (`id_recarga`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `recarga` */

insert  into `recarga`(`id_recarga`,`monto`,`numero`,`compania`,`estatus`,`id_sucursal`,`usuario`,`fecha_hora`) values (1,'20','7222469548','VM','s','1','Admin','2016-11-08 11:48:22'),(2,'10','7121789372','A','s','1','Admin','2016-11-08 12:15:11'),(3,'20','7121677153','TL','s','1','Admin','2016-11-08 12:16:45'),(4,'10','7121784819','A','s','2','cajero2','2016-11-08 12:40:12');

/*Table structure for table `recargassucursal` */

DROP TABLE IF EXISTS `recargassucursal`;

CREATE TABLE `recargassucursal` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Sucursal` varchar(90) NOT NULL,
  `IdSucursal` int(11) NOT NULL,
  `Saldo` int(11) NOT NULL,
  `SaldoOculto` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `recargassucursal` */

insert  into `recargassucursal`(`Id`,`Sucursal`,`IdSucursal`,`Saldo`,`SaldoOculto`) values (1,'MATRIZ',1,10000,NULL);

/*Table structure for table `reg_factura` */

DROP TABLE IF EXISTS `reg_factura`;

CREATE TABLE `reg_factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `folio_compra` int(11) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `emisor` varchar(20) DEFAULT NULL,
  `receptor` varchar(20) DEFAULT NULL,
  `importe` float(15,0) DEFAULT NULL,
  `folio` varchar(50) DEFAULT NULL,
  `estatus` varchar(10) DEFAULT NULL,
  `fecha_facturacion` datetime DEFAULT NULL,
  `fecha_cancelacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `reg_factura` */

/*Table structure for table `reparacion` */

DROP TABLE IF EXISTS `reparacion`;

CREATE TABLE `reparacion` (
  `id_reparacion` bigint(50) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `cod_cliente` varchar(255) NOT NULL,
  `imei` varchar(255) DEFAULT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `precio_inicial` int(11) NOT NULL,
  `abono` varchar(255) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `observacion` varchar(255) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `id_comision` varchar(10) NOT NULL,
  `estado` varchar(5) NOT NULL,
  `chip` varchar(5) NOT NULL,
  `memoria` varchar(5) NOT NULL,
  `costo` varchar(255) NOT NULL,
  `nombre_contacto` varchar(255) NOT NULL,
  `telefono_contacto` varchar(255) NOT NULL,
  `rfc_curp_contacto` varchar(255) NOT NULL,
  `tecnico` varchar(255) NOT NULL,
  `id_productos` varchar(255) NOT NULL,
  `garantia` varchar(2) NOT NULL,
  `id_garantia` bigint(50) NOT NULL,
  `tipo_precio` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `mano_obra` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `CostoRefaccion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `reparacion` */

insert  into `reparacion`(`id_reparacion`,`id_sucursal`,`usuario`,`cod_cliente`,`imei`,`marca`,`modelo`,`color`,`precio`,`precio_inicial`,`abono`,`motivo`,`observacion`,`fecha_ingreso`,`fecha_salida`,`id_comision`,`estado`,`chip`,`memoria`,`costo`,`nombre_contacto`,`telefono_contacto`,`rfc_curp_contacto`,`tecnico`,`id_productos`,`garantia`,`id_garantia`,`tipo_precio`,`mano_obra`,`CostoRefaccion`) values (1,'2','cajero2','929270','1234567890','SAMSUNG','PRIME','GRIS','550',0,'0','DISP ROTO','MALTRATADO','2016-11-08','2016-11-08','8','3','no','no','','OSCAR PLUTARCO TORRES','0000000000','PUTO000101','','','',0,'','',0),(2,'2','tecnico1','853388','IIOAOSODAOPSD','OIASIODIASIOI','ASIDIASDI','IAISDIASIDOAS','123',0,'123','NO ENCIENDE ESTA ','ASDASD','2016-11-15','2016-12-15','8','2','no','no','','ELYUD ELYUD ELYUD','8779878789','EYEE161115','','','',0,'','',0),(3,'2','tecnico1','161209','NEW','NEW','NEW','NEW','0',0,'0','NEW','','2016-11-15','2016-12-15','8','0','no','no','','NEW NEW NEW','1231231231','NENN161115','','','',0,'','',0),(4,'2','tecnico1','123558','OTRONEW','OTRONEW','OTRONEW','OTRONEW','0',0,'0','OTRONEW','OTRONEW','2016-11-15','2016-12-15','8','0','no','no','','OTRONEW OTRONEW OTRONEW','1231232132','OROO161115','','','',0,'','',0),(5,'2','tecnico1','937959','OPECIDAD','OPECIDAD','OPECIDAD','OPECIDAD','100',0,'20','OPECIDAD','OPECIDAD','2016-11-15','2016-12-15','8','0','no','no','','OPECIDAD OPECIDAD OPECIDAD','1232131231','OEOO161115','','','',0,'','',0),(6,'2','tecnico1','529829','OPE','OPE','OPE','OPE','0',0,'0','OPE','OPE','2016-11-15','2016-12-15','8','0','no','no','','OPE OPE OPE','1231231312','OEOO161115','','','',0,'','',0),(7,'2','tecnico1','730891','MTCENTER','MTCENTER','MTCENTER','MTCENTER','',100,'100','MTCENTER','MTCENTER','2016-11-15','2016-12-15','8','0','no','no','','MTCENTER MTCENTER MTCENTER','7777777777','MCMM161115','','','',0,'','',0),(8,'8','tecnico1','62279','FIXIT','FIXIT','FIXIT','FIXIT','940',777,'7','FIXIT','FIXIT','2016-11-15','2016-12-15','8','0','no','no','740','FIXIT FIXIT FIXIT','7777777777','FIFF161115','tecnico1','','',0,'','200',600),(9,'1','Admin','995397','TEST11','TEST11','TEST11','TEST11','100',100,'100','TEST11','TEST11','2016-12-05','2017-01-04','8','0','si','si','','TEST11 TEST11 TEST11','7222222222','TETT161205','','','',0,'','',0);

/*Table structure for table `reparacion_refaccion` */

DROP TABLE IF EXISTS `reparacion_refaccion`;

CREATE TABLE `reparacion_refaccion` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_reparacion` varchar(50) NOT NULL,
  `id_producto` varchar(50) NOT NULL,
  `NomProducto` varchar(65) NOT NULL,
  `TipoPrecio` int(1) NOT NULL,
  `Precio` int(11) NOT NULL,
  `CostoRefaccion` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `reparacion_refaccion` */

insert  into `reparacion_refaccion`(`id`,`id_reparacion`,`id_producto`,`NomProducto`,`TipoPrecio`,`Precio`,`CostoRefaccion`) values (2,'1','LCDPRIME','G530 / PRIME',3,550,300),(3,'8','LCDPRIME','G530 / PRIME',2,370,300),(4,'8','LCDPRIME','G530 / PRIME',2,370,300);

/*Table structure for table `saldosglobales` */

DROP TABLE IF EXISTS `saldosglobales`;

CREATE TABLE `saldosglobales` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Monto` int(11) NOT NULL,
  `FechaTiempo` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `saldosglobales` */

insert  into `saldosglobales`(`Id`,`Monto`,`FechaTiempo`) values (1,-300,'2016-11-07 16:11:31'),(2,-250,'2016-11-08 12:21:05');

/*Table structure for table `seccion` */

DROP TABLE IF EXISTS `seccion`;

CREATE TABLE `seccion` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `seccion` */

insert  into `seccion`(`id`,`nombre`,`estado`) values (1,'ALMACEN','s');

/*Table structure for table `servicio` */

DROP TABLE IF EXISTS `servicio`;

CREATE TABLE `servicio` (
  `IdServicio` bigint(50) NOT NULL AUTO_INCREMENT,
  `Monto` int(11) NOT NULL,
  `Referencia` varchar(255) NOT NULL,
  `NombreServicio` varchar(255) NOT NULL,
  `Estatus` varchar(10) NOT NULL,
  `IdSucursal` varchar(255) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `FechaHora` datetime DEFAULT NULL,
  `Extra` varchar(12) NOT NULL,
  PRIMARY KEY (`IdServicio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `servicio` */

/*Table structure for table `solicitud` */

DROP TABLE IF EXISTS `solicitud`;

CREATE TABLE `solicitud` (
  `id_solicitud` bigint(20) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `especificacion` varchar(255) DEFAULT NULL,
  `cantidad` bigint(20) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `solicitud` */

insert  into `solicitud`(`id_solicitud`,`id_sucursal`,`usuario`,`producto`,`marca`,`especificacion`,`cantidad`,`fecha`) values (1,'1','Admin','TELEFONO','AASD','A234',1,'2016-12-05');

/*Table structure for table `unidad_medida` */

DROP TABLE IF EXISTS `unidad_medida`;

CREATE TABLE `unidad_medida` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `abreviatura` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `equivalencia` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `unidad_medida` */

insert  into `unidad_medida`(`id`,`nombre`,`abreviatura`,`descripcion`,`equivalencia`) values (1,'CANTIDAD','CANT','','1'),(2,'METROS','MTS','','1'),(3,'CENTIMETROS','CM','SON CENTIMETROS ACTUALIZADO','1');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `ced` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `cel` varchar(255) NOT NULL,
  `cupo` varchar(255) NOT NULL,
  `barrio` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL,
  `con` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `sueldo` bigint(50) NOT NULL,
  `sexo` varchar(2) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  PRIMARY KEY (`ced`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

insert  into `usuarios`(`ced`,`estado`,`nom`,`dir`,`tel`,`cel`,`cupo`,`barrio`,`ciudad`,`usu`,`con`,`tipo`,`cp`,`sueldo`,`sexo`,`id_sucursal`) values ('123','s','Administrador','-','-','-','','-','Mexico','Admin','Admin','a','-',0,'h',''),('653425','n','SUPERVISOR','DIR SUPERVISOR','6252543434','5262633434','','LOCALIDAD SUPERVISOR','MEXICO','supervisor','supervisor','su','-',1000,'H','988'),('74U8FHOUGRU8GS8G','s','Tecnico suc 1','direccion tecnico','124','123','','localidad del tecnico','MEXICO','tecnico1','tecnico1','te','',1000,'h','2'),('abc','s','EDUARDO BECERRIL MARTINEZ','DIRECCION PILOTO 2','7777777777','7777777777','','LOCALIDAD PILOTO 2','MEXICO','cajero2','cajero2','ca','',1000,'H','2'),('ASDSADASDASDASDADSAD','s','ASDASD','ASDAD','1231231232','','','','ASDASDA','LUMEN','LUMEN','ca','',123,'H','2'),('BEME910904HMCCRD05','s','EDUARDO BECERRIL MARTINEZ','GUADALUPE VICTORIA','7777777777','7221725421','','PUEBLO NUEVO','MEXICO','cajero','cajero','ca','',1000,'H','1'),('CAJERO','s','CAJERO','CAJERO','1231232132','1232112321','','CAJERO','CAJERO','CAJERO1','CAJERO1','ca','',123123,'H','2'),('KLJASJKDAKDJHJKJK','s','EDUARDO BECERRIL','DIRECCION','7222222222','7222222222','','BARRIO','TOLUCA','EDUARDO','EDUARDO','su','',1000,'H','1'),('rerererererere','s','TECNICO 2','odreccion tecnico 2','4132','6354','','localidad del tecnico 2','Mexico','tecnico2','tecnico2','te','',1000,'h','1'),('TE53R46RY','s','JUAN MORALES HERNANDEZ','TEMOAYA','7227084992','7227084992','','TEMOAYA','MEXICO','juan','juan','ca','',8551,'h','543'),('TEHM791222','s','MARCOS TREVIÃ±O','RAYON 14-D','7122830907','7121405907','','COL. CENTRO','IXTLAHUACA','MARK','MARK','su','',7500,'H','1'),('Y3F4R38YEVF8Y3FV4','s','NORMA','SAN LORENZO','1111112345','1111112345','','UNKDOWN','MEXICO','norma','norma','ca','',1000,'M','2'),('YWEFR634GRY','s','EMPLEADO DEMO','CALLE DEMO','12345','12345','','LOCALIDAD DEMO','MEXICO','cajero3','cajero3','ca','',1000,'h','203');

/*Table structure for table `webservice` */

DROP TABLE IF EXISTS `webservice`;

CREATE TABLE `webservice` (
  `IdWebService` varchar(12) NOT NULL,
  PRIMARY KEY (`IdWebService`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `webservice` */

insert  into `webservice`(`IdWebService`) values ('147855669000'),('147855669001'),('147855669002'),('147855669003'),('147855669004'),('147855669005'),('147855669006'),('147855669007'),('147855669008'),('147855669009'),('147855669010'),('147855669011'),('147855669012'),('147855669013'),('147855669014'),('147855669015'),('147855669016'),('147855669017'),('147855669018'),('147855669019'),('147855669020'),('147855669021'),('147855669022'),('147855669023'),('147855669024'),('147855669025'),('147855669026'),('147855669027'),('147855669028'),('147855669029'),('147855669030'),('147855669031'),('147855669032');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
