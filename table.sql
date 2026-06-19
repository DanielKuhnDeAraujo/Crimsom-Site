create database crimsom;
use crimsom;

CREATE TABLE IF NOT EXISTS cartas (
    ID_CARTA INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(50) NOT NULL,
    IMAGEM VARCHAR(200) NOT NULL,
    SANGUE VARCHAR(10) NOT NULL,
    RARIDADE VARCHAR(15) NOT NULL,
    LENDARIO ENUM('s', 'n') DEFAULT 'n',
    COLECAO VARCHAR(20) NOT NULL,
    ID2 INT NOT NULL,
    PRECO DECIMAL(10, 2) NOT NULL
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS usuario (
    ID_USUARIO INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(50) NOT NULL,
    EMAIL VARCHAR(100) UNIQUE NOT NULL,
    SENHA VARCHAR(255) NOT NULL,
    NIVEL VARCHAR(10) NOT NULL
);

INSERT INTO cartas(NOME,IMAGEM,SANGUE,RARIDADE,LENDARIO,COLECAO,ID2,PRECO)values
("teste","logo.png","1","elite",'n',"TST",1,100),
('Sapo Gigante', 'img/logo.png', '3', 'ordinario', 'n', 'Base', 1, 12.90),
('Sapo Gigante+', 'img/logo.png', '3', 'excepcional', 'n', 'Base', 2, 89.90),
('Sapo Gigante+++', 'img/logo.png', '3', 'elite', 's', 'Base', 3, 199.90),
('Sapo Gigante++++', 'img/logo.png', '3', 'unico', 's', 'Base', 4, 349.90);