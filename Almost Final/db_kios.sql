-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: db_kios
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,3,4,15000),(2,2,3,2,15000),(3,2,5,2,18000);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `total_amount` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Diproses',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,'Fan','Jl. Jenderal Sudirman, Gang Dharma IV no.8, Sayang-sayang',60000,'COD','Selesai','2025-06-22 06:12:34'),(2,5,'Fan','Jl. Jenderal Sudirman, Gang Dharma IV no.8, Sayang-sayang',66000,'COD','Dibatalkan','2025-06-22 06:30:40');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT 'Assets/download.jpeg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Indomilk 250g','Deskripsi singkat mengenai produk Indomilk 250g. Menjelaskan keunggulan, rasa, dan nilai gizi.',7000,150,'Minuman','Assets/indomilk800g.jpg','2025-06-21 06:09:45'),(2,'Beras Rojolele 5kg','Beras pulen berkualitas tinggi dari padi pilihan, cocok untuk makan keluarga sehari-hari.',68000,78,'Kebutuhan Dapur','Assets/rojolele5kg.jpeg','2025-06-21 06:09:45'),(3,'Minyak Goreng 1L','Minyak goreng kelapa sawit, jernih dan berkualitas, membuat masakan lebih renyah.',15000,120,'Kebutuhan Dapur','Assets/sunco1l.jpg','2025-06-21 06:09:45'),(4,'Sabun Mandi Lifebuoy','Sabun mandi anti-bakteri untuk melindungi keluarga dari kuman penyebab penyakit. Wangi segar dan tahan lama.',4500,200,'Personal Care','Assets/lifebuoy.jpg','2025-06-21 06:09:45'),(5,'Deterjen Rinso 800g','Deterjen bubuk dengan teknologi penghilang noda, membuat pakaian bersih cemerlang tanpa merusak kain.',18000,95,'Kebutuhan Rumah','Assets/rinso800g.jpg','2025-06-21 06:09:45'),(6,'Susu Bayi SGM 400g','Susu formula untuk pertumbuhan bayi usia 0-6 bulan, dengan nutrisi lengkap.',55000,50,'Kebutuhan Ibu & Anak','Assets/sgm400g.jpg','2025-06-21 06:09:45'),(7,'Mie Instan Indomie Goreng','Indomie Goreng rasa original, cepat dan mudah disajikan.',3000,200,'Makanan','Assets/indomiegoreng.jpeg','2025-06-22 07:57:00'),(8,'Sarden ABC Saus Tomat 155g','Ikan sarden dalam saus tomat berkualitas, kaya akan omega 3.',9500,100,'Makanan','Assets/sardenabctomat155g.jpeg','2025-06-22 07:57:00'),(9,'Kecap Manis Bango 275ml','Kecap manis dibuat dari kedelai hitam malika pilihan.',18000,150,'Makanan','Assets/bango275ml.jpeg','2025-06-22 07:57:00'),(10,'Biskuit Roma Kelapa 300g','Biskuit renyah dengan rasa kelapa asli, nikmat untuk teman minum teh.',8000,120,'Makanan','Assets/roma300g.jpeg','2025-06-22 07:57:00'),(11,'Teh Celup Sariwangi isi 25','Teh celup asli Indonesia, aroma dan rasa yang menyegarkan.',6000,300,'Minuman','Assets/sariwangi25.jpeg','2025-06-22 07:57:00'),(12,'Kopi Kapal Api Special 165g','Bubuk kopi hitam dari biji kopi pilihan, aroma mantap.',13000,180,'Minuman','Assets/kapalapispecial165g.jpeg','2025-06-22 07:57:00'),(13,'Air Mineral Aqua 600ml','Air mineral murni dari sumber mata air pegunungan terpilih.',3500,500,'Minuman','Assets/aqua600ml.jpeg','2025-06-22 07:57:00'),(14,'Garam Meja Refina 500g','Garam beryodium halus dan putih, membuat masakan lebih gurih.',5000,250,'Kebutuhan Dapur','Assets/refina500g.jpeg','2025-06-22 07:57:00'),(15,'Penyedap Rasa Royco Sapi 100g','Bumbu penyedap rasa sapi untuk melezatkan berbagai masakan.',4000,400,'Kebutuhan Dapur','Assets/roycosapi100g.jpeg','2025-06-22 07:57:00'),(16,'Pasta Gigi Pepsodent 190g','Pasta gigi pencegah gigi berlubang dengan mikro kalsium aktif.',12000,160,'Personal Care','Assets/pepsodent190g.jpeg','2025-06-22 07:57:00'),(17,'Pantene Anti Lepek 135ml','Shampo dengan formula pro-v untuk rambut kuat dan bebas lepek.',22000,90,'Personal Care','Assets/pantene135ml.jpeg','2025-06-22 07:57:00'),(18,'Rexona Ice Cool 45ml','Deodorant roll-on dengan sensasi dingin dan perlindungan 48 jam.',17000,110,'Personal Care','Assets/rexonamenicecool45ml.jpeg','2025-06-22 07:57:00'),(19,'Super Pell 770ml','Cairan pembersih lantai dengan wangi segar yang tahan lama.',11000,130,'Kebutuhan Rumah','Assets/superpell770ml.jpeg','2025-06-22 07:57:00'),(20,'Sunlight 750ml','Sabun cuci piring dengan kekuatan 100 jeruk nipis.',14000,200,'Kebutuhan Rumah','Assets/sunlight.jpeg','2025-06-22 07:57:00'),(21,'Tisu Wajah Paseo 250 sheet','Tisu lembut dan higienis untuk kebutuhan keluarga.',15000,180,'Kebutuhan Rumah','Assets/paseo250sheet.jpeg','2025-06-22 07:57:00'),(22,'Mamy Poko Pants L30','Popok celana dengan daya serap tinggi, nyaman untuk si kecil.',58000,70,'Kebutuhan Ibu & Anak','Assets/mamypokol30.jpeg','2025-06-22 07:57:00'),(23,'Minyak Telon My Baby 90ml','Minyak telon untuk menghangatkan tubuh bayi dan mencegah kembung.',25000,100,'Kebutuhan Ibu & Anak','Assets/mybaby90ml.jpeg','2025-06-22 07:57:00'),(24,'Johnson Baby Powder 200g','Bedak bayi lembut yang teruji klinis, aman untuk kulit bayi.',19000,150,'Kebutuhan Ibu & Anak','Assets/johnsonbabypowder200g.jpeg','2025-06-22 07:57:00'),(25,'Daging Ayam Fillet 500g','Dada ayam fillet segar tanpa tulang, beku dan higienis.',28000,60,'Produk Fresh dan Frozen','Assets/filletayam500g.jpeg','2025-06-22 07:57:00'),(26,'Nugget Ayam Fiesta 250g','Nugget ayam renyah dan lezat, favorit anak-anak.',24000,80,'Produk Fresh dan Frozen','Assets/nuggetayamfiesta500g.jpeg','2025-06-22 07:57:00'),(27,'Shoestring 500g','Potongan kentang beku siap goreng, praktis dan hemat waktu.',21000,90,'Produk Fresh dan Frozen','Assets/shoestring500g.jpeg','2025-06-22 07:57:00'),(28,'Telur Ayam Negeri 10 butir','Telur ayam segar pilihan dari peternakan lokal.',22000,50,'Produk Fresh dan Frozen','Assets/telurnegeri10.jpeg','2025-06-22 07:57:00'),(29,'Madu TJ Murni 150ml','Madu murni untuk menjaga daya tahan tubuh.',23000,100,'Kesehatan','Assets/madutj150ml.jpeg','2025-06-22 07:57:00'),(30,'Vitamin C IPI isi 45 tablet','Vitamin C dosis harian untuk menjaga imunitas.',7000,300,'Kesehatan','Assets/cipi45.jpeg','2025-06-22 07:57:00'),(31,'Obat Maag Promag 10 tablet','Obat untuk meredakan gejala sakit maag dan asam lambung.',8000,200,'Kesehatan','Assets/promag10.jpeg','2025-06-22 07:57:00'),(32,'Minyak Kayu Putih Cap Lang 60ml','Minyak kayu putih untuk meredakan perut kembung dan gatal.',19000,150,'Kesehatan','Assets/caplang60ml.jpeg','2025-06-22 07:57:00'),(33,'Baterai ABC Alkaline AA isi 4','Baterai alkaline untuk berbagai perangkat elektronik.',15000,100,'Lifestyle','Assets/abcaa4.jpeg','2025-06-22 07:57:00'),(34,'Lem Power Glue','Lem serbaguna dengan daya rekat super kuat.',5000,200,'Lifestyle','Assets/powerglue.jpeg','2025-06-22 07:57:00'),(35,'Payung Lipat Otomatis','Payung lipat praktis dengan tombol buka-tutup otomatis.',75000,50,'Lifestyle','Assets/payunglipat.jpeg','2025-06-22 07:57:00'),(36,'Sandal Jepit Swallow','Sandal jepit legendaris, nyaman dan tahan lama.',12000,300,'Lifestyle','Assets/swallow.jpeg','2025-06-22 07:57:00');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `rating` tinyint(1) NOT NULL COMMENT 'Rating dari 1 sampai 5',
  `comment` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'approved' COMMENT 'approved, pending, hidden',
  `review_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,7,5,'Fan',5,'😋🥰','approved','2025-06-22 14:44:59');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'pelanggan' COMMENT 'Peran pengguna: admin, kurir, pelanggan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Fan','saufan.ridho@gmail.com','085737736349','$2y$10$XsMQyrwK7FL43.HT1abP5eD2/y1cqn9OUyMIpJhOsGo9CyEhtKtvu','pelanggan'),(12,'adminA','adminA@gmail.com','085719283746','$2y$10$g6ks2dP8bLHvIHER4tpk8ulew0XTYh.zeak0vNtFVX0QZ.DUGVKIq','admin'),(13,'kurirA','kurirA@gmail.com','08192837465','$2y$10$4nhUkvBPf/M8NdhvK0W8JOX2hjSMgDUdCK9Cef6/hRtHEvxr.ROyO','kurir');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-22 23:06:13
