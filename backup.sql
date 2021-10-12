--
-- Table structure for table `book`
--
DROP 
  TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, 
  `img_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  `published_at` date NOT NULL, 
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL, 
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, 
  `is_reserved` tinyint(1) NOT NULL, 
  `is_favorite` tinyint(1) DEFAULT NULL, 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 12 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `book`
--
LOCK TABLES `book` WRITE;
INSERT INTO `book` 
VALUES 
  (
    4, 'La pénombre', 'resrrestest.png', 
    '2021-10-07 19:30:43', '1980-07-06', 
    'Quam amet nec dignissim vel pharetra. Quis consequat sed sed netus lectus tellus. In massa pharetra dui, velit vel. Malesuada hendrerit vitae id integer faucibus id. Convallis placerat odio ac dictum suscipit volutpat vulputate leo velit. \r\n\r\nAt egestas urna, placerat in. Tincidunt nunc feugiat est nibh est velit. Purus ipsum nisl imperdiet consectetur rutrum turpis convallis. Elementum egestas nunc porttitor id. Faucibus quis et eleifend convallis ornare dui euismod vitae. Id ut enim lectus massa id dolor. Amet porta at sed lectus in placerat tristique nec id.\r\n\r\nLectus dictum lorem a molestie nibh fermentum. Arcu urna lectus dignissim ut feugiat nibh feugiat quisque vitae. Lorem in rhoncus ut mattis purus porta nullam sodales. Massa augue pharetra, leo dui, gravida magna. Vel commodo, ante pharetra integer ipsum magnis dignissim.', 
    'George Dufaux', 1, 1
  ), 
  (
    8, 'la visibilité', 'resrrestest.png', 
    '2021-10-08 12:37:46', '1993-05-06', 
    'Paenitet me quod tu me rogas? Oh, sic, qui stultus plastic continentis rogavi te ut emas. Vides non manducare acidum hydrofluoric per plastic. Erit autem dissolvere metalli petram, vitrum, tellus. Ita quod illic \'. Quam de aliquo cum aliqua interdum, maybe? Aliquid viride, huh? Quam vos sunt etiam vivere?\r\n\r\nQuinquaginta septem est - pars tua, triginta quinque millia. Est autem extra plus quindecim, tota tua est, quom meruisset. Fac nos fecit. SIC. Puto quia una res potest - venimus in cognitionem. Vide pretium in maybe? Aliquid viride, huh? Quam vos sunt etiam vivere?\r\nQuam de aliquo cum aliqua interdum, maybe? Aliquid viride, huh? Quam vos sunt etiam vivere?\r\n\r\nQuinquaginta septem est - pars tua, triginta quinque millia. Est autem extra plus quindecim, tota tua est, quom meruisset. Fac nos fecit. SIC. Puto quia una res potest - venimus in cognitionem. Vide pretium in maybe? Aliquid viride, huh? Quam vos sunt etiam vivere?\r\nQuam de aliquo cum aliqua interdum, maybe? Aliquid viride, huh? Quam vos sunt etiam vivere?', 
    'George Dufaux', 1, 1
  );
UNLOCK TABLES;
--
-- Table structure for table `book_loan`
--
DROP 
  TABLE IF EXISTS `book_loan`;
CREATE TABLE `book_loan` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `book_id` int NOT NULL, 
  `user_id` int NOT NULL, 
  `date_loan` datetime DEFAULT NULL, 
  `date_return` datetime DEFAULT NULL, 
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, 
  `date_reserved` datetime NOT NULL, 
  `is_late` tinyint(1) NOT NULL, 
  PRIMARY KEY (`id`), 
  KEY `IDX_DC4E460B16A2B381` (`book_id`), 
  KEY `IDX_DC4E460BA76ED395` (`user_id`), 
  CONSTRAINT `FK_DC4E460B16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`), 
  CONSTRAINT `FK_DC4E460BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `book_loan`
--
LOCK TABLES `book_loan` WRITE;
INSERT INTO `book_loan` 
VALUES 
  (
    1, 4, 1, '2021-10-09 20:21:43', NULL, 
    'Emprunté', '2021-10-09 20:43:28', 
    0
  ), 
  (
    2, 8, 1, '2021-09-17 20:11:17', NULL, 
    'Emprunté', '2021-10-09 20:08:40', 
    1
  );
UNLOCK TABLES;
--
-- Table structure for table `book_type`
--
DROP 
  TABLE IF EXISTS `book_type`;
CREATE TABLE `book_type` (
  `book_id` int NOT NULL, 
  `type_id` int NOT NULL, 
  PRIMARY KEY (`book_id`, `type_id`), 
  KEY `IDX_95431C2116A2B381` (`book_id`), 
  KEY `IDX_95431C21C54C8C93` (`type_id`), 
  CONSTRAINT `FK_95431C2116A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE, 
  CONSTRAINT `FK_95431C21C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `book_type`
--
LOCK TABLES `book_type` WRITE;
INSERT INTO `book_type` 
VALUES 
  (4, 1), 
  (4, 3), 
  (8, 3);
UNLOCK TABLES;
--
-- Table structure for table `doctrine_migration_versions`
--
DROP 
  TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL, 
  `executed_at` datetime DEFAULT NULL, 
  `execution_time` int DEFAULT NULL, 
  PRIMARY KEY (`version`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8_unicode_ci;
--
-- Dumping data for table `doctrine_migration_versions`
--
LOCK TABLES `doctrine_migration_versions` WRITE;
INSERT INTO `doctrine_migration_versions` 
VALUES 
  (
    'DoctrineMigrations\\Version20211004213522', 
    '2021-10-04 21:35:44', 49
  ), 
  (
    'DoctrineMigrations\\Version20211004223502', 
    '2021-10-04 22:35:17', 189
  ), 
  (
    'DoctrineMigrations\\Version20211005162635', 
    '2021-10-05 16:26:49', 216
  ), 
  (
    'DoctrineMigrations\\Version20211005173620', 
    '2021-10-05 17:36:58', 141
  ), 
  (
    'DoctrineMigrations\\Version20211005175315', 
    '2021-10-05 17:54:03', 224
  ), 
  (
    'DoctrineMigrations\\Version20211006122945', 
    '2021-10-06 12:32:45', 271
  ), 
  (
    'DoctrineMigrations\\Version20211009184200', 
    '2021-10-09 18:43:28', 300
  ), 
  (
    'DoctrineMigrations\\Version20211009214154', 
    '2021-10-09 21:42:00', 152
  );
UNLOCK TABLES;
--
-- Table structure for table `type`
--
DROP 
  TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 29 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `type`
--
LOCK TABLES `type` WRITE;
INSERT INTO `type` 
VALUES 
  (1, 'classique'), 
  (2, 'roman'), 
  (3, 'polar');
UNLOCK TABLES;
--
-- Table structure for table `user`
--
DROP 
  TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL, 
  `roles` json NOT NULL, 
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, 
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, 
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL, 
  `date_birth` date NOT NULL, 
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL, 
  `is_confirmed` tinyint(1) NOT NULL, 
  `date_inscription` datetime NOT NULL, 
  PRIMARY KEY (`id`), 
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE = InnoDB AUTO_INCREMENT = 20 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `user`
--
LOCK TABLES `user` WRITE;
INSERT INTO `user` 
VALUES 
  (
    1, 'isabelle.garnier@la-reserve.com', 
    '[\"ROLE_ADMIN\"]', '$2y$13$dPmGPIj7W8cjBkEJLMnUa.GRQLYOzM/rgLsq.LmPNje3YmgQYEJ7G', 
    'Isabelle', 'Garnier', '1973-07-05', 
    '8 avenue Calypso\r\n34000 Curreau-sur-Seine', 
    0, '2021-10-06 14:32:45'
  ), 
  (
    19, 'dwight.schrute@la-reserve.com', 
    '[\"ROLE_EMPLOYE\"]', '$2y$13$WHBGpTNleoZ20w7hKPHcq.ZdM2wkJ.YY2Gpmd07TQX81e2Co8HvAO', 
    'Dwight', 'Schrute', '1993-05-06', 
    '8 avenue Calypso\r\n34110 VIC LA GARDIOLE', 
    1, '2021-10-09 00:04:59'
  );
UNLOCK TABLES;
