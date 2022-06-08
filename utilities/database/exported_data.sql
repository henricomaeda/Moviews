CREATE DATABASE  IF NOT EXISTS `moviews` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `moviews`;
-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: moviews
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_genre` varchar(20) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Ação'),(2,'Drama'),(3,'Comédia'),(4,'Ficção científica'),(5,'Romance');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movies` (
  `mov_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mov_title` varchar(100) NOT NULL,
  `mov_description` text NOT NULL,
  `mov_image` varchar(200) DEFAULT NULL,
  `mov_trailer` varchar(100) DEFAULT NULL,
  `mov_length` int(11) DEFAULT NULL,
  `use_id` int(10) unsigned NOT NULL,
  `cat_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mov_id`),
  KEY `fk_movies_users1_idx` (`use_id`),
  KEY `fk_movies_categories1_idx` (`cat_id`),
  CONSTRAINT `fk_movies_categories1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movies_users1` FOREIGN KEY (`use_id`) REFERENCES `users` (`use_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (3,'Coraline e o Mundo Secreto','Enquanto explora sua nova casa à noite, a pequena Coraline descobre uma porta secreta que contém um mundo parecido com o dela, porém melhor em muitas maneiras. Todos têm botões no lugar dos olhos, os pais são carinhosos e os sonhos de Coraline viram realidade por lá.','2322f64e13823fa845de4d93614456f39f9ce4f5301e944a717b73673ac7d9413d77b425cbfb6595d91781f290a2026bd2a903a838f5f9e2d21ccedd.jpg','https://www.youtube.com/embed/m9bOpeuvNwY',100,3,4),(4,'Procurando Nemo','Em seu primeiro dia de aula, esquecendo os conselhos do pai superprotetor, Nemo é capturado por um mergulhador e acaba no aquário de um dentista. Enquanto Nemo tenta bolar um plano para escapar, seu pai cruza o oceano para resgatá-lo.','afb2c3e7583ce0e8167665f56aa18f7ceab97c807a58359794b642d8f196b79a116bfc7a998de845d5630b8490d35c1feef3429fd0d4333ebc9a35d2.jpg','https://www.youtube.com/embed/lJhvtAt_1Nk',100,3,3),(5,'Velozes e Furiosos','Brian O\'Conner é um policial que se infiltra no submundo dos rachas de rua para investigar uma série de furtos. Enquanto tenta ganhar o respeito e a confiança do líder Dom Toretto, ele corre o risco de ser desmascarado.','4d14134bb23c7eb353be72595c34c854eff971fa39c99036aac2ef3f249bf65ff5fb226b0d62abb6916f979aca1518bfb3b340dfb974581356594be5.jpg','https://www.youtube.com/embed/X-V1jcj2Zt8',106,4,1),(6,'10 Coisas que Eu Odeio em Você','Bianca Stratford é bonita e popular, mas não pode namorar antes de sua irmã mais velha. O problema é que nenhum garoto consegue chegar perto da irmã, Kat Stratford. Para resolver a situação, um rapaz interessado em Bianca suborna um amigo com passado misterioso para sair com Kat e, quem sabe, tentar conquistá-la.','857e686d891ee89e6604efe8cd5098f840ff1724ef0ed995263efebcba36b1654f9b35fbc2dacf2d63613099c165f0b5130d0aedc295e821f84ac061.jpg','https://www.youtube.com/embed/vH4aMfk6GLo',97,4,5),(7,'O Senhor dos Anéis','O Senhor dos Anéis é uma trilogia cinematográfica dirigida por Peter Jackson com base na obra-prima homónima de J. R. R. Tolkien.','74a193ac37989ed9a0930ab5b40c5ba17321ab5c390cb8fa2b19127927e3a9458eadb4f60c118e09aacac446e69b6e8e556e289b56efc7ea4ce1a794.jpg','https://www.youtube.com/embed/0i86oM1nHjM',178,5,4),(8,'Divertida Mente','Com a mudança para uma nova cidade, as emoções de Riley, que tem apenas 11 anos de idade, ficam extremamente agitadas. Uma confusão na sala de controle do seu cérebro deixa a Alegria e a Tristeza de fora, afetando a vida de Riley radicalmente.','6fdd646fcecbb862c5a3f9414a14666089976285219d5b4519006ef68230730e12ae5a96269d7be0766a6be6418b2f6202e64bd3fa1d7b1303b881a6.jpg','https://www.youtube.com/embed/LSpeM7G4zfY',95,5,3),(9,'The Saga of Tanya the Evil','The Saga of Tanya the Evil: The Movie é um filme de ação e fantasia japonês de 2019, baseado na série de light novels Youjo Senkil, pretende ser uma sequela da série de anime que foi ao ar em 2017. Foi lançado no Japão em 8 de fevereiro de 2019. O elenco e a equipe reprisaram seus papéis na série de anime.','30237af9956e7d046732efa47ab96697d1f115b586d3f95d49ea6d9eb5f6f7e981d324921c5fe73ba5fb24eb6855aa2d68e113a3a1b47fe2f8dc893c.jpg','https://www.youtube.com/embed/jTWkeiIMncI',115,6,1),(10,'Steins Gate Fuka Ryouiki no Deja vu','Steins; Gate: The Movie - Load Region de Déjà Vu é um filme de ficção científica japonês de 2013 produzido pela White Fox. É um acompanhamento da série de televisão de anime Steins; Gate de 2011, que foi baseada no videogame de mesmo nome e faz parte da franquia Science Adventure.','7f9be6e7e8aa06514b0120bc9acd93f7d423df9a3cdd89dbb24a8446e7a1d69a619ce6ec267db525cc6dfd709488e7e0644316b6a7ab6c9f1addf013.jpg','https://www.youtube.com/embed/kUkcQb-K3KU',90,6,4),(11,'Donnie Darko','Donnie é um jovem excêntrico que despreza a grande maioria de seus colegas de escola. Ele tem visões, em especial de Frank, um coelho gigante que só ele consegue ver e que o encoraja a fazer brincadeiras humilhantes com quem o cerca.','69ec4e21a5de6711677c566977db0af4bbed3d7fa49553017431e4a2490c9189c8876083313dcfb495df6d15d185f893a3db2eb294bb6af6b1ee105f.jpg','https://www.youtube.com/embed/bzLn8sYeM9o',113,7,4),(12,'Slender Man: Pesadelo sem Rosto','As amigas Wren, Hallie, Chloe e Katie levam uma vida entediante no colégio. Quando ouvem falar em um monstro chamado Slender Man, elas decidem invocá-lo por meio de um vídeo na Internet.','09e4e54efd473ff81b79c21aa7d9132714e6cccff21cc6af9fbbc2a8e88ce99bcf94d87f15d2a040cdb9f7dd945048fb7fc1a24eae44365afe8444d6.jpg','https://www.youtube.com/embed/ySy8mcceTno',100,7,2),(13,'League of Legends: More Than a Game','Sometimes a computer game is more than it seems. If you are not familiar with esports - the movie explains the phenomenon behind the League of Legends in an understandable and attractive way.','5c8d9e4a438c21ed6d77a4026b362a81fd08978c98ee380b457e6f0c8c90be57b7e9223912847460d4110d786cb5c8e9933a791cb14a8491f0e9e4ce.jpg','https://www.youtube.com/embed/Cxtgxty63qo',92,8,4),(14,'Matrix Resurrections','Da visionária realizadora Lana Wachowski chega-nos MATRIX RESURRECTIONS o tão aguardado 4º filme do inovador franchise que redefiniu o género. O novo filme reúne os protagonistas originais Keanu Reeves e Carrie-Anne Moss nos icónicos personagens que os tornaram famosos, Neo e Trinity.','e8502ff97a57a767e23e8fcc377ee92ee6870541fd8a489dbd15637b4d0cd6f518f22d838e9e0a5ff8ebead13ee779f04d04fa868afcaed7ab0f6668.jpg','https://www.youtube.com/embed/9ix7TUGVYIo',148,8,1),(15,'Halo','Os extraterrestres ameaçam a existência humana em um confronto épico do século 26.','5c77cefa65676561e22cbd45e59fbfc9b0dc0f78dfdef5e1cfc578c8096acae5935a5ffa4cd0fb48494963a1545fc745c32d0fcb9b028b8e6ffb14ce.jpg','https://www.youtube.com/embed/5KZ3MKraNKY',183,9,1),(16,'Projeto X - Uma Festa Fora de Controle','Três amigos de colégio planejam uma festa inesquecível que entrará para a história na tentativa de ficarem famosos. A notícia se espalha rapidamente e tudo foge ao controle quando os imprevistos começam a acontecer.','ea4d06a9ee0660e97b1dde1bd028eb4781da458720633b0379aed2ebac9ae6417b19c76bd51e07e3e3c68f2427f8cb3a516f36bf1be9827b944be748.jpg','https://www.youtube.com/embed/kFwGmQIe-rU',88,10,3),(17,'Como Se Fosse a Primeira Vez','Henry Roth é um veterinário paquerador, que vive no Havaí, e famoso pelo grande número de turistas que conquista. Seu novo alvo é Lucy Whitmore, que mora no local e por quem Henry se apaixona perdidamente.','16ffe525e4885faad8589692e537f077d763ae3bc8a97769e0a46795d3419da0c13be9a8483ecea5e41cb4c13ead8530c2a3a75fd716ed5ee87abeab.jpg','https://www.youtube.com/embed/PQZzJ3_MjA4',99,10,5),(18,'Minha Vida em Marte','Fernanda está casada com Tom, com quem tem uma filha de cinco anos, Joana. O casal está em meio ao desgaste causado pelo convívio de muitos anos, o que gera atritos constantes. Quem ajuda Fernanda a superar a crise é seu sócio Aníbal, parceiro inseparável durante a árdua jornada entre salvar o casamento ou colocar um fim nele.','2e9d164980de572dc40a8dbf67854725a2192312131e8d3209754a8c08e902d6eb91085b806c4f401746e3cbb48085687cdede23aafe865b11ff64cf.jpg','https://www.youtube.com/embed/mEbvVIE8cQ0',105,9,3),(19,'O Resgate do Soldado Ryan','Ao desembarcar na Normandia, no dia 6 de junho de 1944, o Capitão Miller recebe a missão de comandar um grupo do Segundo Batalhão para o resgate do soldado James Ryan, o caçula de quatro irmãos, dentre os quais três morreram em combate. Por ordens do chefe George C. Marshall, eles precisam procurar o soldado e garantir o seu retorno, com vida, para casa.','cdb4845b633eb8529705f53f1978f7d1e228e739b2cabb4b91dd8f763da32fa85f6758336215d0080b7b46816421536e340e9a0b6cd8e3580bd690f3.jpg','https://www.youtube.com/embed/WdHJ_nLRjIA',170,11,2),(20,'The Fallout','A estudante do Ensino Médio Vada tem que lidar com as consequências emocionais de uma tragédia escolar. Enquanto se reinventa, ela também reavalia seus relacionamentos.','e1e707eb53c18ee91a90947b115d72460b488f2111ec6671708c3dc331d541f0ec579268136baa9b85d1b8d4ff06395c98a87846e2ab1727c6e3731c.jpg','https://www.youtube.com/embed/hCBWOfCgRh4',92,11,2),(21,'Saidā no Yō ni Kotoba ga Wakiagaru','Um garoto que escreve poemas haikai e uma garota alegre se conhecem e passam um verão mágico juntos.','e7e02f9f1dca6c30d533b7aa886c2b2459c978eefef3969af08f21d1a5f8c3a93160e6399324f9ae18bcf4f96d4ad32f35791a6601f45ce7f4f486ad.jpg','https://www.youtube.com/embed/Sfu6cplThgQ',87,11,5),(22,'Olhos de gato','Nakitai Watashi wa Neko wo Kaburu é um filme de animé japonês de 2020 produzido pelo Studio Colorido, Toho Animation e Twin Engine. Dirigido por Junichi Sato e Tomotaka Shibayama, o filme foi lançado em 18 de junho de 2020 na Netflix em japonês.','205868ab6591bb314f9073af145c2d27fb5e3d2465bd61f9925f3df5408675845630f7def12a15db5bca47d23c8aeeb525221ac4fd0a0b5fa70bdf32.jpg','https://www.youtube.com/embed/S06TLB29FVE',104,3,5),(23,'Por Lugares Incríveis','Dois adolescentes que estão passando por momentos difíceis criam um forte laço quando embarcam em uma jornada transformadora para visitar as maravilhas do estado de Indiana, nos Estados Unidos.','d1d955a3b19cc4303012f56c0325f5335d544b02afe9b7a0d4fad30d5a9224807ed3242d089644142baa2ebb5783c0ecc47682af468b6199215a309a.jpg','https://www.youtube.com/embed/tdwLRHGQVG8',108,2,5),(24,'Alerta Vermelho','Um alerta vermelho da Interpol é emitido e o agente do FBI John Hartley assume o caso. Durante sua busca, ele se vê diante de um assalto ousado e é forçado a se aliar ao maior ladrão de arte da história, Nolan Booth, para capturar a ladra de arte mais procurada do mundo atualmente, Sarah Black.','7b44eea3352d256d9a646d8eb649aa22eac56f85740db70509529c18a6f1728b5fb2b11301f3ac3f9718743d7c70ab4c549c9fea2ae85fbe93f4ef1f.jpg','https://www.youtube.com/embed/5JQuYpBZarc',118,2,3),(25,'Parasita','Toda a família de Ki-taek está desempregada, vivendo em um porão sujo e apertado, mas uma obra do acaso faz com que ele comece a dar aulas de inglês a uma garota de família rica.','688931142002aca449f934b262f94e10262acced29c41b082ccc32609e0b805a7ed1a81cbc9a6de54b8fc0ed777f33bd79822e27a6b3e2ecb01ba8be.jpg','https://www.youtube.com/embed/m4jfE-TxC24',132,6,2),(26,'Adoráveis Mulheres','Nos anos seguintes à Guerra de Secessão, Jo March e suas duas irmãs voltam para casa quando Beth, a tímida irmã caçula, desenvolve uma doença devastadora que muda para sempre a vida delas.','6730f5e4a05e3666d027b3251c69c451b79d0d2f3c73a7a6c7ec85e416e03ecb10fe03c7a9ede4ce542be35ac7b4e543b3ad64d32ced03f40b638dbb.jpg','https://www.youtube.com/embed/7nc1GE_hnLs',135,6,2),(27,'Doutor Estranho no Multiverso da Loucura','O aguardado filme trata da jornada do Doutor Estranho rumo ao desconhecido. Além de receber ajuda de novos aliados místicos e outros já conhecidos do público, o personagem atravessa as realidades alternativas incompreensíveis e perigosas do Multiverso para enfrentar um novo e misterioso adversário.','3b9ee05347685a8521550ded46fa92ece25cc5562e73f5476cefc9434852f93735fcda1aca8e40c0b89baa3e48d9b6b29258e5c8c6fc31fced6e0efb.jpg','https://www.youtube.com/embed/X23XCFgdh2M',126,2,1);
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `rev_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rev_rating` int(11) NOT NULL,
  `rev_review` text NOT NULL,
  `use_id` int(10) unsigned NOT NULL,
  `mov_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rev_id`),
  KEY `fk_reviews_users1_idx` (`use_id`),
  KEY `fk_reviews_movies1_idx` (`mov_id`),
  CONSTRAINT `fk_reviews_movies1` FOREIGN KEY (`mov_id`) REFERENCES `movies` (`mov_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reviews_users1` FOREIGN KEY (`use_id`) REFERENCES `users` (`use_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (2,9,'Incrível, adorei as personagens!',2,26),(3,4,'Animação boa, mas acho o jogo muito violento ...',2,13),(4,10,'Amei as transições, veria de novo!',3,27),(5,8,'Esse filme precisa continuar ...',3,26),(6,6,'Não achei  o filme muito bom ...',4,27),(7,10,'Não acredito que era tudo uma mentira!',4,24),(8,7,'Interessante, bem elaborado os personagens!',5,13),(9,3,'Muito chato e repetitivo.',5,23),(10,10,'Muito bom o filme, o gato é bem misterioso!',6,3),(11,9,'Bem fofinho! ♥',6,21),(12,10,'Achei a trilogia bem interessante, a história foi bem desenvolvida!',7,7),(13,9,'(SPOILER) era ele o tempo todo ...',7,24),(14,8,'É o Pijas.',8,25),(15,10,'É o Pijas',8,5),(16,10,'Meu anime favorito, possui temas de viagem no tempo, muito interessante!',9,10),(17,7,'O anime é bem engraçado e dramático.',9,22),(18,10,'Meu filme favorito, assistiria 1000 vezes!!',10,6),(19,10,'Perfeito!',10,4),(20,10,'Muito bom o filme de ação ...',11,14),(21,9,'Muito bom e dá muito medo.',11,11),(22,10,'Filme relacionada a temporada de Youjo Senki, muito bem feita, as animações e os efeitos sonoros!',9,9),(23,9,'Excelente animação e mistério no gato.',9,3),(24,8,'Boas cinemáticas.',5,15),(25,8,'Amei a ideia de juntar esses protagonistas!',5,14),(26,5,'Boa a ideia, mas não se demonstrou capaz de realizá-la.',5,19),(27,6,'Bem criativo, mas não gostei muito ...',2,12),(28,8,'Valeu cada segundo do filme!',2,20),(29,10,'Amei a construção dos personagens e sua história!!',3,9),(30,8,'Engraçado e interessante!',3,16),(31,4,'Interessante ...',3,18),(32,9,'Excelente.',7,15),(33,9,'Excelente sequência de filmes!',9,5),(34,8,'Apresentou bem a ideia!',9,20),(35,5,'Me lembro dessa época, infelizmente o mesmo já se passou ...',11,12),(36,9,'Amei a história!',11,25),(37,9,'Uma das melhores animações que vi nos últimos anos!',11,8),(38,2,'A primeira e última vez!',6,17);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `use_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `use_name` varchar(100) NOT NULL,
  `use_lastname` varchar(100) DEFAULT NULL,
  `use_email` varchar(100) NOT NULL,
  `use_password` varchar(200) NOT NULL,
  `use_image` varchar(200) DEFAULT NULL,
  `use_bio` text DEFAULT NULL,
  `use_token` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`use_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'André','Olimpio','admin@etec.sp.gov.br','$2y$10$91hUP6MjjwSQJa6YTya84OIO1k6BNiqq0R6J/.m1r5HwHcQFEprL2','cd3a2e4dc373d8e537412083deb59501146b68e25e1f22bd3c2c1d75a2946ff87ab04b83ba96dc93ff5c3cdf7c4517826651ad25affaa99ad445e23a.jpg','Professor de Tecnologia da Informação.\r\nhttps://www.somostodosti.com.br','a07abc05429ebeaeb9bfe3e2cca50cb8ca99a0407eedc7c6719c385a12ef25500985bfc42d8c83fc69af6554121d1516f8c0'),(2,'Ana','Aline Elza da Mata','anaaline@gmail.com','$2y$10$jzVazUkv4gdMpJjMSFNJl.b9EY1sVBsZX8VVcyr7NINEkonXXcJRW','0d056516c9cea9f0ab0757a15fcd41d17a2f7fb1a53d8807e9c5918cd0a72c7057684d036661365dd4ccd63624f54e0a5de13650b547edc81823bac9.jpg',NULL,'2d39a6ff5ae5feef5aa657bdb6292f7b517e0b94bca1426f40cc0ea0407ce233b146aba5ced07ce6901359c7df5aa4afb4f0'),(3,'Milena','Clarice Moreira','milena.clarice@hotmail.com','$2y$10$23w1t1fu/8BjFuIfESwGIeW5SPRgVh2nwCCFJp3mX5ekIefFK5N2a','98615417ec5c659ee4e64036dad416ed4a2c57b1ecbdd715ba811dbb11855ec2a98343f2142d45db0a036c5f67d9041c66ebb56173af1b134e9ea52b.jpg',NULL,'862bff52362c2d0a19e541cb0ba4670ea69cfc7bdfd0313a73f211f82038b161dfc9e4579e57b373722928df28d46891fcc9'),(4,'César','Luiz Novaes','cezarluiznovaes@gmail.com','$2y$10$IWuA2v1SQCz03xwwP5LNNOHAaSVByvW5YvvqwlFp5ddU1FstUtRB.','3faf0cc0f8365a584cf198ecf10199c7113f327ace9694b102afb539bb86f33addeeaf659dfc760c8d83e9806925a5fff33dcf8c8d21cf01eaae783d.jpg',NULL,'b88b2f6cad162c9f3d102a9cc5c39f7da6febe4f1c25ce4a50d1b15d4848ad57f46f0b27a985f212fcf4cf105128ea2e1233'),(5,'Nelson','Raimundo das Neves','nel.raimundo11@hotmail.com','$2y$10$WK7VuaiDyF9EfgoXI9iMq.vMEjJCLoq4ZqSnPRGM9V6hZVQcUlVhu','1b678c5327b6ac79f90dd6b4fbc978be64fd7338bc0cd5b929f41d0ab2414adbd41c7b1c454ecc0ed0971582299faa4f71c80d8b84ecdfd58e2f6e2f.jpg','Profissional em Marketing.','f286beb8f53a52e1b62a21e748fef76e2883676628c3042f07468a375399dbd5b451748ca19377ebcfea325bec4b061b640c'),(6,'Hanamura','Shige','hanamura@outlook.com','$2y$10$UR0yXDRUDJtTvxriJNb/KOXJ31EwBd6KsQBFygt2tGQq4VeLyREuu','dcd653cf4683c73629fd81708d3f77d7020ebf9d4aae3c2d67ad6d1a1028cf1f422ff0a694113e65f47f775cd56d096782b57b38d158e88324149bad.jpg',NULL,'e9d37e12df4b34db52fd3ca0c7f206f9c3158c715f4e3f4f653bccff40888a5336b7fdf148e3c8ea2e5e82e01488daa85b6e'),(7,'Adriano','de Castro','adriano@gmail.com','$2y$10$fZIA0xYIadCobac.7dZ/2OQk9Z7oJyvcKyvhVrYFSwNr5zZGfM.2W','19ba51525872021d235f748cae95120b5117d46efede06491ac61bce0e188463f0660baff7f5a62ba0f8b002ffc6f0fdc68123b3738c9123d7409ed0.jpg','Faço parte da equipe de desenvolvimento desse site de avaliação de filmes.','bd6eb33ac016f9b2840cce0e5eac6aeeb60733d58543a001873315950addf7bac3b4db32afdbe2793422f32cadc4770b52e1'),(8,'É o Pijas',NULL,'eopijas@hotmail.com','$2y$10$xkMRUPqmoc8ggy5poVtFY..bjk1yRWX7DgyflBJ5QFma6uDPAKV6O','ab71d7b22a0e3a9c44092399210a255837970205ffe573e2c3dce7ca0426020544730b9638643846ead59f018bbf6d4b61c0b585e584adf2e62ffd09.jpg','É o Pijas.','2cc7ca8b1d38548c10bc152c0550674847319eed60b46d508bae43a725371f7966ea7631567ef814f4ef4926ca7745e8a04e'),(9,'Henrico','Pelozato Maeda','henrico.maeda@gmail.com','$2y$10$wqKsti69CklJMaEoD.MCOeqzMDbH3KuOL/Xgy2ns1bg3DEyAECp8a','9d025bef5603d4c310ab29855063e534c5be3b49f1ddaa9772c1b8f114adee5b42bf864841179a6ac340d5930a319417f14fa87b467e15f1a5f1a33f.jpg','Faço parte da equipe de desenvolvimento desse site de avaliação de filmes.','4f97e9dc27c7af17eeb06a8e21c48d989afd51c38c6b47a69a822b9f75f019b9a0057adc8d98565d8c6f68feb59b01b3d792'),(10,'Bárbara','Silva','karolbarbara@gmail.com','$2y$10$bCPHLjSuTXcvBqHAPuedO.vaGNW4C.PwgN/HxZZlFUPh8.4WqyJNe','736562fd1a4449f52b25c86200babe5e25d38181e6eee3732c6bb887efe95281395ee22efa99217a6d36abe36c440fb701501667ae4bfe5a4603899a.jpg',NULL,'583e25216030a886bb0de72906fa6f0d7b89a60ae8ec283debd47c23f6f29de45ecfd3c40ea966abb0d1843e647ceb4a920f'),(11,'Pedro','Henrique','pedro.henr34@hotmail.com','$2y$10$FDeuYoxGYTmpI4BA9mRCC.TPfBbX6twgqxkniSvvYSsP4ZQxg/Y9q','23ffa6833f159cd8dfed271d0bb5ef030b7461ecc6c2b6d374f4cf87786a8e23364282ddd715e632b029d284d88117e47356675b694d7dd45cb499b6.jpg',NULL,'b4733bc6a75f2ad1b11285ad3f7d699bf45908ec5063be3d71a0a5facaed5f6bd709041cea0570110288f94627c67a0aced9');
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

-- Dump completed on 2022-06-07 21:52:46
