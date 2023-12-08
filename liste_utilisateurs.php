<?php
include('dao.php');

$dao = new DAO();
$dao->connexion();

// Sélectionner tous les utilisateurs avec les livres empruntés
$selectStmt = $dao->bdd->prepare("
    SELECT u.id_utilisateur, u.nom, u.prenom, u.carte_membre, e.title AS livre_emprunte
    FROM utilisateurs u
    LEFT JOIN emprunts e ON u.id_utilisateur = e.user_id
");

if ($selectStmt->execute()) {
    $result = $selectStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} else {
    echo json_encode(["error" => "Erreur lors de la récupération des utilisateurs."]);
}

$dao->disconnect();
?>