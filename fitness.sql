CREATE DATABASE fitness;

USE fitness;

CREATE TABLE `activite` (
  `id_activite` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(100),
  `description` text,
  `capacite` int,
  `date_debut` date,
  `date_fin` date,
  `disponibilite` tinyint(1)
);

CREATE TABLE `membre` (
  `id_membre` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(50),
  `prenom` varchar(50),
  `email` varchar(100),
  `telephone` varchar(15)
);

CREATE TABLE `reservation` (
  `id_reservation` int PRIMARY KEY AUTO_INCREMENT,
  `id_membre` int,
  `id_activite` int,
  `date_reservation` DATETIME DEFAULT Now(), 
  `status` enum('confirmee','annulee'),
  FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`),
  FOREIGN KEY (`id_activite`) REFERENCES `activite` (`id_activite`)
);

INSERT INTO `activite` (`nom`, `description`, `capacite`, `date_debut`, `date_fin`, `disponibilite`)
VALUES
('Yoga Class', 'A relaxing yoga session for all levels, focusing on flexibility and mindfulness.', 20, '2024-12-15', '2024-12-15', 1),
('Zumba', 'A high-energy dance workout set to upbeat music.', 25, '2024-12-16', '2024-12-16', 1),
('Spin Class', 'An intense indoor cycling workout for cardio endurance.', 15, '2024-12-17', '2024-12-17', 1),
('Strength Training', 'Weight lifting session designed for muscle building and strength improvement.', 12, '2024-12-18', '2024-12-18', 0),
('HIIT', 'High-intensity interval training for improving overall fitness.', 18, '2024-12-20', '2024-12-20', 1);

INSERT INTO `membre` (`nom`, `prenom`, `email`, `telephone`)
VALUES
('Doe', 'John', 'john.doe@example.com', '1234567890'),
('Smith', 'Jane', 'jane.smith@example.com', '9876543210'),
('Taylor', 'James', 'james.taylor@example.com', '5551234567'),
('Brown', 'Emily', 'emily.brown@example.com', '5559876543'),
('Wilson', 'Michael', 'michael.wilson@example.com', '5555678901');


INSERT INTO `reservation` (`id_membre`, `id_activite`, `date_reservation`, `status`)
VALUES
(1, 1, '2024-12-10 09:00:00', 'confirmee'),
(2, 2, '2024-12-16 17:30:00', 'confirmee'),
(3, 3, '2024-12-17 07:45:00', 'confirmee'),
(4, 4, '2024-12-18 18:00:00', 'annulee'),
(5, 5, '2024-12-20 10:00:00', 'confirmee');


SELECT * FROM activite;
SELECT * FROM membre;
SELECT * FROM reservation;
SELECT nom, prenom from membre m, reservation r WHERE m.id_membre = r.id_membre;
SELECT nom, prenom FROM membre m WHERE m.id_membre IN (SELECT id_membre FROM reservation);
SELECT nom, prenom FROM membre m WHERE m.id_membre NOT IN (SELECT id_membre FROM reservation);

DELETE FROM membre WHERE id_membre = 6;
UPDATE membre SET nom = 'test' WHERE id_membre = 1;
