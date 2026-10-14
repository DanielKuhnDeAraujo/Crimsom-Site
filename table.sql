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

CREATE TABLE IF NOT EXISTS decks (
    ID_DECK INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(100) NOT NULL,
    AUTOR INT NOT NULL,-- fk de usuario
    COMANDANTE INT NOT NULL,-- fk de cartas
    DESESPERO INT NOT NULL, -- fk de cartas
    DATACRIACAO datetime not null,
    DATAMODIFICAÇÂO datetime not null,
    CONSTRAINT FK_DECKS_AUTOR foreign key (AUTOR) references usuario(ID_USUARIO),
    CONSTRAINT FK_DECKS_COMANDANTE foreign key (COMANDANTE) references cartas(ID_CARTA),
    CONSTRAINT FK_DECKS_DESESPERO foreign key (DESESPERO) references cartas(ID_CARTA)
);
CREATE TABLE IF NOT EXISTS CartaDeck (
    ID_CARTADECK INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FKCARTA INT NOT NULL,-- fk de carta 
    FKDECK INT NOT NULL, --fk de deck
    QTD INT NOT NULL,
    CONSTRAINT FK_CARTADECK_CARTA foreign key (FKCARTA) references cartas(ID_CARTA),
    CONSTRAINT FK_CARTADECK_DECK foreign key (FKDECK) references decks(ID_DECK)
);

INSERT INTO cartas(NOME,IMAGEM,SANGUE,RARIDADE,LENDARIO,COLECAO,ID2,PRECO)values
('Sapo Gigante', 'logo.png', '3', 'ordinario', 'n', 'Base', 1, 12.90),
('Sapo Gigante+', 'logo.png', '3', 'excepcional', 'n', 'Base', 2, 89.90),
('Sapo Gigante+++', 'logo.png', '3', 'elite', 's', 'Base', 3, 199.90),
('Sapo Gigante++++', 'logo.png', '3', 'unico', 's', 'Base', 4, 349.90),
('Sapo GiganteS+','logo.png', '3', 'desespero', 's', 'Base', 4, 349.90);


INSERT INTO cartas(NOME,IMAGEM,SANGUE,RARIDADE,LENDARIO,COLECAO,ID2,PRECO)values
('Aranha Gigante', 'logo.png', '3', 'ordinario', 'n', 'Base', 1, 12.90),
('Aranha Gigante+', 'logo.png', '3', 'excepcional', 'n', 'Base', 2, 89.90),
('Aranha Gigante+++', 'logo.png', '3', 'elite', 's', 'Base', 3, 199.90),
('Aranha Gigante++++', 'logo.png', '3', 'unico', 's', 'Base', 4, 349.90);

INSERT INTO cartas(NOME,IMAGEM,SANGUE,RARIDADE,LENDARIO,COLECAO,ID2,PRECO)values
('Lobo Gigante', 'logo.png', '3', 'ordinario', 'n', 'Base', 1, 12.90),
('Lobo Gigante+', 'logo.png', '3', 'excepcional', 'n', 'Base', 2, 89.90),
('Lobo Gigante+++', 'logo.png', '3', 'elite', 's', 'Base', 3, 199.90),
('Lobo Gigante++++', 'logo.png', '3', 'unico', 's', 'Base', 4, 349.90);