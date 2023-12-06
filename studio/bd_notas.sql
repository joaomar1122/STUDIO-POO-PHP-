CREATE DATABASE IF NOT EXISTS `bd_notas`;
USE `bd_notas`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


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


CREATE TABLE IF NOT EXISTS `tb_notas` (
  `id_notas` int(11) NOT NULL AUTO_INCREMENT,
  `data_nota` date NOT NULL,
  `preco_nota` FLOAT NOT NULL,
  `id_pagamento` int(11) NOT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `tipo_servico` varchar(255) NOT NULL,
  `id_status` int(11) NOT NULL,
  PRIMARY KEY (`id_notas`),
  KEY `id_pagamento` (`id_pagamento`),
  KEY `id_status` (`id_status`),
  CONSTRAINT `tb_notas_ibfk_2` FOREIGN KEY (`id_pagamento`) REFERENCES `tb_pagamento` (`id_pagamento`),
  CONSTRAINT `tb_notas_ibfk_4` FOREIGN KEY (`id_status`) REFERENCES `tb_status_nota` (`id_status`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
