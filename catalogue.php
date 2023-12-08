<?php
// Inclure la classe DAO
include('dao.php'); // Assurez-vous de spécifier le bon chemin vers votre classe DAO

try {
    // Créer une instance de la classe DAO
    $dao = new DAO();

    // Connexion à la base de données
    $dao->connexion();

    // Sélectionner tous les livres avec leur statut
    $selectStmt = $dao->bdd->prepare("SELECT title, thumbnailUrl, statut FROM livres");

    if (!$selectStmt) {
        throw new Exception("Erreur de préparation de la requête SQL.");
    }

    if (!$selectStmt->execute()) {
        throw new Exception("Erreur lors de l'exécution de la requête SQL.");
    }

    // Récupérer les résultats
    $livres = $selectStmt->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les livres dans un tableau HTML
    echo '<table>
            <thead>
                <tr>
                    <th>Titre du Livre</th>
                    <th>Statut</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($livres as $livre) {
        echo '<tr>
                <td class="title">' . htmlspecialchars($livre['title']) . '</td>
                <td>' . htmlspecialchars($livre['statut']) . '</td>
                <td><img src="' . htmlspecialchars($livre['thumbnailUrl']) . '" alt="' . htmlspecialchars($livre['title']) . '" style="max-width: 100px; max-height: 100px;"></td>
                <td><button class="description-btn" data-title="' . $livre['title'] . '">Description</button></td>
              </tr>';
    }

    echo '</tbody></table>';
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

// Fermer la connexion
$dao->disconnect();
?>
