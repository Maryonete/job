-- Créer la base de données 'job' si elle n'existe pas
CREATE DATABASE IF NOT EXISTS job;

-- Utiliser la base de données 'job'
USE job;

-- Créer la table 'user'
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ;

-- Ajouter un utilisateur avec un mot de passe haché
INSERT INTO `user` (`username`, `email`, `password`) 
VALUES ('admin', 'admin@job.com', '$2y$10$Jh6L/yHFf5X3vSxsSont8.gaNvVHo0JpPT.6r68IeHlBj1BUsLy76');

CREATE TABLE offre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dateCandidature DATE,
    entreprise VARCHAR(100),
    lieu VARCHAR(100),
    description TEXT,
    url VARCHAR(255),
    contact VARCHAR(100),
    reponse TEXT,
    reponse_at DATE
);
