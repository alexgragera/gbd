create database ahorcado;

use ahorcado;

CREATE TABLE pelicula (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100)
);


INSERT INTO pelicula (titulo) VALUES
('Pulp Fiction'),
('The Godfather'),
('The Shawshank Redemption'),
('Inception'),
('The Dark Knight');