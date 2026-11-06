CREATE DATABASE IF NOT EXISTS crimsom CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE crimsom;

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
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS usuario (
    ID_USUARIO INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(50) NOT NULL,
    EMAIL VARCHAR(100) UNIQUE NOT NULL,
    SENHA VARCHAR(255) NOT NULL,
    NIVEL VARCHAR(10) NOT NULL
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS decks (
    ID_DECK INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(100) NOT NULL,
    AUTOR INT NOT NULL, -- fk de usuario
    COMANDANTE INT NOT NULL, -- fk de cartas
    DESESPERO INT NOT NULL, -- fk de cartas
    DATACRIACAO DATETIME NOT NULL,
    DATAMODIFICACAO DATETIME NOT NULL,
    CONSTRAINT FK_DECKS_AUTOR FOREIGN KEY (AUTOR) REFERENCES usuario(ID_USUARIO),
    CONSTRAINT FK_DECKS_COMANDANTE FOREIGN KEY (COMANDANTE) REFERENCES cartas(ID_CARTA),
    CONSTRAINT FK_DECKS_DESESPERO FOREIGN KEY (DESESPERO) REFERENCES cartas(ID_CARTA)
) DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS CartaDeck (
    ID_CARTADECK INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FKCARTA INT NOT NULL, -- fk de carta
    FKDECK INT NOT NULL, -- fk de deck
    QTD INT NOT NULL,
    CONSTRAINT FK_CARTADECK_CARTA FOREIGN KEY (FKCARTA) REFERENCES cartas(ID_CARTA),
    CONSTRAINT FK_CARTADECK_DECK FOREIGN KEY (FKDECK) REFERENCES decks(ID_DECK)
) DEFAULT CHARSET=utf8mb4;

INSERT INTO cartas(NOME,IMAGEM,SANGUE,RARIDADE,LENDARIO,COLECAO,ID2,PRECO) VALUES
('Sapo Gigante', 'logo.png', '3', 'ordinario', 'n', 'Base', 1, 12.90),
('Sapo Gigante+', 'logo.png', '3', 'excepcional', 'n', 'Base', 2, 89.90),
('Sapo Gigante+++', 'logo.png', '3', 'elite', 's', 'Base', 3, 199.90),
('Sapo Gigante++++', 'logo.png', '3', 'unico', 's', 'Base', 4, 349.90),
('Sapo GiganteS+', 'logo.png', '3', 'desespero', 's', 'Base', 4, 349.90);

INSERT INTO cartas(NOME,IMAGEM,SANGUE,RARIDADE,LENDARIO,COLECAO,ID2,PRECO) VALUES
('Aranha Gigante', 'logo.png', '3', 'ordinario', 'n', 'Base', 1, 12.90),
('Aranha Gigante+', 'logo.png', '3', 'excepcional', 'n', 'Base', 2, 89.90),
('Aranha Gigante+++', 'logo.png', '3', 'elite', 's', 'Base', 3, 199.90),
('Aranha Gigante++++', 'logo.png', '3', 'unico', 's', 'Base', 4, 349.90);

INSERT INTO cartas(NOME,IMAGEM,SANGUE,RARIDADE,LENDARIO,COLECAO,ID2,PRECO) VALUES
('Lobo Gigante', 'logo.png', '3', 'ordinario', 'n', 'Base', 1, 12.90),
('Lobo Gigante+', 'logo.png', '3', 'excepcional', 'n', 'Base', 2, 89.90),
('Lobo Gigante+++', 'logo.png', '3', 'elite', 's', 'Base', 3, 199.90),
('Lobo Gigante++++', 'logo.png', '3', 'unico', 's', 'Base', 4, 349.90);

-- Usuário de exemplo (os decks precisam de um autor existente).
-- Senha: admin123 (hash gerado com password_hash do PHP)
INSERT INTO usuario(NOME,EMAIL,SENHA,NIVEL) VALUES
('Administrador', 'admin@crimsom.com', '$2y$10$f0u71iGoMY5nL3Ir48uAueIjx/bZaFJo/UlfhN4r0jMLZWix502WW', 'adm');

-- Inserts de exemplo Decks
INSERT INTO decks(NOME,AUTOR,COMANDANTE,DESESPERO,DATACRIACAO,DATAMODIFICACAO) VALUES
('Resenha do lil macaco', 1, 1, 2, NOW(), NOW()),
('Mortos Molestator', 1, 3, 4, NOW(), NOW());

INSERT INTO CartaDeck(FKCARTA,FKDECK,QTD) VALUES
(3, 1, 4),
(4, 1, 2),
(2, 2, 3),
(1, 2, 3);
