-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,MYSQL323' */;


--
-- Create schema lacosturita
--

CREATE DATABASE IF NOT EXISTS sastreria;
USE sastreria;

--
-- Definition of table `audita_servicios`
--

DROP TABLE IF EXISTS `audita_servicios`;
CREATE TABLE `audita_servicios` (
  `id` int(10) unsigned NOT NULL,
  `nombre_anterior` varchar(255) default NULL,
  `nombre_nuevo` varchar(255) default NULL,
  `precio_anterior` decimal(11,2) default NULL,
  `precio_nuevo` decimal(11,2) default NULL,
  `prenda_anterior` int(9) unsigned default NULL,
  `prenda_nueva` int(9) unsigned default NULL,
  `fecha` datetime default NULL,
  `consecutivo` int(10) unsigned NOT NULL auto_increment,
  `activo_antes` tinyint(3) unsigned default NULL,
  `activo_despues` tinyint(3) unsigned default NULL,
  PRIMARY KEY  (`consecutivo`),
  KEY `prenda_nuevak` (`prenda_nueva`),
  KEY `prenda_anteriork` (`prenda_anterior`),
  KEY `index_4` (`id`),
  KEY `Index_5` (`fecha`)
);

--
-- Dumping data for table `audita_servicios`
--

/*!40000 ALTER TABLE `audita_servicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `audita_servicios` ENABLE KEYS */;


--
-- Definition of table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text,
  PRIMARY KEY  (`session_id`)
);

--
-- Dumping data for table `ci_sessions`
--

/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;


--
-- Definition of table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(9) unsigned NOT NULL auto_increment,
  `nombre` varchar(70) NOT NULL,
  `dire` varchar(255) NOT NULL,
  `col` varchar(100) default ' ',
  `pob` varchar(100) default ' ',
  `num` varchar(50) default ' ',
  `int` varchar(50) default ' ',
  `cp` varchar(100) default '0',
  `descu` decimal(5,2) default '0.00',
  `rfc` varchar(13) default ' ',
  `correo` varchar(45) default ' ',
  `telcasa` varchar(100) default ' ',
  `teltra` varchar(18) default ' ',
  `telcel` varchar(18) default ' ',
  `tipo` int(2) unsigned default '1',
  PRIMARY KEY  (`id`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `clientes`
--

/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;


--
-- Definition of table `cs_clientes`
--

DROP TABLE IF EXISTS `cs_clientes`;
CREATE TABLE `cs_clientes` (
  `id` int(9) unsigned NOT NULL auto_increment,
  `nombre` varchar(70) NOT NULL,
  `dire` varchar(255) NOT NULL,
  `correo` varchar(45) default ' ',
  `telcasa` varchar(100) default ' ',
  `teltra` varchar(18) default ' ',
  `telcel` varchar(18) default ' ',
  PRIMARY KEY  (`id`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cs_clientes`
--

/*!40000 ALTER TABLE `cs_clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_clientes` ENABLE KEYS */;


--
-- Definition of table `cs_estatus`
--

DROP TABLE IF EXISTS `cs_estatus`;
CREATE TABLE `cs_estatus` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
);

--
-- Dumping data for table `cs_estatus`
--

/*!40000 ALTER TABLE `cs_estatus` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_estatus` ENABLE KEYS */;


--
-- Definition of table `cs_formas_pago`
--

DROP TABLE IF EXISTS `cs_formas_pago`;
CREATE TABLE `cs_formas_pago` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
);

--
-- Dumping data for table `cs_formas_pago`
--

/*!40000 ALTER TABLE `cs_formas_pago` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_formas_pago` ENABLE KEYS */;


--
-- Definition of table `cs_ordendetalle`
--

DROP TABLE IF EXISTS `cs_ordendetalle`;
CREATE TABLE `cs_ordendetalle` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ordenid` int(10) unsigned NOT NULL default '0',
  `prendaid` int(10) unsigned NOT NULL default '0',
  `servicioid` int(10) unsigned NOT NULL default '0',
  `precio` decimal(11,2) NOT NULL default '0.00',
  `cantidad` int(10) unsigned NOT NULL default '0',
  `idservicio2` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `orden_c` (`ordenid`),
  KEY `prena` (`prendaid`),
  KEY `servicio` (`servicioid`),
  KEY `Index_4` (`idservicio2`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cs_ordendetalle`
--

/*!40000 ALTER TABLE `cs_ordendetalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_ordendetalle` ENABLE KEYS */;


--
-- Definition of table `cs_ordenes`
--

DROP TABLE IF EXISTS `cs_ordenes`;
CREATE TABLE `cs_ordenes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_cliente` int(10) unsigned NOT NULL default '0',
  `fecha_alta` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `hora_entrega` time NOT NULL,
  `importe` decimal(11,2) NOT NULL default '0.00',
  `descu` decimal(11,2) NOT NULL default '0.00',
  `descuentox` int(10) unsigned NOT NULL default '0',
  `total` decimal(11,2) NOT NULL default '0.00',
  `abono` decimal(11,2) NOT NULL default '0.00',
  `pendiente` decimal(11,2) NOT NULL default '0.00',
  `no_prendas` int(10) unsigned NOT NULL default '0',
  `observacion` text,
  `id_status` int(10) unsigned NOT NULL default '1',
  `id_user` int(10) unsigned default NULL,
  `fecha_captura` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `fecha_alta` (`fecha_alta`),
  KEY `fecha_entrega` (`fecha_entrega`),
  KEY `id_status` (`id_status`),
  KEY `id_user` (`id_user`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cs_ordenes`
--

/*!40000 ALTER TABLE `cs_ordenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_ordenes` ENABLE KEYS */;


--
-- Definition of table `cs_pagos`
--

DROP TABLE IF EXISTS `cs_pagos`;
CREATE TABLE `cs_pagos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ordenid` int(10) unsigned NOT NULL,
  `pago` int(10) unsigned NOT NULL,
  `referencia` varchar(45) default NULL,
  `abono` decimal(11,2) NOT NULL default '0.00',
  `fecha` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `index_2` (`ordenid`),
  KEY `index_4` (`user_id`),
  KEY `index_3` (`fecha`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cs_pagos`
--

/*!40000 ALTER TABLE `cs_pagos` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_pagos` ENABLE KEYS */;


--
-- Definition of table `cs_prendas`
--

DROP TABLE IF EXISTS `cs_prendas`;
CREATE TABLE `cs_prendas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `prenda` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`)
);

--
-- Dumping data for table `cs_prendas`
--

/*!40000 ALTER TABLE `cs_prendas` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_prendas` ENABLE KEYS */;


--
-- Definition of table `cs_servicios`
--

DROP TABLE IF EXISTS `cs_servicios`;
CREATE TABLE `cs_servicios` (
  `id` int(10) unsigned NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `prenda` int(9) unsigned NOT NULL,
  `id2` int(10) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`,`prenda`),
  KEY `prendas` (`prenda`),
  KEY `index_3` (`id2`)
);

--
-- Dumping data for table `cs_servicios`
--

/*!40000 ALTER TABLE `cs_servicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_servicios` ENABLE KEYS */;


--
-- Definition of table `cs_usuarios`
--

DROP TABLE IF EXISTS `cs_usuarios`;
CREATE TABLE `cs_usuarios` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nivel` tinyint(3) unsigned NOT NULL,
  `nombre` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_2` (`username`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `cs_usuarios`
--

/*!40000 ALTER TABLE `cs_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs_usuarios` ENABLE KEYS */;


--
-- Definition of table `estatus`
--

DROP TABLE IF EXISTS `estatus`;
CREATE TABLE `estatus` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `tipo` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) AUTO_INCREMENT=5 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `estatus`
--

/*!40000 ALTER TABLE `estatus` DISABLE KEYS */;
INSERT INTO `estatus` (`id`,`nombre`,`tipo`) VALUES 
 (1,'PENDIENTE',1),
 (2,'CANCELADO',1),
 (3,'EN PROCESO',1),
 (4,'ENTREGADO',1);
/*!40000 ALTER TABLE `estatus` ENABLE KEYS */;


--
-- Definition of table `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `horario` time NOT NULL,
  `tipo` int(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=28;

--
-- Dumping data for table `horario`
--

/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` (`id`,`horario`,`tipo`) VALUES 
 (1,'08:00:00',0),
 (2,'08:30:00',0),
 (3,'09:00:00',0),
 (4,'09:30:00',0),
 (5,'10:00:00',0),
 (6,'10:30:00',0),
 (7,'11:00:00',0),
 (8,'11:30:00',0),
 (9,'12:00:00',0),
 (10,'12:30:00',0),
 (11,'13:00:00',0),
 (12,'13:30:00',0),
 (13,'14:00:00',0),
 (14,'14:30:00',0),
 (15,'15:00:00',0),
 (16,'15:30:00',0),
 (17,'16:00:00',0),
 (18,'16:30:00',0),
 (19,'17:00:00',0),
 (20,'17:30:00',0),
 (21,'18:00:00',0),
 (22,'18:30:00',0),
 (23,'19:00:00',0),
 (24,'19:30:00',0),
 (25,'20:00:00',0),
 (26,'20:30:00',0),
 (27,'21:00:00',0);
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;


--
-- Definition of table `orden_c`
--

DROP TABLE IF EXISTS `orden_c`;
CREATE TABLE `orden_c` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_cliente` int(10) unsigned NOT NULL default '0',
  `fecha_alta` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `hora_entrega` time NOT NULL,
  `importe` decimal(11,2) NOT NULL default '0.00',
  `descu` decimal(11,2) NOT NULL default '0.00',
  `descuentox` int(10) unsigned NOT NULL default '0',
  `total` decimal(11,2) NOT NULL default '0.00',
  `abono` decimal(11,2) NOT NULL default '0.00',
  `pendiente` decimal(11,2) NOT NULL default '0.00',
  `no_prendas` int(10) unsigned NOT NULL default '0',
  `observacion` text,
  `id_status` int(10) unsigned NOT NULL default '1',
  `id_user` int(10) unsigned default NULL,
  `fecha_captura` datetime default NULL,
  `motivo_cancelacion` varchar(255) default NULL,
  `fecha_cancelacion` datetime default NULL,
  `id_user_cancelacion` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `fecha_alta` (`fecha_alta`),
  KEY `fecha_entrega` (`fecha_entrega`),
  KEY `id_status` (`id_status`),
  KEY `id_user` (`id_user`),
  KEY `Index_7` (`id_user_cancelacion`)
) ROW_FORMAT=DYNAMIC COMMENT='InnoDB free: 1136640 kB';

--
-- Dumping data for table `orden_c`
--

/*!40000 ALTER TABLE `orden_c` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_c` ENABLE KEYS */;


--
-- Definition of table `orden_d`
--

DROP TABLE IF EXISTS `orden_d`;
CREATE TABLE `orden_d` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `c_id` int(10) unsigned NOT NULL default '0',
  `s_id` int(10) unsigned NOT NULL default '0',
  `precio` decimal(11,2) NOT NULL default '0.00',
  `cantidad` int(10) unsigned NOT NULL default '0',
  `id_user` int(10) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `orden_c` (`c_id`),
  KEY `servicio` (`s_id`),
  KEY `Index_4` (`id_user`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orden_d`
--

/*!40000 ALTER TABLE `orden_d` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_d` ENABLE KEYS */;


--
-- Definition of table `orden_p`
--

DROP TABLE IF EXISTS `orden_p`;
CREATE TABLE `orden_p` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `c_id` int(10) unsigned NOT NULL,
  `pago` int(10) unsigned NOT NULL,
  `referencia` varchar(45) default NULL,
  `abono` decimal(11,2) NOT NULL default '0.00',
  `fecha` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `index_2` (`c_id`),
  KEY `index_4` (`user_id`),
  KEY `index_3` (`fecha`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orden_p`
--

/*!40000 ALTER TABLE `orden_p` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_p` ENABLE KEYS */;


--
-- Definition of table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) AUTO_INCREMENT=6 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pagos`
--

/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` (`id`,`nombre`,`tipo`) VALUES 
 (1,'EFECTIVO',1),
 (2,'CHEQUE',1),
 (3,'TARJETA',1),
 (4,'CLIENTE FRECUENTE',1),
 (5,'VALES',1);
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;


--
-- Definition of table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
CREATE TABLE `parametros` (
  `dias` int(2) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL auto_increment,
  `sucursal` varchar(255) NOT NULL,
  `razon` varchar(255) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `regimen` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `clausulado` text,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=2;

--
-- Dumping data for table `parametros`
--

/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` (`dias`,`id`,`sucursal`,`razon`,`rfc`,`regimen`,`direccion`,`clausulado`) VALUES 
 (2,1,'Sucursal:','Razon Social','RFC','Regimen de Pequeño Contribuyente -----------------------------------------------','----------------------------------------------------','<p>Contrato de servicio que celebra entre el prestador del servicio y el consumidor cuyos nombres y datos constan en el presente documento, sujetándose a las siguientes clausulas:</p>\n1.	El número de prendas dejadas en el establecimiento están especificadas en el presente documento.</p>\n2.	Si al momento de recoger sus prendas el cliente no presenta su comprobante, deberá de presentar una copia de se identificación oficial.</p>\n3.	El cliente tiene una garantía de tres días hábiles para realizar cualquier reclamación sobre el trabajo realizado, con la presentación del comprobante de la prenda.</P>\n4.	En caso de no poder presentarse dentro de los tres días hábiles para hacer valida su garantía, deberá de notificar vía telefónica a la persona encargada, quien le proporcionara una clave para que el cliente pase en un lapso no mayor a 10 días hábiles.</p>\n5.	El establecimiento no se hace responsable de ningún objeto o valor olvidado en las prendas recibidas.</p>\n6.	El establecimiento no se hace responsable, por aquellas prendas que permanezcan más de noventa días y que no hayan sido buscadas por sus dueños, otorgándose de esta forma al establecimiento de manera inmediata, acreedor de las prendas olvidadas.</p>\n7.	El cliente pagara al establecimiento por concepto de almacenaje después de cuarenta y cinco días el 3% diario sobre el valor del comprobante, considerando que el importe a pagar no sea mayor o igual al importe del comprobante emitido.</p>\n8.	En caso de deterioro total o parcial de la prenda así como perdida de la misma, el establecimiento pagara al propietario de la misma hasta un máximo de 8 veces el costo del servicio pactado por dicha prenda, o un máximo del 80% del valor de la prenda que las partes de común acuerdo hayan declarado o en su defecto, el cliente puede demostrar con la nota de compra.</p>\n9.	Para dirimir cualquier controversia las partes se someten a la ley de protección al consumidor.</p>\nEl consumidor dará por aceptadas las normas, en el momento en que se reciba el comprobante de acuse de recibo.</p>');
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;


--
-- Definition of table `prendas`
--

DROP TABLE IF EXISTS `prendas`;
CREATE TABLE `prendas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `prendas`
--

/*!40000 ALTER TABLE `prendas` DISABLE KEYS */;
/*!40000 ALTER TABLE `prendas` ENABLE KEYS */;


--
-- Definition of table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
CREATE TABLE `servicios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `prenda` int(9) unsigned NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo` int(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `prendas` (`prenda`)
) ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `servicios`
--

/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;


--
-- Definition of trigger `servicios_inserta`
--

DROP TRIGGER /*!50030 IF EXISTS */ `servicios_inserta`;

DELIMITER $$

CREATE TRIGGER `servicios_inserta` AFTER INSERT ON `servicios` FOR EACH ROW BEGIN
insert into audita_servicios (id, nombre_anterior, nombre_nuevo, precio_anterior, precio_nuevo, prenda_anterior, prenda_nueva, fecha, activo_antes, activo_despues) values (NEW.id, null, NEW.nombre, null, NEW.precio, null, NEW.prenda, now(), null, NEW.tipo);
END $$

DELIMITER ;

--
-- Definition of trigger `servicios_actualiza`
--

DROP TRIGGER /*!50030 IF EXISTS */ `servicios_actualiza`;

DELIMITER $$

CREATE TRIGGER `servicios_actualiza` AFTER UPDATE ON `servicios` FOR EACH ROW BEGIN
insert into audita_servicios (id, nombre_anterior, nombre_nuevo, precio_anterior, precio_nuevo, prenda_anterior, prenda_nueva, fecha, activo_antes, activo_despues) values (NEW.id, OLD.nombre, NEW.nombre, OLD.precio, NEW.precio, OLD.prenda, NEW.prenda, now(), OLD.tipo, NEW.tipo);
END $$

DELIMITER ;

--
-- Definition of table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nivel` tinyint(3) unsigned NOT NULL,
  `tipo` tinyint(3) unsigned NOT NULL default '1',
  `nombre` varchar(60) NOT NULL,
  `puesto` varchar(45) NOT NULL,
  `email` varchar(45) default NULL,
  `avatar` varchar(45) NOT NULL default 'sample_user.png',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `index_2` (`username`)
) AUTO_INCREMENT=2 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `usuarios`
--

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`,`username`,`password`,`nivel`,`tipo`,`nombre`,`puesto`,`email`,`avatar`) VALUES 
 (1,'admin','admin',1,1,'SUPERVISOR DE TIENDA','SUPERVISOR',NULL,'sample_user.png');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

DROP TABLE IF EXISTS `cs_precios`;
CREATE TABLE  `cs_precios` (
  `idprenda` int(10) unsigned NOT NULL,
  `prenda` varchar(60) NOT NULL,
  `servicio` varchar(255) NOT NULL,
  `precio` decimal(12,2) DEFAULT '0.00',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
