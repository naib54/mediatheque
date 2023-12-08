<?php


$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "mediatheque";
$charset = "utf8";

// Connexion à la base de données
$connexion = new mysqli($host, $user, $password, $database);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
}

// Définir le jeu de caractères
$connexion->set_charset($charset);

// Charger le contenu du fichier JSON
$json_content = file_get_contents('books_2.json');

// Décoder le JSON en tableau associatif
$data = json_decode($json_content, true);

// Parcourir le tableau et insérer les données dans la table
foreach ($data as $livre) {
    $sql = "INSERT INTO livres (title, isbn, pageCount, publishedDate, thumbnailUrl, shortDescription, longDescription, status, authors, categories)
            VALUES (
                '" . $connexion->real_escape_string($livre['title']) . "',
                '" . $connexion->real_escape_string($livre['isbn']) . "',
                '" . $connexion->real_escape_string($livre['pageCount']) . "',
                '" . $connexion->real_escape_string($livre['publishedDate']['dt_txt']) . "',
                '" . $connexion->real_escape_string($livre['thumbnailUrl']) . "',
                '" . $connexion->real_escape_string($livre['shortDescription']) . "',
                '" . $connexion->real_escape_string($livre['longDescription']) . "',
                '" . $connexion->real_escape_string($livre['status']) . "',
                '" . $connexion->real_escape_string(implode(',', $livre['authors'])) . "',
                '" . $connexion->real_escape_string(implode(',', $livre['categories'])) . "'
            )";

    $connexion->query($sql);
}




// Fermer la connexion
$connexion->close();

echo "Importation terminée avec succès.";

?>