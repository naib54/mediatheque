<?php
// Inclusion du fichier dao.php qui contient la classe DAO
include('dao.php');

// Vérification si le paramètre 'title' est présent dans la requête POST
if (isset($_POST['title'])) {
    // Récupération du titre à partir de la requête POST
    $title = $_POST['title'];

    // Création d'une instance de la classe DAO
    $dao = new DAO();

    try {
        // Connexion à la base de données
        $dao->connexion();

        // Début d'une transaction pour assurer l'intégrité des données
        $dao->bdd->beginTransaction();

        // Préparation et exécution de la première requête pour vérifier si le livre est emprunté
        $stmt = $dao->bdd->prepare("SELECT * FROM emprunts WHERE title = :title");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->execute();

        // Récupération du nombre de lignes affectées par la requête
        $rowCount = $stmt->rowCount();

        // Si le livre n'est pas emprunté, on peut le supprimer
        if ($rowCount === 0) {
            // Préparation et exécution de la requête de suppression du livre
            $deleteStmt = $dao->bdd->prepare("DELETE FROM livres WHERE title = :title");
            $deleteStmt->bindParam(':title', $title, PDO::PARAM_STR);
            $deleteStmt->execute();

            // Succès : le livre a été supprimé avec succès
            echo json_encode(['success' => true, 'message' => 'Le livre a été supprimé avec succès']);
        } else {
            // En cas d'échec (le livre est emprunté), on annule la transaction
            $dao->bdd->rollBack();
            echo json_encode(['success' => false, 'message' => 'Le livre est emprunté, on ne peut pas le supprimer']);
        }

        // Validation de la transaction
        $dao->bdd->commit();

        // Déconnexion de la base de données
        $dao->disconnect();

    } catch (PDOException $e) {
        // En cas d'erreur, affichage du message d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
    }
} else {
    // Si le paramètre 'title' n'est pas présent dans la requête POST
    echo json_encode(['success' => false, 'message' => 'Le nom du livre n\'est pas présent dans la requête']);
}
?>
