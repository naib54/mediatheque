<?php
require_once 'dao.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assurez-vous que les données du formulaire sont présentes
    if (isset($_POST['title'], $_POST['nom_emprunteur'], $_POST['prenom_emprunteur'], $_POST['emprunt_date'], $_POST['retour_date'])) {
        $title = $_POST['title'];
        $nom_emprunteur = $_POST['nom_emprunteur'];
        $prenom_emprunteur = $_POST['prenom_emprunteur'];
        $emprunt_date = $_POST['emprunt_date'];
        $retour_date = $_POST['retour_date'];

        // Connexion à la base de données
        require_once 'dao.php';
        $dao = new DAO();
        $dao->connexion();

        // Échapper les données pour éviter les injections SQL (utilisez des requêtes préparées)
        $title = $dao->bdd->quote($title);
        $nom_emprunteur = $dao->bdd->quote($nom_emprunteur);
        $prenom_emprunteur = $dao->bdd->quote($prenom_emprunteur);
        $emprunt_date = $dao->bdd->quote($emprunt_date);
        $retour_date = $dao->bdd->quote($retour_date);

        // Vérification de l'état actuel du livre
        $queryCheckStatus = "SELECT Statut FROM livres WHERE title = $title";
        $currentStatus = $dao->bdd->query($queryCheckStatus)->fetchColumn();

        if ($currentStatus === 'Disponible') {
            // Recherche de la carte membre associée
            $queryCarteMembre = "SELECT carte_membre FROM utilisateurs WHERE nom = $nom_emprunteur AND prenom = $prenom_emprunteur";
            $resultCarteMembre = $dao->bdd->query($queryCarteMembre)->fetchColumn();

            if ($resultCarteMembre !== false) {
                // Requête SQL pour insérer un emprunt
                $queryInsert = "INSERT INTO emprunts (title, emprunt_date, retour_date, user_id, nom_emprunteur, carte_membre_emprunteur) 
                                VALUES ($title, $emprunt_date, $retour_date, $resultCarteMembre, $nom_emprunteur, $resultCarteMembre)";

                // Exécutez la requête d'insertion
                if ($dao->bdd->exec($queryInsert) !== false) {
                    // Mise à jour du statut du livre dans la table livres
                    $queryUpdate = "UPDATE livres SET Statut = 'Emprunté' WHERE title = $title";
                    $dao->bdd->exec($queryUpdate);

                    echo json_encode(array('success' => true, 'message' => 'Emprunté avec succès.'));
                   
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Erreur lors de l\'ajout de l\'emprunt : ' . $dao->bdd->errorInfo()[2]));
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Utilisateur non trouvé. Veuillez vérifier le nom et prénom.'));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Le livre n\'est pas disponible pour l\'emprunt.'));
        }

        // Fermez la connexion à la base de données
        $dao->disconnect();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Tous les champs du formulaire doivent être remplis.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'La requête n\'est pas de type POST.'));
}
?>
