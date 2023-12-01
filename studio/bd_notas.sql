CREATE DATABASE IF NOT EXISTS `bd_notas`;
USE `bd_notas`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `tb_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(255) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_cliente` (`id_cliente`, `nome_cliente`) VALUES
(1, 'João Marcos'),
(2, 'João Pedro Reis'),
(3, 'Henry'),
(4, 'Lucas Lopes'),
(5, 'Danilo'),
(6, 'João Pedro Vieira'),
(7, 'Diego '),
(8, 'Gustavo'),
(9, 'Lucas Lucio'),
(10, 'Moises');

CREATE TABLE IF NOT EXISTS `tb_status_nota` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status_pagamento` varchar(50) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_status_nota` (`id_status`, `status_pagamento`) VALUES
(1, 'Pago'),
(2, 'N&atilde;o Pago');

CREATE TABLE IF NOT EXISTS `tb_pagamento` (
  `id_pagamento` int(11) NOT NULL AUTO_INCREMENT,
  `forma_pagamento` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_pagamento` (`id_pagamento`, `forma_pagamento`) VALUES
(1, 'Cart&atilde;o Credito'),
(2, 'Cart&atilde;o Debito'),
(3, 'Pix'),
(4, 'Dinheiro');

CREATE TABLE IF NOT EXISTS `tb_servico` (
  `id_servico` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_servico` varchar(255) NOT NULL,
  PRIMARY KEY (`id_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_servico` (`id_servico`, `tipo_servico`) VALUES
(1, 'Pacote 1'),
(2, 'Pacote 2'),
(3, 'Pacote 3'),
(4, 'Pacote 4'),
(5, 'Pacote 5'),
(6, 'Pacote 6'),
(7, 'Pacote 7'),
(8, 'Pacote 8'),
(9, 'Pacote 9'),
(10, 'Pacote 10');

CREATE TABLE IF NOT EXISTS `tb_notas` (
  `id_notas` int(11) NOT NULL AUTO_INCREMENT,
  `data_nota` date NOT NULL,
  `preco_nota` FLOAT NOT NULL,
  `id_pagamento` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  PRIMARY KEY (`id_notas`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_pagamento` (`id_pagamento`),
  KEY `id_servico` (`id_servico`),
  KEY `id_status` (`id_status`),
  CONSTRAINT `tb_notas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`),
  CONSTRAINT `tb_notas_ibfk_2` FOREIGN KEY (`id_pagamento`) REFERENCES `tb_pagamento` (`id_pagamento`),
  CONSTRAINT `tb_notas_ibfk_3` FOREIGN KEY (`id_servico`) REFERENCES `tb_servico` (`id_servico`),
  CONSTRAINT `tb_notas_ibfk_4` FOREIGN KEY (`id_status`) REFERENCES `tb_status_nota` (`id_status`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
