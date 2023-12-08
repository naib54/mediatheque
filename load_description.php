<?php
include('dao.php');

$dao = new DAO();
$dao->connexion();

if (isset($_GET['title'])) {
    $title = $_GET['title'];

    if (!empty($title)) {
        $selectStmt = $dao->bdd->prepare("SELECT * FROM livres WHERE title = :title");
        $selectStmt->bindParam(':title', $title, PDO::PARAM_STR);
        $selectStmt->execute();

        $livre = $selectStmt->fetch(PDO::FETCH_ASSOC);

        if (!$livre) {
            echo "Livre non trouvé.";
        } else {
            echo "<h2>{$livre['title']}</h2>";
            echo "<p>Auteur : {$livre['authors']}</p>";
            echo "<p>Description : {$livre['longDescription']}</p>"; // Utilisez longDescription ici
            // Ajoutez d'autres détails du livre selon votre structure de base de données
        }
    } else {
        echo "Titre de livre vide.";
    }
} else {
    echo "Titre de livre non spécifié.";
}

$dao->disconnect();
?>
