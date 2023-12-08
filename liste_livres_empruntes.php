<?php

// Inclure la classe DAO
include('dao.php');

// Créer une instance de la classe DAO
$dao = new DAO();

// Connexion à la base de données
$dao->connexion();

// Vérifier les erreurs de connexion
if ($dao->getLastError()) {
    echo json_encode(array('error' => 'Erreur de connexion à la base de données: ' . $dao->getLastError()));
    exit;
}

// Requête SQL pour récupérer la liste des livres empruntés
$sql = "SELECT id, title, emprunt_date, retour_date, user_id, nom_emprunteur FROM emprunts";

// Exécution de la requête
$result = $dao->bdd->query($sql);

// Vérifier les erreurs d'exécution de la requête
if ($result === false) {
    echo json_encode(array('error' => 'Erreur d\'exécution de la requête: ' . $dao->bdd->errorInfo()[2]));
    exit;
}

// Vérifier si la requête a réussi
if ($result) {
    $livresEmpruntes = array();

    // Parcourir les résultats de la requête
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Ajouter chaque ligne au tableau
        $livresEmpruntes[] = $row;
    }

    // Fermer la connexion à la base de données
    $dao->disconnect();

    // Retourner les résultats en format JSON
    echo json_encode($livresEmpruntes);
} else {
    // En cas d'échec de la requête, retourner une erreur
    echo json_encode(array('error' => 'Erreur lors de la récupération des livres empruntés.'));
}
?>
