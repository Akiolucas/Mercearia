CREATE DATABASE  IF NOT EXISTS `mercearia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mercearia`;
-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: localhost    Database: mercearia
-- ------------------------------------------------------
-- Server version	8.0.25

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `caixa`
--

DROP TABLE IF EXISTS `caixa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `caixa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `total` double NOT NULL,
  `dt_registro` datetime NOT NULL,
  PRIMARY KEY (`id`,`produto_id`),
  KEY `fk_caixa_produto_idx` (`produto_id`),
  CONSTRAINT `fk_caixa_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caixa`
--

LOCK TABLES `caixa` WRITE;
/*!40000 ALTER TABLE `caixa` DISABLE KEYS */;
/*!40000 ALTER TABLE `caixa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'Administrador'),(2,'Operador de caixa'),(3,'Repositor');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codigo`
--

DROP TABLE IF EXISTS `codigo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `codigo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `barra` varchar(43) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL DEFAULT '1234567890',
  PRIMARY KEY (`id`),
  UNIQUE KEY `barra_UNIQUE` (`barra`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codigo`
--

LOCK TABLES `codigo` WRITE;
/*!40000 ALTER TABLE `codigo` DISABLE KEYS */;
INSERT INTO `codigo` VALUES (1,'1234567890'),(2,'1234567891'),(3,'1234567892'),(4,'1234567893'),(5,'1234567894'),(6,'1234567895'),(7,'1234567896'),(8,'1234567897'),(9,'1234567898'),(10,'1234567899'),(11,'1234567900'),(12,'1234567901'),(13,'1234567902'),(14,'1234567903'),(15,'1234567904'),(16,'1234567905'),(17,'1234567906'),(18,'1234567907'),(19,'1234567908'),(20,'1234567909');
/*!40000 ALTER TABLE `codigo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estoque`
--

DROP TABLE IF EXISTS `estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estoque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id`,`produto_id`),
  KEY `fk_estoque_produto_idx` (`produto_id`) /*!80000 INVISIBLE */,
  CONSTRAINT `fk_estoque_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoque`
--

LOCK TABLES `estoque` WRITE;
/*!40000 ALTER TABLE `estoque` DISABLE KEYS */;
INSERT INTO `estoque` VALUES (1,1,35),(2,2,30),(3,3,20),(4,4,30),(5,5,70),(6,6,59),(7,7,60),(8,8,30),(9,9,30),(10,10,45),(11,11,5),(12,12,45),(13,13,100),(14,14,100),(15,15,350),(16,16,90),(17,17,60),(18,18,50),(19,19,40),(20,20,50);
/*!40000 ALTER TABLE `estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `cnpj` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `dt_registro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cnpj_UNIQUE` (`cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedor`
--

LOCK TABLES `fornecedor` WRITE;
/*!40000 ALTER TABLE `fornecedor` DISABLE KEYS */;
INSERT INTO `fornecedor` VALUES (1,'Marques Monte','12.123.456/0101-02','2021-07-29 08:10:30'),(2,'Panificadora Tomé','10.241.584/2014-54','2021-07-29 08:10:30'),(3,'Heinz','50.955.707/0001-20','2021-08-11 23:45:27'),(4,' Visconti','70.940.994/0040-18','2021-08-31 20:51:03'),(5,'Coca Cola Industriais LTDA','45.997.418/0001-53','2021-09-04 16:18:19');
/*!40000 ALTER TABLE `fornecedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `cargo_id` int NOT NULL,
  `nivel_id` int NOT NULL,
  `credencial` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `senha` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `dt_registro` datetime NOT NULL,
  PRIMARY KEY (`id`,`cargo_id`,`nivel_id`),
  UNIQUE KEY `credencial_UNIQUE` (`credencial`),
  KEY `fk_funcionario_cargo_idx` (`cargo_id`) /*!80000 INVISIBLE */,
  KEY `fk_funcionario_nivel_idx` (`nivel_id`),
  CONSTRAINT `fk_funcionario_cargo` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`),
  CONSTRAINT `fk_funcionario_nivel` FOREIGN KEY (`nivel_id`) REFERENCES `nivel` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario`
--

LOCK TABLES `funcionario` WRITE;
/*!40000 ALTER TABLE `funcionario` DISABLE KEYS */;
INSERT INTO `funcionario` VALUES (1,'Lucas Akio Turuda',1,3,'lucas','$2y$10$txRewOK602QZN61Grh2fZOiv9zaL7m6eyml5sqw4LyXB33KhrZnKi',1,'2021-09-03 23:46:27'),(2,'José Gomes Pereira',2,3,'joseamaro','$2y$10$IxAyR2Fj1K4dST.vURDj5uwyvd8fzIHt045Qga4VJkWOQpmzibGxa',1,'2021-09-09 21:02:24');
/*!40000 ALTER TABLE `funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario_pg_privada`
--

DROP TABLE IF EXISTS `funcionario_pg_privada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionario_pg_privada` (
  `funcionario_id` int NOT NULL,
  `pg_privada_id` int NOT NULL,
  `dt_registro` datetime NOT NULL,
  PRIMARY KEY (`funcionario_id`,`pg_privada_id`),
  KEY `fk_funcionario_pg_privada_pg_privada_idx` (`pg_privada_id`),
  KEY `fk_funcionario_pg_privada_funcionario_idx` (`funcionario_id`) /*!80000 INVISIBLE */,
  CONSTRAINT `fk_funcionario_pg_privada_funcionario` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_funcionario_pg_privada_pg_privada` FOREIGN KEY (`pg_privada_id`) REFERENCES `pg_privada` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario_pg_privada`
--

LOCK TABLES `funcionario_pg_privada` WRITE;
/*!40000 ALTER TABLE `funcionario_pg_privada` DISABLE KEYS */;
INSERT INTO `funcionario_pg_privada` VALUES (1,1,'2021-09-04 18:50:12'),(1,2,'2021-09-04 18:50:12'),(1,3,'2021-09-04 18:50:12'),(1,4,'2021-09-04 18:50:12'),(1,5,'2021-09-04 18:50:12'),(1,6,'2021-09-04 18:50:12'),(1,7,'2021-09-04 18:50:12'),(1,8,'2021-09-04 18:50:12'),(1,9,'2021-09-04 18:50:12'),(1,10,'2021-09-04 18:50:12'),(1,11,'2021-09-04 18:50:12'),(2,1,'2021-09-09 21:02:24'),(2,11,'2021-09-09 21:02:24');
/*!40000 ALTER TABLE `funcionario_pg_privada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem`
--

DROP TABLE IF EXISTS `imagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produto_id` int NOT NULL,
  `endereco` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  PRIMARY KEY (`id`,`produto_id`),
  UNIQUE KEY `endereco_UNIQUE` (`endereco`),
  KEY `fk_imagem_produto_idx` (`produto_id`),
  CONSTRAINT `fk_imagem_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem`
--

LOCK TABLES `imagem` WRITE;
/*!40000 ALTER TABLE `imagem` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel`
--

DROP TABLE IF EXISTS `nivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nivel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel`
--

LOCK TABLES `nivel` WRITE;
/*!40000 ALTER TABLE `nivel` DISABLE KEYS */;
INSERT INTO `nivel` VALUES (1,'Inicial'),(2,'Parcial'),(3,'Total');
/*!40000 ALTER TABLE `nivel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pg_privada`
--

DROP TABLE IF EXISTS `pg_privada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pg_privada` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `dt_registro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pg_privada`
--

LOCK TABLES `pg_privada` WRITE;
/*!40000 ALTER TABLE `pg_privada` DISABLE KEYS */;
INSERT INTO `pg_privada` VALUES (1,'Home','2021-08-09 19:55:47'),(2,'Produtos','2021-08-09 19:55:47'),(3,'Perfil','2021-08-09 19:55:47'),(4,'Fornecedor','2021-08-31 18:14:59'),(5,'Estoque','2021-09-01 16:05:55'),(6,'Cargo','2021-09-01 16:05:55'),(7,'Nivel','2021-09-01 18:39:38'),(8,'Pagina_privada','2021-09-01 18:55:45'),(9,'Pagina_publica','2021-09-01 18:55:45'),(10,'Funcionario','2021-09-01 19:05:43'),(11,'Caixa','2021-09-04 16:19:38');
/*!40000 ALTER TABLE `pg_privada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pg_publica`
--

DROP TABLE IF EXISTS `pg_publica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pg_publica` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `dt_registro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pg_publica`
--

LOCK TABLES `pg_publica` WRITE;
/*!40000 ALTER TABLE `pg_publica` DISABLE KEYS */;
INSERT INTO `pg_publica` VALUES (1,'Login','2021-09-04 16:20:03'),(2,'PaginaInvalida','2021-09-02 09:41:26'),(3,'Sair','2021-09-02 09:47:08');
/*!40000 ALTER TABLE `pg_publica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs NOT NULL,
  `preco` double NOT NULL,
  `fornecedor_id` int NOT NULL,
  `codigo_id` int NOT NULL,
  `kilograma` double NOT NULL DEFAULT '0',
  `dt_registro` datetime NOT NULL,
  PRIMARY KEY (`id`,`fornecedor_id`,`codigo_id`),
  KEY `fk_produto_fornecedor_idx` (`fornecedor_id`),
  KEY `fk_produto_codigo_idx` (`codigo_id`),
  CONSTRAINT `fk_produto_codigo` FOREIGN KEY (`codigo_id`) REFERENCES `codigo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_produto_fornecedor` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_cs;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,'Pão integral',7.49,2,1,0.5,'2021-08-25 23:35:39'),(2,'Pão de forma',5.5,2,2,0.5,'2021-07-29 08:27:37'),(3,'Queijo prato',46,1,3,1,'2021-07-29 08:27:37'),(4,'Bolo de limão',25,2,4,1,'2021-08-11 21:24:17'),(5,'Molho Barbecue Heinz',7,3,5,0.397,'2021-08-12 00:05:05'),(6,'Requeijão',5,2,6,1,'2021-08-12 00:03:57'),(7,'Goiabada',4.5,2,7,0.5,'2021-08-12 00:04:50'),(8,'Bolo de maracujá',25,2,8,1,'2021-08-12 00:05:04'),(9,'Bolo de chocolate',25,2,9,1,'2021-08-12 00:05:04'),(10,'Bolo de cenoura',20,2,10,1,'2021-08-12 00:05:04'),(11,'Bolo de abacaxi',20,2,11,1.5,'2021-08-26 20:19:32'),(12,'Presunto Marques Monte',39.5,1,12,1,'2021-08-12 00:05:04'),(13,'Molho de tomate Heinz',4,3,13,0.4,'2021-08-12 00:05:04'),(14,'Catchup Heinz',5.5,3,14,0.26,'2021-08-12 00:05:05'),(15,'Maionese Sachê Heinz',0.5,3,15,0.8,'2021-08-12 00:05:05'),(16,'Maionese Tradicional Heinz',6.7,3,16,0.215,'2021-08-12 00:05:05'),(17,'Leite condensado Moça',6.85,2,17,0.395,'2021-08-28 11:09:01'),(18,'Creme de leite nestlé',3.5,1,18,0.25,'2021-08-28 16:06:53'),(19,'Biscoito de morango Trakinas ',2.7,1,19,0.13,'2021-09-11 16:26:09'),(20,'Fermento biológico Dona Benta',1,2,20,0.05,'2021-09-11 16:37:31');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'mercearia'
--
/*!50003 DROP PROCEDURE IF EXISTS `atualizar_produto_estoque` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `atualizar_produto_estoque`(
id int,
nome varchar(30), 
preco double ,
fornecedor_id int,
codigo_id int,
kilograma double,
quantidade int
)
BEGIN
DECLARE erro_sql TINYINT DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET erro_sql = TRUE;

IF(id <> "" and nome <> "" and preco <> "" and fornecedor_id <> "" and kilograma <> "" and codigo_id <> "" and quantidade <> "") THEN

	START TRANSACTION;
	UPDATE produto AS p SET p.nome = nome, p.preco = preco, p.fornecedor_id = fornecedor_id, p.kilograma = kilograma, p.codigo_id = codigo_id, p.dt_registro = now() WHERE p.id = id;
	IF erro_sql = true
		THEN
		SELECT 'Erro ao atualizar na tabela produto' AS Mensagem;
	ROLLBACK;
    
	ELSE
		UPDATE estoque AS e SET e.quantidade = quantidade WHERE e.id = id and e.produto_id = id;
		IF erro_sql = true
			THEN
			SELECT 'Erro ao atualizar no estoque' AS Mensagem;
		ROLLBACK;
		ELSE
			 SELECT 'Produto atualizado com sucesso' AS Mensagem;
			  COMMIT;
		END IF;
	END IF;
ELSE
	SELECT 'Preencha todos os campos e tente novamente!' AS Mensagem;
  END IF;              
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `cadastrar_codigo_produto_estoque` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar_codigo_produto_estoque`(
nome varchar(30), 
preco double ,
fornecedor_id int,
kilograma double,
quantidade int
)
BEGIN
DECLARE erro_sql TINYINT DEFAULT FALSE;
DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET erro_sql = TRUE;

IF(nome <> "" and preco <> "" and fornecedor_id <> "" and kilograma <> "" and quantidade <> "") THEN

	START TRANSACTION;
	SET @codigo = (SELECT barra + 1 AS valor FROM codigo ORDER BY id DESC LIMIT 1);
	INSERT INTO codigo values(NULL,ifnull(@codigo,default(barra)));
	IF erro_sql = true
		THEN
		SELECT 'Erro ao inserir na tabela de código' AS Mensagem;
	ROLLBACK;
	ELSE
		INSERT INTO produto values(NULL, nome, preco, fornecedor_id, last_insert_id(), kilograma, now());
		IF erro_sql = true
			THEN
			SELECT 'Erro ao inserir na tabela de produto' AS Mensagem;
		ROLLBACK;
		ELSE
			INSERT INTO estoque values(null,last_insert_id(),quantidade);
			IF erro_sql = true
				THEN
				SELECT 'Erro ao inserir na tabela de estoque' AS Mensagem;
			ROLLBACK;
			ELSE
			 SELECT 'Cadastro efetuado com sucesso' AS Mensagem;
			  COMMIT;
			END IF;
		END IF;
	END IF;
ELSE
	SELECT 'Preencha todos os campos e tente novamente!' AS Mensagem;
END IF;
                
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-11 16:52:22
