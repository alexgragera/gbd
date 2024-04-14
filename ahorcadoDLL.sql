create database ahorcado;

use ahorcado;

CREATE TABLE pelicula (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100)
);


INSERT INTO pelicula (titulo) VALUES
('Pulp Fiction'),
('The Godfather'),
('El rey leon'),
('Un ciudadano ejemplar'),
('El lobo de wall street');