/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.6.21 : Database - tienda_surtiditocell
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`tienda_surtiditocell` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tienda_surtiditocell`;

/*Table structure for table `caja` */

DROP TABLE IF EXISTS `caja`;

CREATE TABLE `caja` (
  `id_cajero` varchar(20) NOT NULL,
  `apertura` varchar(20) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `horainicio` varchar(20) NOT NULL,
  `horafin` varchar(20) NOT NULL,
  `cantidad` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `caja` */

insert  into `caja`(`id_cajero`,`apertura`,`estado`,`horainicio`,`horafin`,`cantidad`) values ('123','0','1','2:22','2:19','0'),('BEME910904HMCCRD05','','0','','2:22','0'),('74U8FHOUGRU8GS8G','','0','','1:57','0');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `caja_tmp` */

insert  into `caja_tmp`(`id`,`cod`,`nom`,`venta`,`cant`,`importe`,`exitencia`,`usu`,`imei`,`iccid`,`n_ficha`) values (6,'TOUCHG530BLC6','TOUCH/PRIME/G530/G531','450','1','450','2','Admin','','','');

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `cliente` */

insert  into `cliente`(`codigo`,`rfc`,`nom`,`correo`,`tel`,`cel`,`empresa`,`pais`,`estado`,`municipio`,`colonia`,`cp`,`next`,`nint`,`regimen`,`calle`,`estatus`,`fecha`) values (16,'BEVA850328','ANTONIO','','','','ANTONIO BENITEZ VENTURA','','','','',0,0,0,'','','s','1985-03-28'),(13,'BEME910904','EDUARDO','','','','EDUARDO BECERRIL MARTINEZ','MEXICO','','','',0,0,0,'','','s','1991-09-04'),(15,'SOAF950613','FRANCISCO','','','','FRANCISCO SOLORSANO ARAUJO','','','','',0,0,0,'','','s','1995-06-13');

/*Table structure for table `codigo_producto` */

DROP TABLE IF EXISTS `codigo_producto`;

CREATE TABLE `codigo_producto` (
  `id_codigo` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_producto` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `tipo_identificador` varchar(255) NOT NULL,
  `identificador` varchar(50) NOT NULL,
  `numero` bigint(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(10) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  PRIMARY KEY (`id_codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=585 DEFAULT CHARSET=latin1;

/*Data for the table `codigo_producto` */

insert  into `codigo_producto`(`id_codigo`,`id_producto`,`tipo_identificador`,`identificador`,`numero`,`fecha`,`estado`,`id_sucursal`) values (584,'7506227321773','ICCID','8952020016294951781',0,'2016-08-17 11:28:52','n','2');

/*Table structure for table `codigo_producto_temp` */

DROP TABLE IF EXISTS `codigo_producto_temp`;

CREATE TABLE `codigo_producto_temp` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `identificador` varchar(255) NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  `id_movimiento` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `codigo_producto_temp` */

/*Table structure for table `comision` */

DROP TABLE IF EXISTS `comision`;

CREATE TABLE `comision` (
  `id_comision` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `porcentaje` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`id_comision`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `comision` */

insert  into `comision`(`id_comision`,`nombre`,`tipo`,`porcentaje`,`descripcion`) values (10,'VENTA DE REFACCIONES','REFACCION','1','VENTA DE REFACCIONES PARA LAS REPARACIONES'),(3,'VENTA DE TELEFONIA','TELEFONO','5','VENTA DE EQUIPOS TELEFONICOS'),(4,'VENTA DE FICHAS','FICHA','7','VENTA DE FICHAS TELEFONICAS'),(5,'VENTA DE CHIPS','CHIP','8','VENTA DE CHIPS PARA NUEVO USO'),(6,'VENTA DE ACCESORIOS','ACCESORIO','5','VENTA DE ACCESORIOS PARA TODO TIPO DE EQUIPO TELEFONICO'),(8,'VENTA DE REPARACIONES','REPARACION','4','COMISIONES POR REPARACION'),(14,'VENTA TAE TELCEL','RECARGA','5','SE ASIGNA UN PORCENTAJE POR CADA RECARGA QUE SE REALICE'),(15,'VENTA TAE MOVISTAR','RECARGA','5','VENTA DE TAE MOVISTAR'),(16,'VENTA TAE NEXTEL','RECARGA','5','VENTA DE TAE PARA NEXTEL'),(17,'VENTA TAE IUSACELL','RECARGA','3','VENTA DE TAE PARA IUSACELL'),(18,'VENTA TAE UNEFON','RECARGA','2','VENTA DE TAE PARA UNEFON'),(19,'VENTA TAE VIRGIN MOBILE','RECARGA','3','VENTA DE TAE PARA VIRGIN MOBILE');

/*Table structure for table `compania_tl` */

DROP TABLE IF EXISTS `compania_tl`;

CREATE TABLE `compania_tl` (
  `id_compania` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_comision` bigint(50) NOT NULL,
  `com_asig` varchar(50) NOT NULL,
  PRIMARY KEY (`id_compania`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `compania_tl` */

insert  into `compania_tl`(`id_compania`,`nombre`,`codigo`,`id_comision`,`com_asig`) values (1,'Movistar','A',15,'1.06'),(2,'Nextel','NX',16,'1.06'),(3,'Iusacell','I',17,'1.06'),(4,'Unefon','U',18,'1.06'),(5,'Telcel','TL',14,'1.07'),(6,'Virgin Mobile','VM',19,'1.06');

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
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

/*Data for the table `credito` */

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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Data for the table `denominacion` */

insert  into `denominacion`(`id_denominacion`,`id_compania`,`valor`) values (1,1,'10'),(2,1,'20'),(3,1,'30'),(4,1,'35'),(5,1,'40'),(6,1,'50'),(7,1,'60'),(8,1,'65'),(9,1,'100'),(10,1,'105'),(11,2,'10'),(12,2,'20'),(13,2,'30'),(14,2,'50'),(15,2,'70'),(16,2,'100'),(17,3,'10'),(18,3,'20'),(19,3,'30'),(20,3,'50'),(21,3,'100'),(22,4,'10'),(23,4,'20'),(24,4,'30'),(25,4,'50'),(26,4,'100'),(27,5,'20'),(28,5,'30'),(29,5,'50'),(30,5,'100'),(31,6,'20'),(32,6,'30'),(33,6,'40'),(34,6,'50'),(35,6,'100');

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
  `fecha_op` datetime NOT NULL,
  `usu` varchar(255) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  `garantia` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=latin1;

/*Data for the table `detalle` */

insert  into `detalle`(`id`,`factura`,`codigo`,`nombre`,`cantidad`,`valor`,`importe`,`tipo`,`fecha_op`,`usu`,`id_sucursal`,`garantia`) values (181,'1000','ZTEGLUX0','ZTE BLADE G LUX','1','1599','1599','CONTADO','2016-06-03 12:54:50','Admin','2','garantia'),(182,'1000','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CONTADO','2016-06-03 12:54:50','Admin','2','garantia'),(183,'1001','7500326211539','OCEAN MINI','1','999','999','CONTADO','2016-06-03 13:04:29','Admin','2','garantia'),(184,'1002','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CONTADO','2016-06-03 16:58:15','Admin','2','garantia'),(185,'1000','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CONTADO','2016-06-08 17:19:44','cajero2','1',''),(186,'1001','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CONTADO','2016-06-08 18:31:38','cajero2','1','garantia'),(187,'1002','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CONTADO','2016-06-09 11:52:01','cajero2','1','garantia'),(188,'1003','MCT0','PIXI 3/OT4027/OT5017','1','30','30','CONTADO','2016-06-13 16:13:00','Admin','1','garantia'),(189,'1004','MCT0','PIXI 3/OT4027/OT5017','1','25','25','CONTADO','2016-06-13 16:26:57','Admin','1',''),(190,'1005','MCT0','PIXI 3/OT4027/OT5017','2','25','50','CONTADO','2016-06-13 16:28:45','Admin','1',''),(191,'1006','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CREDITO','2016-06-14 11:10:17','Admin','1',''),(192,'1007','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CREDITO','2016-06-14 11:16:09','Admin','1',''),(193,'1003','','','1','35','35','CONTADO','2016-06-16 18:54:55','Admin','2','garantia'),(194,'1004','I','TAE Iusacell','1','20','20','CONTADO','2016-06-16 18:59:41','Admin','2',''),(195,'1005','NX','TAE Nextel','1','50','50','CONTADO','2016-06-16 19:06:43','Admin','2',''),(196,'1008','TL','TAE Telcel','1','20','20','CONTADO','2016-06-17 10:33:37','Admin','1',''),(197,'1009','MCT0','PIXI 3/OT4027/OT5017','1','70','70','CONTADO','2016-06-17 11:31:08','Admin','1',''),(198,'1010','TL','TAE Telcel','1','20','20','CONTADO','2016-06-17 14:44:38','Admin','1',''),(199,'1011','A','TAE Movistar','1','10','10','CONTADO','2016-06-17 15:04:54','Admin','1',''),(200,'1012','TL','TAE Telcel','1','20','20','CONTADO','2016-06-17 15:12:22','Admin','1',''),(201,'1013','TL','TAE Telcel','1','20','20','CONTADO','2016-06-17 15:13:26','Admin','1',''),(202,'1014','TL','TAE Telcel','1','20','20','CONTADO','2016-06-17 15:21:44','Admin','1',''),(203,'1015','TL','TAE Telcel','1','20','20','CONTADO','2016-06-17 15:25:52','Admin','1',''),(204,'1016','VM','TAE Virgin Mobile','1','50','50','CONTADO','2016-06-17 15:30:00','Admin','1',''),(205,'1017','U','TAE Unefon','1','30','30','CONTADO','2016-06-17 15:31:54','Admin','1',''),(206,'1018','I','TAE Iusacell','1','50','50','CONTADO','2016-06-17 18:31:10','Admin','1',''),(207,'1019','6253465364536','ALFA/G850','1','250','250','CONTADO','2016-08-15 18:23:56','Admin','1','garantia'),(208,'1006','A','TAE Movistar','1','10','10','CONTADO','2016-08-17 12:14:05','Admin','2',''),(209,'1000','NX','TAE Nextel','1','30','30','CONTADO','2016-08-19 10:55:12','Admin','203','');

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
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

/*Data for the table `detalle_caja` */

insert  into `detalle_caja`(`id`,`id_cajero`,`apertura`,`ventas`,`cierre`,`horainicio`,`horacierre`,`fecha`,`autoriza`) values (28,'123','500','2668','1000','11:17','1:10','2016-06-03','supervisor'),(29,'abc','','70','50','5:16','5:20','2016-06-08','supervisor'),(30,'abc','20','0','0','5:23','5:50','2016-06-08','supervisor'),(31,'abc','20','0','0','5:55','5:58','2016-06-08','supervisor'),(32,'abc','20','0','0','6:11','6:12','2016-06-08','supervisor'),(33,'abc','20','0','0','6:14','6:16','2016-06-08','supervisor'),(34,'abc','0','','0','6:28','6:30','2016-06-08','supervisor'),(35,'abc','0','70','50','6:31','6:32','2016-06-08','supervisor'),(36,'abc','20','70','50','6:31','11:56','2016-06-09','supervisor'),(37,'123','2168','315','1000','1:34','10:37','2016-06-17','supervisor'),(38,'BEME910904HMCCRD05','','','0','12:32','1:41','2016-06-22','supervisor'),(39,'123','1483','70','','3:28','11:36','2016-06-23',''),(40,'123','0','0','0','11:39','11:44','2016-06-23',''),(41,'123','10','0','0','10:08','1:24','2016-08-01',''),(42,'123','0','250','250','5:15','10:05','2016-08-17',''),(43,'123','','','0','11:25','11:26','2016-08-17',''),(44,'123','0','0','0','11:26','12:41','2016-08-17',''),(45,'BEME910904HMCCRD05','0','','0','12:41','1:00','2016-08-17',''),(46,'123','','0','0','1:00','1:04','2016-08-17',''),(47,'123','','0','0','1:08','1:12','2016-08-17',''),(48,'74U8FHOUGRU8GS8G','0','','0','1:05','1:57','2016-08-17',''),(49,'123','0','0','0','1:21','10:08','2016-08-18',''),(50,'123','0','0','0','10:53','10:57','2016-08-19','supervisor'),(51,'123','10','0','0','10:53','11:10','2016-08-19',''),(52,'123','','0','0','11:13','11:14','2016-08-19',''),(53,'123','0','0','0','1:19','2:19','2016-08-22',''),(54,'BEME910904HMCCRD05','0','0','0','1:57','2:22','2016-08-22','');

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
  `tamano` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*Data for the table `empresa` */

insert  into `empresa`(`id`,`empresa`,`nit`,`direccion`,`ciudad`,`tel1`,`tel2`,`web`,`correo`,`iva`,`tamano`) values (1,'MATRIZ','234','AV. GUSTAVO BAZ PRADA SUR NO. 304 COL. CENTRO, IXTLAHUACA, EDO. MEX. C.P.: 50740','MEXICO','(712)283-09-07','-','www.surticel.com','surticel@mail.com','-','-'),(2,'RAYON','27','Xonacatlan Colonia Centro','Mexico','123456789','','www.surticel.com','surticel@mail.com','',''),(203,'CONDESA1','2','Isidro fabela','Mexico','987654321','','www.surticel.com','surticel@mail.com','',''),(988,'NICOLAS','23','Alfredo del Mazo','Mexico','657438291','','www.surticel.com','surticel@mail.com','',''),(543,'PREMIER','293','COLONIA CENTRO','MEXICO','765424312','','surticel.com.mx','jmorales@aiko.com.mx','',''),(10,'NUEVA','5','DEMO','DEMO','12345','','12345','12345@HDF.COM','','');

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

insert  into `factura`(`factura`,`cajera`,`fecha`,`estado`,`tipo_pago`,`id_sucursal`) values ('1000','Admin','2016-06-03','s','Efectivo','2'),('1001','Admin','2016-06-03','s','Efectivo','2'),('1002','Admin','2016-06-03','s','Efectivo','2'),('1000','cajero2','2016-06-08','s','Efectivo','1'),('1001','cajero2','2016-06-08','s','Efectivo','1'),('1002','cajero2','2016-06-09','s','Efectivo','1'),('1003','Admin','2016-06-13','s','Efectivo','1'),('1004','Admin','2016-06-13','s','Efectivo','1'),('1005','Admin','2016-06-13','s','Efectivo','1'),('1006','Admin','2016-06-14','s','Efectivo','1'),('1007','Admin','2016-06-14','s','Efectivo','1'),('1003','Admin','2016-06-16','s','CONTADO','2'),('1004','Admin','2016-06-16','s','CONTADO','2'),('1005','Admin','2016-06-16','s','CONTADO','2'),('1008','Admin','2016-06-17','s','CONTADO','1'),('1009','Admin','2016-06-17','s','Efectivo','1'),('1010','Admin','2016-06-17','s','CONTADO','1'),('1011','Admin','2016-06-17','s','CONTADO','1'),('1012','Admin','2016-06-17','s','CONTADO','1'),('1013','Admin','2016-06-17','s','CONTADO','1'),('1014','Admin','2016-06-17','s','CONTADO','1'),('1015','Admin','2016-06-17','s','CONTADO','1'),('1016','Admin','2016-06-17','s','CONTADO','1'),('1017','Admin','2016-06-17','s','CONTADO','1'),('1018','Admin','2016-06-17','s','CONTADO','1'),('1019','Admin','2016-08-15','s','Efectivo','1'),('1006','Admin','2016-08-17','s','CONTADO','2'),('1000','Admin','2016-08-19','s','CONTADO','203');

/*Table structure for table `gastos` */

DROP TABLE IF EXISTS `gastos`;

CREATE TABLE `gastos` (
  `id_gasto` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_camion` bigint(50) NOT NULL,
  `concepto` varchar(500) NOT NULL,
  `numero_fact` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `total` varchar(100) NOT NULL,
  `iva` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `id_sucursal` varchar(255) NOT NULL,
  PRIMARY KEY (`id_gasto`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Data for the table `movimiento` */

insert  into `movimiento`(`id_movimiento`,`tipo`,`id_suc_salida`,`id_suc_entrada`,`usu_salida`,`usu_entrada`,`id_producto`,`cantidad`,`fecha`,`fecha2`,`estado`) values (30,'traslado','1','2','Admin','Admin','AZUMILTV0','1','2016-06-03 00:00:00','0000-00-00 00:00:00','2'),(31,'traslado','1','2','Admin','Admin','MCT0','2','2016-06-03 00:00:00','0000-00-00 00:00:00','2'),(32,'traslado','1','2','Admin','Admin','6246235463546','1','2016-06-08 11:56:24','2016-06-08 12:20:00','2'),(33,'traslado','1','203','Admin','Admin','7506227321773','1','2016-08-17 11:30:12','2016-08-17 11:31:01','2'),(34,'traslado','203','2','Admin','Admin','7506227321773','1','2016-08-17 11:31:42','2016-08-17 11:34:43','2');

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

insert  into `producto`(`cod`,`prov`,`cprov`,`nom`,`costo`,`mayor`,`venta`,`especial`,`cantidad`,`minimo`,`seccion`,`fecha`,`estado`,`id_comision`,`unidad`,`id_sucursal`,`marca`,`modelo`,`compania`,`valor`,`tipo_ficha`,`color`,`categoria`,`faltantes`,`sobrantes`) values ('7506227321773','26','','CHIP TELCEL','50','65','105','60','0','1','21','2016-08-17','s','5',1,'1','','','TELCEL','','NORMAL','','',NULL,NULL),('7506227321773','26','','CHIP TELCEL','50','65','105','60','0','1','21','2016-08-17','s','5',1,'2','','','TELCEL','','NORMAL','','',1,0),('7506227321773','26','','CHIP TELCEL','50','65','105','60','0','1','21','2016-08-17','s','5',1,'203','','','TELCEL','','NORMAL','','',NULL,NULL),('7506227321773','26','','CHIP TELCEL','50','65','105','60','1','1','21','2016-08-17','s','5',1,'988','','','TELCEL','','NORMAL','','',1,0),('7506227321773','26','','CHIP TELCEL','50','65','105','60','0','1','21','2016-08-17','s','5',1,'543','','','TELCEL','','NORMAL','','',NULL,NULL),('TOUCHG5306','24','','TOUCH/TOUCH/PRIME/G530','200','300','400','250','3','0','21','2016-08-17','s','10',1,'1','SAMSUM','','','','','DORADO','TOUCH',NULL,NULL),('TOUCHG5306','24','','TOUCH/TOUCH/PRIME/G530','200','300','400','250','0','0','21','2016-08-17','s','10',1,'2','SAMSUM','','','','','DORADO','TOUCH',NULL,NULL),('TOUCHG5306','24','','TOUCH/TOUCH/PRIME/G530','200','300','400','250','0','0','21','2016-08-17','s','10',1,'203','SAMSUM','','','','','DORADO','TOUCH',NULL,NULL),('TOUCHG5306','24','','TOUCH/TOUCH/PRIME/G530','200','300','400','250','0','0','21','2016-08-17','s','10',1,'988','SAMSUM','','','','','DORADO','TOUCH',0,1),('TOUCHG5306','24','','TOUCH/TOUCH/PRIME/G530','200','300','400','250','0','0','21','2016-08-17','s','10',1,'543','SAMSUM','','','','','DORADO','TOUCH',NULL,NULL),('TOUCHG530BLC6','24','','TOUCH/PRIME/G530/G531','250','350','450','300','2','0','21','2016-08-17','s','10',1,'1','SAMSUM','','','','','BLANCO','TOUCH',NULL,NULL),('TOUCHG530BLC6','24','','TOUCH/PRIME/G530/G531','250','350','450','300','0','0','21','2016-08-17','s','10',1,'2','SAMSUM','','','','','BLANCO','TOUCH',NULL,NULL),('TOUCHG530BLC6','24','','TOUCH/PRIME/G530/G531','250','350','450','300','0','0','21','2016-08-17','s','10',1,'203','SAMSUM','','','','','BLANCO','TOUCH',NULL,NULL),('TOUCHG530BLC6','24','','TOUCH/PRIME/G530/G531','250','350','450','300','0','0','21','2016-08-17','s','10',1,'988','SAMSUM','','','','','BLANCO','TOUCH',NULL,NULL),('TOUCHG530BLC6','24','','TOUCH/PRIME/G530/G531','250','350','450','300','0','0','21','2016-08-17','s','10',1,'543','SAMSUM','','','','','BLANCO','TOUCH',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `proveedor` */

insert  into `proveedor`(`codigo`,`empresa`,`nom`,`dir`,`ciudad`,`tel`,`cel`,`correo`,`obs`,`estado`,`rfc`,`calle`,`colonia`,`lestado`,`next`,`nint`,`pais`,`cp`,`regimen`) values (21,'AIKO','AIKO','','TOLUCA','722536464','722536464','aiko@aiko.com','','s','B6W4GBF634G3G9C','VERTICE','VERTICE NORTE','MEXICO',203,203,'MEXICO',2030,''),(22,'TELMEX','TELMEX','','ATLACOMULCO','722830123','722830123','telmex@telmex.com','','s','telmex','CAMINO A SAN FELIPE','CENTRO','michoacan',0,0,'MEXICO',5000,'PERSONA MORAL'),(23,'AX COMUNICACIONES','OFICINA','','','5555555555','5555555555','axcomunicaciones@axcomunicaciones.com','','s','AX','COLONIA CENTRO','','',0,0,'',6000,'PERSONA MORAL'),(24,'MOBO','MOBO','','','12345','12345','MOBO@MOBO.COM','','s','MOBO','S/N','','',0,0,'',0,'PERSONA MORAL'),(25,'PROVEEDOR PILOTO','PCONTACT','','TOLUCA','63645345','6354653645234','correo@gsvd.com','','s','643EFEYWYFG','CONOCIDA','TOLUCA','MEXICO',4,4,'MEXICO',73467,'PERSONA FISICA'),(26,'NUEVA','SDF','','','2364572354','623463434','gsdvfsvf@hgf.com','','s','36GYW78DGE78DG7','HDVFHSDBF','','',0,0,'',3547354,''),(27,'NBDFVHSDBVCHVXVHDBV','SGDCGSD','','','63546354','36456354','shdgcvhdcvd@shdg.com','','s','GHSDVFHJSDGHDGF','JHSCVHSDVCHS','','',0,0,'',0,'');

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
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `recarga` */

insert  into `recarga`(`id_recarga`,`monto`,`numero`,`compania`,`estatus`,`id_sucursal`,`usuario`,`fecha_hora`) values (19,'35','7221725421','','s','2','Admin','2016-06-16 18:54:55'),(20,'20','7221725421','I','s','2','Admin','2016-06-16 18:59:41'),(21,'50','7221725421','NX','s','2','Admin','2016-06-16 19:06:43'),(22,'20','7221725421','TL','s','1','Admin','2016-06-17 10:33:37'),(23,'20','7221725421','TL','s','1','Admin','2016-06-17 14:44:38'),(24,'10','7221725421','A','s','1','Admin','2016-06-17 15:04:54'),(25,'20','7221725421','TL','s','1','Admin','2016-06-17 15:12:22'),(26,'20','7221725421','TL','s','1','Admin','2016-06-17 15:13:26'),(27,'20','7221725421','TL','s','1','Admin','2016-06-17 15:21:44'),(28,'20','7221725421','TL','s','1','Admin','2016-06-17 15:25:52'),(29,'50','7221725421','VM','s','1','Admin','2016-06-17 15:30:00'),(30,'30','7221725421','U','s','1','Admin','2016-06-17 15:31:54'),(31,'50','7221725421','I','s','1','Admin','2016-06-17 18:31:10'),(32,'10','7221725421','A','s','2','Admin','2016-08-17 12:14:05'),(33,'30','7221725421','NX','s','203','Admin','2016-08-19 10:55:13');

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
  `mano_obra` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `reparacion` */

insert  into `reparacion`(`id_reparacion`,`id_sucursal`,`usuario`,`cod_cliente`,`imei`,`marca`,`modelo`,`color`,`precio`,`abono`,`motivo`,`observacion`,`fecha_ingreso`,`fecha_salida`,`id_comision`,`estado`,`chip`,`memoria`,`costo`,`nombre_contacto`,`telefono_contacto`,`rfc_curp_contacto`,`tecnico`,`id_productos`,`garantia`,`id_garantia`,`tipo_precio`,`mano_obra`) values (2,'1','cajero2','841803','','LG','MAX','BLANCO','250','0','MOJADO','','2016-06-03','2016-07-03','8','2','no','no','','OSCAR PLUTARCO TORRES','712212139','PUTO810101','tecnico1','','',0,'2','50'),(1,'1','cajero2','395106','','SAMSUM','ALFA','GRIS','800','0','LCD','','2016-06-03','2016-06-03','8','1','no','no','300','EDUARDO BECERRIL MARTINEZ','n/p','BEME791221','tecnico1','','',0,'2','100'),(3,'1','Admin','863662','','SAMSUM','TERET','NEGRO','1300','0','FLEXEO','HHSDHAHDAHDHADAD','2016-06-10','2016-07-10','8','4','no','no','850','EDUARDO BECERRIL MARTINEZ','7363545453','BEME910302','tecnico1','','',0,'3','200'),(1,'203','Admin','852016','','SONY','XTRE','PLATA','400','0','FLEXEO','GSDVHFVSHCVSDHCVDSHCVSHCVSDHVCHDVC','2016-06-16','2016-07-16','8','0','no','no','','EDUARDO BECERRIL MARTINEZ','7253535322','BEME060614','','','',0,'',''),(2,'203','cajero3','365351','','ALCATEL','ONE TOUCH','GRIS','500','0','TUCH','GSDDVHSAVDHSAVDHJASVDHASDJHGASHJDGASD','2016-06-16','2016-07-16','8','2','no','no','','EDUARDO BECERRIL MARTINEZ','735342421','BEME030924','','','',0,'',''),(4,'1','Admin','71120','','ALCATEL','ONE TOUCH MINI','FRIS','150','0','ACTUALIZACION','SDGGFHJSDGFHJDGHJFG','2016-06-17','2016-06-17','8','3','no','no','0','EDUARDO BECERRIL MARTINEZ','7353645634','BEME910904','tecnico1','','',0,'2','50'),(5,'1','Admin','71120','','ALCATEL','ONE TOUCH MINI','FRIS','150','0','ACTUALIZACION','se apago a las dos 2 horas de entregado','2016-06-17','2016-06-23','8','1','no','no','0','EDUARDO BECERRIL MARTINEZ','7353645634','BEME910904','','','s',4,'',''),(1,'988','cajero','440014','','SAMSUM','G530','BLANCO','500','0','TOUCH ROTO','NO DA IMAGEN','2016-08-17','2016-09-16','8','0','no','no','','OSCAR PLUTARCO TORRES','N/P','PUTO010101','','','',0,'',''),(2,'988','cajero','697934','','SAMSUN','G530','BLANCO','500','0','TOUCH','NO PRESENTA IMAGEN','2016-08-17','2016-09-16','8','0','no','no','','OSCAR PLUTARCO TORRES','n/p','PUTO010101','','','',0,'',''),(3,'988','cajero','277853','','SAMSUM','G500','BLANCO','500','0','TOUCH','NO HAY IMAGEN','2016-08-17','2016-09-16','8','0','no','no','','OSCAR PLUTARCO TORRES','N/P','PUTO010101','','','',0,'',''),(6,'1','tecnico1','864699','','ZTE','GLUX','NEGRO','50','0','WHATSAPP','DESCARGAR WHATS APP','2016-08-17','2016-08-17','8','3','si','si','0','CECILIA MARTINEZ HERNANDEZ','7122834020','MAHC010101','tecnico1','','',0,'2','20');

/*Table structure for table `reparacion_refaccion` */

DROP TABLE IF EXISTS `reparacion_refaccion`;

CREATE TABLE `reparacion_refaccion` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_reparacion` bigint(50) NOT NULL,
  `id_producto` bigint(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Data for the table `reparacion_refaccion` */

insert  into `reparacion_refaccion`(`id`,`id_reparacion`,`id_producto`) values (25,1,6246235463546),(27,3,5234652435353),(28,3,6253465364536),(29,1,0);

/*Table structure for table `seccion` */

DROP TABLE IF EXISTS `seccion`;

CREATE TABLE `seccion` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `seccion` */

insert  into `seccion`(`id`,`nombre`,`estado`) values (21,'GENERALES','s'),(22,'BODEGA 1','s');

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

insert  into `solicitud`(`id_solicitud`,`id_sucursal`,`usuario`,`producto`,`marca`,`especificacion`,`cantidad`,`fecha`) values (1,'1','Admin','SERVICIO','HP','VENTA DE COMPURADORAS',10,'2016-06-17');

/*Table structure for table `unidad_medida` */

DROP TABLE IF EXISTS `unidad_medida`;

CREATE TABLE `unidad_medida` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `abreviatura` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `equivalencia` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `unidad_medida` */

insert  into `unidad_medida`(`id`,`nombre`,`abreviatura`,`descripcion`,`equivalencia`) values (1,'Pieza','pza','','1');

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

insert  into `usuarios`(`ced`,`estado`,`nom`,`dir`,`tel`,`cel`,`cupo`,`barrio`,`ciudad`,`usu`,`con`,`tipo`,`cp`,`sueldo`,`sexo`,`id_sucursal`) values ('123','s','Administrador','-','-','-','','-','Mexico','Admin','Admin','a','-',0,'h',''),('653425','s','Supervisor','Dir supervisor','625254','526263','-','localidad supervisor','MEXICO','supervisor','supervisor','su','-',1000,'h','1'),('74U8FHOUGRU8GS8G','s','Tecnico suc 1','direccion tecnico','124','123','','localidad del tecnico','MEXICO','tecnico1','tecnico1','te','',1000,'h','1'),('abc','s','Eduardo Becerril Martinez','direccion piloto 2','123','123','','localidad piloto 2','Mexico','cajero2','cajero2','ca','',1000,'h','1'),('BEME910904HMCCRD05','s','Eduardo Becerril Martinez','Guadalupe Victoria','-','7221725421','','Pueblo Nuevo','Mexico','cajero','cajero','ca','',1000,'h','988'),('rerererererere','s','TECNICO 2','odreccion tecnico 2','4132','6354','','localidad del tecnico 2','Mexico','tecnico2','tecnico2','te','',1000,'h','1'),('TE53R46RY','s','JUAN MORALES HERNANDEZ','TEMOAYA','7227084992','7227084992','','TEMOAYA','MEXICO','juan','juan','ca','',8551,'h','543'),('Y3F4R38YEVF8Y3FV4','n','NORMA','San Lorenzo','12345','12345','','Unkdown','MEXICO','norma','norma','ca','',1000,'m','1'),('YWEFR634GRY','s','EMPLEADO DEMO','CALLE DEMO','12345','12345','','LOCALIDAD DEMO','MEXICO','cajero3','cajero3','ca','',1000,'h','203');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
