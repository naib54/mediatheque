# Documentation du Projet des requêtes SQL de l'application :

## Afficher la liste de tous les utilisateurs avec leurs informations :
SELECT * FROM Utilisateurs ;

## Afficher la liste des livres avec leur statut :
SELECT title, status FROM livres;

## Ajouter un livre au catalogue :
INSERT INTO livres (title, isbn, pageCount, publishedDate, thumbnailUrl, shortDescription, longDescription, status, authors, categories) 
VALUES ('Nouveau Livre', '1234567890123', 200, '2023-01-01', 'url_image', 'Description courte...', 'Description longue...', 'Disponible', 'Auteur XYZ', 'Roman');

## Supprimer un livre du catalogue s'il n'est pas emprunté :
DELETE FROM livres WHERE ID_Livres = [ID_Livre] AND Statut = 'Disponible';

## Afficher la fiche descriptive d'un livre enregistré en BDD :
SELECT * FROM livres WHERE ID_Livres = [ID_Livre];

## Modifier le statut d'un livre (Disponible/Prêt) :
UPDATE livres SET Statut = 'Prêté' WHERE ID_Livres = [ID_Livre];

## Afficher la liste de tous les emprunts avec leurs informations :
SELECT emprunts.*, livres.title as livre_title FROM emprunts 
JOIN livres ON emprunts.title = livres.title;

# Afficher les informations d'un utilisateur et les livres qu'il a éventuellement empruntés :
SELECT emprunts.*, livres.title as livre_title FROM emprunts 
JOIN livres ON emprunts.title = livres.title 
WHERE emprunts.user_id = [ID_Utilisateur];
