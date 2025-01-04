/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.40 : Database - db_bk
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_bk` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_bk`;

/*Table structure for table `daftar_poli` */

DROP TABLE IF EXISTS `daftar_poli`;

CREATE TABLE `daftar_poli` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pasien` INT(11) NOT NULL,
  `id_jadwal` INT(11) NOT NULL,
  `keluhan` TEXT NOT NULL,
  `no_antrian` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


/*Table structure for table `detail_periksa` */

DROP TABLE IF EXISTS `detail_periksa`;

CREATE TABLE `detail_periksa` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_periksa` INT(11) NOT NULL,
  `id_obat` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `dokter` */

DROP TABLE IF EXISTS `dokter`;

CREATE TABLE `dokter` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(150) NOT NULL,
  `alamat` VARCHAR(255) DEFAULT NULL,
  `no_hp` INT(10) UNSIGNED NOT NULL,
  `id_poli` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_poli` (`id_poli`),
  CONSTRAINT `tabel dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `tabel poli` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `jadwal_periksa` */

DROP TABLE IF EXISTS `jadwal_periksa`;

CREATE TABLE `jadwal_periksa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_dokter` INT NOT NULL,
  `hari` VARCHAR(10) NOT NULL,
  `jam_mulai` TIME NOT NULL,
  `jam_selesai` TIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_dokter` (`id_dokter`),
  CONSTRAINT `jadwal_periksa_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `obat` */

DROP TABLE IF EXISTS `obat`;

CREATE TABLE `obat` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nama_obat` VARCHAR(50) NOT NULL,
  `kemasan` VARCHAR(35) DEFAULT NULL,
  `harga` INT UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `pasien` */

DROP TABLE IF EXISTS `pasien`;

CREATE TABLE `pasien` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(150) NOT NULL,
  `alamat` VARCHAR(255) NOT NULL,
  `no_ktp` INT UNSIGNED NOT NULL,
  `no_hp` INT UNSIGNED NOT NULL,
  `no_rm` CHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `periksa` */

DROP TABLE IF EXISTS `periksa`;

CREATE TABLE `periksa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_daftar_poli` INT NOT NULL,
  `tgl_periksa` DATE NOT NULL,
  `catatan` TEXT NOT NULL,
  `biaya_periksa` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_daftar_poli` (`id_daftar_poli`),
  CONSTRAINT `periksa_ibfk_1` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `poli` */

DROP TABLE IF EXISTS `poli`;

CREATE TABLE `poli` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nama_poli` VARCHAR(25) NOT NULL,
  `keterangan` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
