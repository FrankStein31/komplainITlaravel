/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.27-MariaDB : Database - komplain
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`komplain` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `komplain`;

/*Table structure for table `pengaduans` */

DROP TABLE IF EXISTS `pengaduans`;

CREATE TABLE `pengaduans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_nik` varchar(255) NOT NULL,
  `id_petugas` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `jenis_pengaduan` text NOT NULL,
  `prioritas` int(11) DEFAULT 1,
  `status` varchar(255) NOT NULL DEFAULT 'Belum di Proses',
  `rating` int(11) DEFAULT NULL,
  `responsivitas` int(11) DEFAULT NULL,
  `komunikasi` int(11) DEFAULT NULL,
  `sikap` int(11) DEFAULT NULL,
  `waktu` int(11) DEFAULT NULL,
  `pemahaman` int(11) DEFAULT NULL,
  `desc_rating` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pengaduans` */

insert  into `pengaduans`(`id`,`user_nik`,`id_petugas`,`name`,`user_id`,`description`,`image`,`jenis_pengaduan`,`prioritas`,`status`,`rating`,`responsivitas`,`komunikasi`,`sikap`,`waktu`,`pemahaman`,`desc_rating`,`deleted_at`,`created_at`,`updated_at`) values 
(4,'312','14','Frankie',2,'safnavbaoidsvhba','assets/laporan/v7nMOFD2EQO1jYphB0mpQyo0hOdWauyfpYpsybZ7.jpg','Aplikasi',NULL,'Selesai',5,3,2,4,4,3,NULL,NULL,'2024-03-09 15:54:23','2024-07-01 11:48:48'),
(5,'312','16','Frankie',2,'haii coafoasjfbiaf','assets/laporan/RWAzFN5Wp9bfNZWB2FiM6zqoeFMDvU59eUKlJR3n.jpg','Jaringan',NULL,'Selesai',4,0,3,0,2,0,NULL,NULL,'2024-03-09 17:46:39','2024-07-01 11:48:59'),
(6,'456','4','Steinlie',3,'saya tidak bisa login','assets/laporan/AjfZdwmR4K7sH90GYsuvQuWDUhmPt3xTqDyFvKqm.jpg','Aplikasi',NULL,'Selesai',3,2,0,4,0,5,NULL,NULL,'2024-03-09 18:11:09','2024-07-01 11:49:18'),
(7,'456','6','Steinlie',3,'printer saya tintanya habis','assets/laporan/QHVVvH0aF6tSAyF9Jbh8syvL0xYH2G4quArTKLie.jpg','Perangkat',NULL,'Selesai',5,3,3,2,0,0,NULL,NULL,'2024-03-09 18:11:29','2024-07-01 11:49:28'),
(8,'456','4','Steinlie',3,'coba lagi baru','assets/laporan/UTZ7qOQES8mVx8zRd7Deqhskbjt1ZeEdLLLlb0wP.jpg','Aplikasi',NULL,'Selesai',3,0,2,0,4,5,NULL,NULL,'2024-03-10 09:37:23','2024-07-01 11:49:40'),
(9,'312','17','Frankie',2,'jaringan saya bermasalah','assets/laporan/NFeZtWfvx8q7CoRFGJXdgQLMbpaWl9P1jIC0i77q.jpg','Jaringan',NULL,'Selesai',5,0,0,1,1,3,NULL,NULL,'2024-03-10 11:02:52','2024-07-04 11:10:06'),
(11,'312','19','Frankie',2,'PC saya tidak bisa menyala\r\n','assets/laporan/qatpajnhbjb9Fs6uKAmk97DG4Jvouv2mnXGs7uFk.jpg','Perangkat',NULL,'Selesai',5,5,5,3,2,3,'sangat memuaskan',NULL,'2024-03-14 13:18:37','2024-06-30 20:47:16'),
(18,'54321','18','Frankie Steinlie',13,'Perangkat saya bermasalah','assets/laporan/1719372106.jpeg','Perangkat',NULL,'Selesai',5,0,1,4,0,0,NULL,NULL,'2024-06-26 10:21:46','2024-06-30 20:46:58'),
(19,'312','5','Frankie',2,'jaringan rusak','assets/laporan/1719372569.jpeg','Jaringan',0,'Selesai',4,3,0,2,3,0,NULL,NULL,'2024-06-26 10:29:29','2024-07-01 11:54:47'),
(20,'312','19','Frankie',2,'coba prioritas','assets/laporan/9ePv4DZ9Z3r8XvoLmeW7WadC24KtuAOm5yKc7Sfc.jpg','Perangkat',0,'Selesai',5,3,5,0,3,0,'Mantabbbbb',NULL,'2024-06-27 11:42:45','2024-06-29 17:54:14'),
(21,'54321','15','Frankie Steinlie',13,'aplikasi saya bermasalah','assets/laporan/1719574118.jpeg','Aplikasi',0,'Selesai',5,0,2,5,0,2,'memuaskann, terima kasih',NULL,'2024-06-28 18:28:38','2024-07-04 07:30:28'),
(22,'312','16','Frankie',2,'cobaaaaaa','assets/laporan/orOX0ZAFyRmUzrPddanyENQvzAGY3zZd8fizQwXQ.jpg','Jaringan',0,'Selesai',5,4,4,5,4,3,'Terima kasihhh',NULL,'2024-07-01 11:57:41','2024-07-02 14:05:47'),
(23,'54321','17','Frankie Steinlie',13,'jaringan rusak boi','assets/laporan/1hdvir3cIy2yL2aFlikFdq1gtO4rQUeY3CSPNR4R.png','Jaringan',0,'Selesai',3,4,2,5,4,5,'mantabb banget',NULL,'2024-07-02 14:56:48','2024-07-04 11:05:10'),
(24,'456','16','Steinlie',3,'Rusak','assets/laporan/XWMP29w6ZLRrIrHXo7MDcnED5erzIzdfzsP5wXYZ.jpg','Jaringan',0,'Selesai',4,4,2,0,0,0,'bagus',NULL,'2024-07-02 14:58:48','2024-07-03 15:33:26');

/*Table structure for table `tanggapans` */

DROP TABLE IF EXISTS `tanggapans`;

CREATE TABLE `tanggapans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pengaduan_id` int(11) NOT NULL,
  `tanggapan` varchar(255) NOT NULL,
  `petugas_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tanggapans` */

insert  into `tanggapans`(`id`,`pengaduan_id`,`tanggapan`,`petugas_id`,`created_at`,`updated_at`) values 
(1,4,'hai',1,'2024-03-09 16:39:03','2024-03-09 16:39:03'),
(2,4,'doneeee',1,'2024-03-09 16:39:20','2024-03-09 16:39:20'),
(3,5,'halooo',1,'2024-03-09 17:21:54','2024-03-09 17:21:54'),
(4,5,'lagi',1,'2024-03-09 17:44:28','2024-03-09 17:44:28'),
(5,5,'ini percobaan tanggapan, yuk bisa tuk tampilll, udah jam berapa ini',1,'2024-03-09 18:01:14','2024-03-09 18:01:14'),
(6,5,'Lagi yaa',1,'2024-03-09 18:01:42','2024-03-09 18:01:42'),
(7,5,'yuk bisa yuk',1,'2024-03-09 18:02:03','2024-03-09 18:02:03'),
(8,5,'Selesaiiii',1,'2024-03-09 18:02:21','2024-03-09 18:02:21'),
(9,5,'doneee',1,'2024-03-09 18:02:32','2024-03-09 18:02:32'),
(10,4,'pada suatau hari tanpa semgnagajfcna aofjnaacjav',1,'2024-03-09 18:03:11','2024-03-09 18:03:11'),
(11,7,'Segera otw kesana',1,'2024-03-09 18:12:56','2024-03-09 18:12:56'),
(12,6,'coba login dengan email dan password ini',1,'2024-03-09 18:13:19','2024-03-09 18:13:19'),
(13,8,'siap bang',4,'2024-03-10 11:00:45','2024-03-10 11:00:45'),
(14,5,'mantap kawan',5,'2024-03-10 11:01:22','2024-03-10 11:01:22'),
(15,7,'selesaiii',6,'2024-03-10 11:02:08','2024-03-10 11:02:08'),
(16,10,'coba silahkan cek hddnya, restart dan login ulang',6,'2024-03-11 11:55:40','2024-03-11 11:55:40'),
(17,8,'selesai kawan',4,'2024-03-11 11:56:20','2024-03-11 11:56:20'),
(18,6,'selesai kawan',4,'2024-03-11 11:56:31','2024-03-11 11:56:31'),
(19,9,'oke done ya',5,'2024-03-11 11:57:05','2024-03-11 11:57:05'),
(20,9,'selesai kawankuu',5,'2024-03-11 11:57:17','2024-03-11 11:57:17'),
(21,10,'sudah selesai yaa',6,'2024-03-11 12:11:32','2024-03-11 12:11:32'),
(22,11,'otw bang',6,'2024-03-14 13:20:22','2024-03-14 13:20:22'),
(23,11,'selesai ya',6,'2024-03-14 13:20:43','2024-03-14 13:20:43'),
(24,11,'mantab',1,'2024-03-14 13:22:15','2024-03-14 13:22:15'),
(25,12,'baik saya segera kesana',6,'2024-06-22 10:35:17','2024-06-22 10:35:17'),
(26,12,'Proses selesaiii',6,'2024-06-22 10:35:58','2024-06-22 10:35:58'),
(27,14,'Baik segera diproses',6,'2024-06-24 09:15:45','2024-06-24 09:15:45'),
(28,14,'selesai, terima kasih',6,'2024-06-24 09:16:30','2024-06-24 09:16:30'),
(29,18,'baik segera diproses',1,'2024-06-26 10:24:24','2024-06-26 10:24:24'),
(30,18,'proses selesai',1,'2024-06-26 10:26:00','2024-06-26 10:26:00'),
(32,19,'okeeee',17,'2024-06-28 16:34:12','2024-06-28 16:34:12'),
(33,20,'siap laksanakan',18,'2024-06-28 17:00:53','2024-06-28 17:00:53'),
(34,19,'coba',1,'2024-06-28 17:32:53','2024-06-28 17:32:53'),
(35,20,'selesai',1,'2024-06-28 17:51:37','2024-06-28 17:51:37'),
(36,19,'selesai',1,'2024-06-28 17:51:54','2024-06-28 17:51:54'),
(37,20,'coba',1,'2024-06-28 17:52:13','2024-06-28 17:52:13'),
(38,19,'woke',1,'2024-06-28 18:06:09','2024-06-28 18:06:09'),
(39,19,'doneee',1,'2024-06-28 18:11:57','2024-06-28 18:11:57'),
(40,19,'cobaaa',1,'2024-06-28 18:12:42','2024-06-28 18:12:42'),
(41,19,'selesai yakk',5,'2024-06-28 18:13:28','2024-06-28 18:13:28'),
(42,20,'done',1,'2024-06-28 18:16:41','2024-06-28 18:16:41'),
(43,19,'doneeee',1,'2024-06-28 18:17:52','2024-06-28 18:17:52'),
(44,20,'coba',1,'2024-06-28 18:31:54','2024-06-28 18:31:54'),
(45,20,'selesai',1,'2024-06-28 18:32:28','2024-06-28 18:32:28'),
(46,21,'baik segera diatasi',14,'2024-06-28 18:34:13','2024-06-28 18:34:13'),
(47,21,'selesai ya',14,'2024-06-28 18:34:46','2024-06-28 18:34:46'),
(48,22,'okeee, diproses',16,'2024-07-02 13:52:20','2024-07-02 13:52:20'),
(49,22,'selesai yaaa',16,'2024-07-02 14:05:21','2024-07-02 14:05:21'),
(50,24,'oke otw yaa',5,'2024-07-02 15:02:26','2024-07-02 15:02:26'),
(51,24,'doneee',5,'2024-07-02 15:03:03','2024-07-02 15:03:03'),
(52,23,'siap laksanakan',17,'2024-07-02 15:05:14','2024-07-02 15:05:14'),
(53,23,'ternayata masih mau ganti kabel',17,'2024-07-02 15:05:42','2024-07-02 15:05:42'),
(54,23,'oke sudah selesai ya',17,'2024-07-02 15:05:58','2024-07-02 15:05:58');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `roles` varchar(255) NOT NULL DEFAULT 'USER',
  `bidang` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nik_unique` (`nik`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nik`,`name`,`email`,`phone`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`,`roles`,`bidang`,`token`) values 
(1,'123','Kepala Bidang IT','admin@gmail.com','+628883866931',NULL,'$2y$10$RuPOLZiujzaILiwO9kauJOZrvVdC4eWPo0rFMe3W.7JiEXZMW3B0i',NULL,'2024-03-09 15:14:04','2024-03-09 15:14:04','ADMIN',NULL,NULL),
(2,'312','Frankie','frankie@gmail.com','+628883866931',NULL,'$2y$10$9ez4pKoTQbSyAZh4Vf9HL.LAJ/w.39C5bnSUXsgDB4DwEnW7jh9Ju',NULL,'2024-03-09 15:15:00','2024-03-09 15:15:00','USER',NULL,'f22c4a22db122274f91d584c5c1a555d0c75bb083c2990f2c3c3cb36454cd669'),
(3,'456','Steinlie','steinlie@gmail.com','+628883866931',NULL,'$2y$10$WZyN327xHh9hJkJ/pNcXium9gIEp0x2f905/QKGB99HhlW28vwVH6',NULL,'2024-03-09 18:10:51','2024-03-09 18:10:51','USER',NULL,'2fadc6268ff9dee80faa1d1e3f512cb390556a58fb967a1361764d7122404cd1'),
(4,'100','Andi-PetugasAplikasi','aplikasi@gmail.com','+628883866931',NULL,'$2y$10$CcGR2488/YcYQEW2QqtAfOmYDR5O2hnSkYu6mZM/iAl1n4naV9zi2',NULL,'2024-03-09 18:14:23','2024-03-09 18:14:23','PETUGAS','Aplikasi',NULL),
(5,'200','Muhson-PetugasJaringan','jaringan@gmail.com','+628883866931',NULL,'$2y$10$jMlDxfBtPgzDR2d6Oe5ZVOtQh02yZ8danvbSNCImnznPCSm8gD0TK',NULL,'2024-03-10 10:06:46','2024-03-10 10:06:46','PETUGAS','Jaringan',NULL),
(6,'300','Agus-PetugasPerangkat','perangkat@gmail.com','+628883866931',NULL,'$2y$10$W3KOmOohcvmtEwNJ/n8TKuB13hgQuYMh7brNucL.zvGBkPsO3ST6m',NULL,'2024-03-10 10:08:23','2024-03-10 10:08:23','PETUGAS','Perangkat',NULL),
(7,'444','Frank','frank@gmail.com','08883866931',NULL,'$2y$10$../hrhOqeAdZ4LUu91qsfeov0CMizFkSlE4HzGmRAVjf.E0tmXeCq',NULL,'2024-03-11 11:53:23','2024-03-11 11:53:23','USER',NULL,'821cacc7a7d96acd83f17a2652d3431e827001d54bdf3f575a505c7c671c066e'),
(13,'54321','Frankie Steinlie','fs@gmail.com','08883866931',NULL,'$2y$10$aLr1rCVxsXo3IRvINJgIWO6tk0RguFJ9BcDiGforv.7KRoWrEwtza',NULL,NULL,NULL,'USER',NULL,'372df7e6b2451a0c81dfc0c89fec8677738c31473b196f9d2d655d3ed497e101'),
(14,'101','Joko-PetugasAplikasi','aplikasi2@gmail.com','08883866931',NULL,'$2y$10$dNOjrqbxC6uN22L0erKrquAoAkpTPQF.ZTdDWiGBTZaFeyA/GxY.i',NULL,'2024-06-27 10:16:40','2024-06-27 10:16:40','PETUGAS','Aplikasi',NULL),
(15,'102','Ganang-PetugasAplikasi','aplikasi3@gmail.com','08883866931',NULL,'$2y$10$FjAKjl4AmayOXA13sPZra.8baHp1oUj6DUCMnm3r2dgHQ2wtjXFFO',NULL,'2024-06-27 10:17:28','2024-06-27 10:17:28','PETUGAS','Aplikasi',NULL),
(16,'201','Ilham-PetugasJaringan','jaringan2@gmail.com','08883866931',NULL,'$2y$10$QfrEd0muiptGXgCfPy41/eS0CcMSm68p8zeCOPbqZ98LnnCaFtoDu',NULL,'2024-06-27 10:19:17','2024-06-27 10:19:17','PETUGAS','Jaringan',NULL),
(17,'202','Anwar-PetugasJaringan','jaringan3@gmail.com','08883866931',NULL,'$2y$10$kpjSzhf.mTqOaoRjwxDpnO9sfhuz60euhptGrZSvzUo0ps8aQAjwi',NULL,'2024-06-27 10:20:03','2024-06-27 10:20:03','PETUGAS','Jaringan',NULL),
(18,'301','Gilang-PetugasPerangkat','perangkat2@gmail.com','08883866931',NULL,'$2y$10$HYrOM3v97U4SucFZqOzA5uzxFMlFDIoEGKwkSB2TD8rqPjQp.i04O',NULL,'2024-06-27 10:25:41','2024-06-27 10:25:41','PETUGAS','Perangkat',NULL),
(19,'302','Dodik-PetugasPerangkat','perangkat3@gmail.com','08883866931',NULL,'$2y$10$G6i8vywhMt1vgoDC81k2xOyRj1vL1KeF1CAKQQ4WXiEaqtbb17sVy',NULL,'2024-06-27 10:26:33','2024-06-27 10:26:33','PETUGAS','Perangkat',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
