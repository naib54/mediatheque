<?php

/* inclusion de notre classe DAO */
require_once("dao.php");

// on crée une nouvelle instance, un objet de ma classe DAO */
$dao= new DAO();


//on se connecte
$dao->connexion();

if (isset($_GET["region"])&&$_GET["region"]) {
	$pays=$dao->getCountries($_GET["region"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
</head>

<form>
 <fieldset>
<legend>Livres</legend>
Titre livre <input type="text"><br>
Auteurlivre <input type="text"><br>
Resumé <input type="text"><br>
Categorie livre <select name="genre">
    <option value="Romans">Romans</option>
    <option value="Polars">Polars</option>
    <option value=" Science-Fiction" selected> Science-Fiction</option>
    </select><br>
Date de parution <input type="date"><br>
<button type="submit">Rechercher</button><br>
<button type="submit">Ajouter</button><br>
<button type="submit">Supprimer</button><br>
<button type="submit">Enregistrer</button><br>

 </fieldset>
</form>


<body>
  
</body>



</html>

<?php 
//on se déconnecte. TOUJOURS FERMER LA CONNEXION A LA BASE DE DONNEES
$dao->disconnect();
?>