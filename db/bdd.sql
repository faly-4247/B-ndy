create database gestion;
use gestion;

-- Table espece
CREATE TABLE espece (
    id INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    url_photo VARCHAR(255),
    PRIMARY KEY (id)
);

-- Table stocks modifiée pour ajouter la clé étrangère
CREATE TABLE stocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    espece_id INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (espece_id) REFERENCES espece(id)
);

-- Table parcelle
CREATE TABLE parcelle (
    id INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    localisation VARCHAR(255) NOT NULL,
    surface DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id)
);

-- Table plantations modifiée pour ajouter les clés étrangères
CREATE TABLE plantations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parcelle_id INT NOT NULL,
    surface_ INT NOT NULL,
    espece_id INT NOT NULL,
    quantite_plantee INT NOT NULL,
    date_plantation DATE NOT NULL,
    FOREIGN KEY (parcelle_id) REFERENCES parcelle(id),
    FOREIGN KEY (espece_id) REFERENCES espece(id)
);

select parcelle.id as parcelle_id,
 parcelle.nom as parcelle_nom,
 parcelle.surface as parcelle_surface,
 espece.id as espece_id,
 espece.nom as espece_nom,
 plantations.quantite_plantee,
 plantations.date_plantation 
from parcelle, espece, plantations 
where parcelle.id = plantations.parcelle_id and espece.id = plantations.espece_id;
