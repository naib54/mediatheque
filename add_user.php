<?php
require_once 'dao.php';

// Assurez-vous que la session est démarrée
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assurez-vous que les données du formulaire sont présentes et non vides
    if (!empty($_POST['lastname']) && !empty($_POST['name']) && !empty($_POST['member_id'])) {
        // Récupérez les valeurs du formulaire
        $nom = $_POST['lastname'];
        $prenom = $_POST['name'];
        $carte_membre = $_POST['member_id'];

        try {
            // Connexion à la base de données
            $dao = new DAO();
            $dao->connexion();

            // Vérifier si l'utilisateur existe déjà dans la base de données
            $queryCheckUser = "SELECT COUNT(*) FROM utilisateurs WHERE carte_membre = :carte_membre";
            $statementCheckUser = $dao->bdd->prepare($queryCheckUser);
            $statementCheckUser->bindParam(':carte_membre', $carte_membre);
            $statementCheckUser->execute();
            $userCount = $statementCheckUser->fetchColumn();

            if ($userCount > 0) {
                // L'utilisateur existe déjà, stockez un message d'erreur dans la session
                $_SESSION['error_message'] = "L'utilisateur avec le numéro de carte membre $carte_membre existe déjà.";
            } else {
                // L'utilisateur n'existe pas encore, procédez à l'ajout
                $queryInsertUser = "INSERT INTO utilisateurs (nom, prenom, carte_membre) VALUES (:nom, :prenom, :carte_membre)";
                $statementInsertUser = $dao->bdd->prepare($queryInsertUser);
                $statementInsertUser->bindParam(':nom', $nom);
                $statementInsertUser->bindParam(':prenom', $prenom);
                $statementInsertUser->bindParam(':carte_membre', $carte_membre);

                if ($statementInsertUser->execute()) {
                    // Utilisateur ajouté avec succès
                    $_SESSION['success_message'] = "Utilisateur ajouté avec succès.";
                } else {
                    // En cas d'échec de l'ajout de l'utilisateur
                    throw new Exception("Erreur lors de l'ajout de l'utilisateur : " . $statementInsertUser->errorInfo()[2]);
                }
            }
        } catch (Exception $e) {
            // Stockez le message d'erreur dans la session
            $_SESSION['error_message'] = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
        } finally {
            // Fermez la connexion à la base de données
            if (isset($dao)) {
                $dao->disconnect();
            }
        }
    } else {
        // Si certains champs sont manquants
        $_SESSION['error_message'] = "Tous les champs du formulaire doivent être remplis.";
    }

    // Vérifiez s'il y a un message de succès ou d'erreur
    if (isset($_SESSION['success_message'])) {
        // Si un message de succès est présent, redirigez vers la page principale
        header('Location: index.php');
        exit();
    } elseif (isset($_SESSION['error_message'])) {
        // S'il y a une erreur, restez sur la page actuelle pour afficher le message
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Si la requête n'est pas de type POST
    $_SESSION['error_message'] = "La requête n'est pas de type POST.";
    // Redirigez vers la page principale en cas d'erreur
    header('Location: index.php');
    exit();
}
?>
