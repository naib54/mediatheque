
<?php
// Inclure la classe DAO
include('dao.php'); // Assurez-vous de spécifier le bon chemin vers votre classe DAO

// Créer une instance de la classe DAO
$dao = new DAO();

// Connexion à la base de données
$dao->connexion();

// Initialiser une variable pour stocker le message d'ajout
$message = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $title = $_POST["title"];
    $isbn = $_POST["isbn"];
    $authors = $_POST["authors"];
    $pageCount = $_POST["pageCount"];
    $categories = $_POST["categories"];
    $shortDescription = $_POST["shortDescription"];
    $longDescription = $_POST["longDescription"];

    // Exécuter la requête d'ajout du livre
    $insertStmt = $dao->bdd->prepare("INSERT INTO livres (title, isbn, authors, pageCount, categories, shortDescription, longDescription) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $success = $insertStmt->execute([$title, $isbn, $authors, $pageCount, $categories, $shortDescription, $longDescription]);

    // Vérifier si l'ajout a réussi
    if ($success) {
        $message = "Votre livre a bien été ajouté !";
    } else {
        $message = "Votre livre n'a pas pu être ajouté. Détails de l'erreur : " . implode(', ', $insertStmt->errorInfo());
    }
}

// Fermer la connexion
$dao->disconnect();

// Rediriger vers index.php avec le message en tant que paramètre d'URL
header('Location: index.php?message=' . urlencode($message));
exit;
?>
