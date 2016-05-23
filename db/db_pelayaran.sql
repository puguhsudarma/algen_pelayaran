/*
SQLyog Ultimate v8.61 
MySQL - 5.5.5-10.1.10-MariaDB-log : Database - algen_pelayaran
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`algen_pelayaran` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `algen_pelayaran`;

/*Table structure for table `jarak_antar_pelabuhan` */

DROP TABLE IF EXISTS `jarak_antar_pelabuhan`;

CREATE TABLE `jarak_antar_pelabuhan` (
  `id_jarak` int(11) NOT NULL AUTO_INCREMENT,
  `id_node_awal` int(11) DEFAULT NULL,
  `id_node_akhir` int(11) DEFAULT NULL,
  `jarak` float DEFAULT NULL,
  PRIMARY KEY (`id_jarak`),
  KEY `FK_node_awal` (`id_node_awal`),
  KEY `FK_node_akhir` (`id_node_akhir`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

/*Data for the table `jarak_antar_pelabuhan` */

insert  into `jarak_antar_pelabuhan`(`id_jarak`,`id_node_awal`,`id_node_akhir`,`jarak`) values (1,1,2,1036),(2,1,3,2019),(3,1,4,196),(4,1,5,1564),(5,1,6,1708),(6,1,7,2176),(7,1,8,3612),(8,1,9,3705),(9,1,10,4817),(10,2,1,1036),(11,2,3,995),(12,2,4,844),(13,2,5,1181),(14,2,6,1995),(15,2,7,1161),(16,2,8,2590),(17,2,9,3235),(18,2,10,3793),(19,3,1,2019),(20,3,2,995),(21,3,4,1829),(22,3,5,2166),(23,3,6,1936),(24,3,7,959),(25,3,8,1403),(26,3,9,2018),(27,3,10,2602),(28,4,1,196),(29,4,2,844),(30,4,3,1829),(31,4,5,1375),(32,4,6,1627),(33,4,7,1989),(34,4,8,3424),(35,4,9,4045),(36,4,10,4629),(37,5,1,1564),(38,5,2,1181),(39,5,3,2166),(40,5,4,1375),(41,5,6,2887),(42,5,7,1757),(43,5,8,3480),(44,5,9,4101),(45,5,10,4685),(46,6,1,1708),(47,6,2,1995),(48,6,3,1936),(49,6,4,1627),(50,6,5,2887),(51,6,7,3168),(52,6,8,597),(53,6,9,1219),(54,6,10,1803),(55,7,1,2178),(56,7,2,1161),(57,7,3,959),(58,7,4,1989),(59,7,5,1757),(60,7,6,3168),(61,7,8,908),(62,7,9,1523),(63,7,10,2107),(64,8,1,3612),(65,8,2,2590),(66,8,3,1403),(67,8,4,3424),(68,8,5,3480),(69,8,6,597),(70,8,7,908),(71,8,9,623),(72,8,10,1207),(73,9,1,3705),(74,9,2,3235),(75,9,3,2018),(76,9,4,4045),(77,9,5,4101),(78,9,6,1219),(79,9,7,1523),(80,9,8,623),(81,9,10,797),(82,10,1,4817),(83,10,2,3793),(84,10,3,2602),(85,10,4,4629),(86,10,5,4685),(87,10,6,1803),(88,10,7,2107),(89,10,8,1207),(90,10,9,797),(91,1,1,0),(92,2,2,0),(93,3,3,0),(94,4,4,0),(95,5,5,0),(96,6,6,0),(97,7,7,0),(98,8,8,0),(99,9,9,0),(100,10,10,0);

/*Table structure for table `nama_pelabuhan` */

DROP TABLE IF EXISTS `nama_pelabuhan`;

CREATE TABLE `nama_pelabuhan` (
  `id_pelabuhan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelabuhan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_pelabuhan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `nama_pelabuhan` */

insert  into `nama_pelabuhan`(`id_pelabuhan`,`nama_pelabuhan`) values (1,'Benoa'),(2,'Makassar'),(3,'Kendari'),(4,'Lembar Mataram'),(5,'Tenau Kupang'),(6,'Ternate'),(7,'Ambon'),(8,'Sorong'),(9,'Biak'),(10,'Jayapura');

/*Table structure for table `jarak` */

DROP TABLE IF EXISTS `jarak`;

/*!50001 DROP VIEW IF EXISTS `jarak` */;
/*!50001 DROP TABLE IF EXISTS `jarak` */;

/*!50001 CREATE TABLE  `jarak`(
 `id` int(11) ,
 `node_awal` varchar(165) ,
 `node_akhir` varchar(165) ,
 `jarak` float 
)*/;

/*View structure for view jarak */

/*!50001 DROP TABLE IF EXISTS `jarak` */;
/*!50001 DROP VIEW IF EXISTS `jarak` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jarak` AS (select `jarak_pelabuhan`.`id_jarak` AS `id`,concat('(',`awal`.`id_pelabuhan`,')  ',`awal`.`nama_pelabuhan`) AS `node_awal`,concat('(',`akhir`.`id_pelabuhan`,')  ',`akhir`.`nama_pelabuhan`) AS `node_akhir`,`jarak_pelabuhan`.`jarak` AS `jarak` from ((`jarak_antar_pelabuhan` `jarak_pelabuhan` left join `nama_pelabuhan` `awal` on((`awal`.`id_pelabuhan` = `jarak_pelabuhan`.`id_node_awal`))) left join `nama_pelabuhan` `akhir` on((`akhir`.`id_pelabuhan` = `jarak_pelabuhan`.`id_node_akhir`))) order by `jarak_pelabuhan`.`id_jarak`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
