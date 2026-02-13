CREATE TABLE `vendedores` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `contacto` varchar(20) NOT NULL,
  `genero` char(1) NOT NULL,
  `estadoCivil` varchar(20) NOT NULL,
  `codigo_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `diasTrabalhados` int(11) NOT NULL,
  `salarioDiario` double NOT NULL,
  `bonusDiario` double NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `codigo_produto` (`codigo_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `produtos` (
  `codigo_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `unidade_medida` varchar(10) NOT NULL,
  `quantidade` double NOT NULL,
  `preco_unitario` double NOT NULL,
  `data_validade` date DEFAULT NULL,
  PRIMARY KEY (`codigo_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE usuarios (
    `codigo` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(120) UNIQUE NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO usuarios (nome, email, senha) VALUES('Nelma', 'nelma@gmail.com',
 '$2y$10$YxqbwmtMxpHoZsbS8rQUP.HhVGKYb.ULz3ngcyULfyuw/8STvmJ3i');

select*from usuarios;