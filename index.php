<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médiathèque</title>
</head>

<body>
<nav class="navbar" sticky-top>
  
  <a href="#" class="logo">Application de Gestion de Bibliothèque</a> 
 <div class="nav-links">
     <ul>
         <li> <a href="#"> Home</a></li>
         <li> <a href="#">Se déconnecte</a></li>
     </ul> 
 </div>
 <div class="group">
    <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
        <g>
            <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
        </g>
    </svg>
    <input placeholder="Search" type="search" class="input">
</div>
</nav>
<h1>Ajouter un utilisateur</h1>

<form action="add_user.php" method="post">
    <!-- Champs pour ajouter un utilisateur -->
    <label for="lastname">Nom :</label>
    <input type="text" id="lastname" name="lastname" required><br>

    <label for="name">Prénom :</label>
    <input type="text" id="name" name="name" required><br>

    <label for="member_id">Numéro carte de membre :</label>
    <input type="text" id="member_id" name="member_id" required><br>

    <div>
        <button class="btn"><i class="animation"></i>AJOUTER<i class="animation"></i></button>
    </div>
    <!-- Affichage des messages en bas de la page -->
    <?php
    session_start();

    if (isset($_SESSION['success_message'])) {
        echo '<div id="messageContainer">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']); // Effacez le message après l'avoir affiché
    } elseif (isset($_SESSION['error_message'])) {
        echo '<div id="messageContainer">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Effacez le message après l'avoir affiché
    }

    session_destroy(); // Facultatif : détruisez la session
    ?>
</form>

    <button id="listeUtilisateursBtn">Afficher la liste des utilisateurs</button>
    <div id="resultatUtilisateurs"></div>
    
    <h1>Supprimer un livre</h1>
    <form action="delete_books.php" method="post">
        <!-- Champs pour supprimer un livre -->
        <label for="titre_supprimer">Titre du livre à supprimer :</label>
        <input type="text" id="titre_supprimer" name="title" required>
        <div>
    <button class="btn"><i class="animation"></i>SUPPRIMER<i class="animation"></i>
    </button>
</div>
    
    <div id="successMessage"></div></form>
    

    <h1>Emprunter un livre</h1>
    <div id="empruntMessageContainer"></div>
    <form id="empruntForm" action="emprunter.php" method="post">
        <!-- Champs pour emprunter un livre -->
        <label for="title">Titre du livre à emprunter :</label>
        <input type="text" id="title" name="title" required><br>

        <!-- Champs pour l'utilisateur -->
        <label for="nom_emprunteur">Nom de l'emprunteur :</label>
        <input type="text" id="nom_emprunteur" name="nom_emprunteur" required><br>

        <label for="prenom_emprunteur">Prénom de l'emprunteur :</label>
        <input type="text" id="prenom_emprunteur" name="prenom_emprunteur" required><br>

        <!-- Retiré le champ de saisie de la carte membre -->

        <label for="emprunt_date">Date d'emprunt :</label>
        <input type="date" id="emprunt_date" name="emprunt_date" required><br>

        <label for="retour_date">Date de retour :</label>
        <input type="date" id="retour_date" name="retour_date" required><br>

        <div>
    <button class="btn"><i class="animation"></i>EMPRUNTER<i class="animation"></i> 
    </button>
</div> 
    </form> 

    <button id="listeEmpruntsBtn">Afficher la liste des livres empruntés</button>

<div id="resultatEmprunts"></div>
   


    
<div id="messageContainer"></div>

    
    
    <button id="catalogueBtn" onclick="loadCatalogue()">Catalogue</button>
    
    
    <div id="catalogueContainer">
        <!-- La liste des livres sera chargée ici via AJAX -->
    </div>

    
    <div id="descriptionContainer"></div>

    
    <h1>Ajouter un livre</h1>
<form id="addBookForm" action="add_book.php" method="post">
        <!-- Champs pour ajouter un livre -->
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required><br>

        <label for="isbn">Numéro ISBN :</label>
        <input type="text" id="isbn" name="isbn" required><br>

        <label for="authors">Auteurs :</label>
        <input type="text" id="authors" name="authors" required><br>

        <label for="pageCount">Nombre de pages :</label>
        <input type="text" id="pageCount" name="pageCount"><br>

        <label for="categories">Catégorie :</label>
        <input type="text" id="categories" name="categories"><br>

        <label for="shortDescription">Description courte :</label>
        <textarea id="shortDescription" name="shortDescription" rows="4"></textarea><br>

        <label for="longDescription">Description longue :</label>
        <textarea id="longDescription" name="longDescription" rows="10"></textarea><br>

        <br>
        <div>
    <button class="btn"><i class="animation"></i>AJOUTER<i class="animation"></i>
    </button>
</div>
    <?php
    // Vérifier si un message est présent dans l'URL
    if (isset($_GET['message'])) {
        echo urldecode($_GET['message']);
    }
    ?>
</div>
        
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var catalogueVisible = false; // Variable pour suivre l'état de la liste des livres

        function loadCatalogue() {
            // Vérifier si la liste des livres est visible
            if (catalogueVisible) {
                // Si elle est visible, la cacher
                $('#catalogueContainer').html('');
                catalogueVisible = false;
            } else {
                // Si elle n'est pas visible, charger dynamiquement la liste des livres
                $.ajax({
                    url: 'catalogue.php',
                    method: 'GET',
                    success: function (data) {
                        $('#catalogueContainer').html(data);
                        catalogueVisible = true;
                    },
                    error: function () {
                        alert('Erreur lors du chargement du catalogue.');
                    }
                });
            }
        }

        $(document).ready(function () {
    var listeEmpruntsVisible = false;

    $('#listeEmpruntsBtn').click(function () {
        // Vérifier si la liste des emprunts est visible
        if (listeEmpruntsVisible) {
            // Si elle est visible, la cacher
            $('#resultatEmprunts').html('');
            listeEmpruntsVisible = false;
        } else {
            // Si elle n'est pas visible, charger dynamiquement la liste des emprunts
            $.ajax({
                url: 'liste_livres_empruntes.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Construire le tableau HTML avec les données JSON
                    var tableHtml = '<table border="1"><thead><tr><th>ID Emprunt</th><th>Titre du Livre</th><th>Nom de l\'Emprunteur</th><th>Date d\'Emprunt</th><th>Date de Retour</th></tr></thead><tbody>';

                    // Parcourir les données et construire chaque ligne du tableau
                    data.forEach(function (emprunt) {
                        tableHtml += '<tr><td>' + emprunt.id + '</td><td>' + emprunt.title + '</td><td>' + emprunt.nom_emprunteur +  '</td><td>' + emprunt.emprunt_date + '</td><td>' + emprunt.retour_date + '</td></tr>';
                    });

                    tableHtml += '</tbody></table>';

                    // Afficher le tableau dans une zone de la page
                    $('#resultatEmprunts').html(tableHtml);
                    listeEmpruntsVisible = true;
                },
                error: function () {
                    alert('Erreur lors du chargement de la liste des livres empruntés.');
                }
            });
        }
    });
});


        $(document).ready(function () {
    // Intercepter la soumission du formulaire de suppression
    $('form[action="delete_books.php"]').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'delete_books.php',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Afficher le message de succès
                    $('#successMessage').html('<p>' + response.message + '</p>');
                } else {
                    // Afficher le message d'erreur
                    alert(response.message);
                }
            },
            error: function () {
                alert('Erreur lors de la communication avec le serveur.');
            }
        });
    });
});
        $(document).ready(function () {
            function loadDescription(title, button) {
                // Récupérer le conteneur de la description
                var descriptionContainer = button.closest('tr').next('.description-container');

                // Vérifier si la description est déjà visible
                if (descriptionContainer.length > 0) {
                    // Si elle est visible, la cacher et retirer l'attribut personnalisé
                    descriptionContainer.remove();
                    button.removeAttr('data-description-visible');
                } else {
                    // Charger dynamiquement la longueDescription via AJAX
                    $.ajax({
                        url: 'load_description.php',
                        method: 'GET',
                        data: { title: title },
                        success: function (data) {
                            // Créer un conteneur pour la description s'il n'existe pas
                            descriptionContainer = $('<tr class="description-container">')
                                .append('<td colspan="3"><p>' + data + '</p></td>');

                            // Insérer la longueDescription après la ligne du titre du livre correspondant
                            button.closest('tr').after(descriptionContainer);

                            // Ajouter un attribut pour indiquer que la description est visible
                            button.attr('data-description-visible', true);
                        },
                        error: function () {
                            alert('Erreur lors du chargement de la description.');
                        }
                    });
                }
            }

            // Utiliser la délégation d'événements pour les boutons générés dynamiquement
            $(document).on('click', '.description-btn', function () {
                var title = $(this).data('title');
                loadDescription(title, $(this));
            });
        });

        $(document).ready(function () {
            var listeUtilisateursVisible = false;

            $('#listeUtilisateursBtn').click(function () {
                // Vérifier si la liste des utilisateurs est visible
                if (listeUtilisateursVisible) {
                    // Si elle est visible, la cacher
                    $('#resultatUtilisateurs').html('');
                    listeUtilisateursVisible = false;
                } else {
                    // Si elle n'est pas visible, charger dynamiquement la liste des utilisateurs
                    $.ajax({
                        url: 'liste_utilisateurs.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            // Construire le tableau HTML avec les données JSON
                            var tableHtml = '<table border="1"><thead><tr><th>ID Utilisateur</th><th>Nom</th><th>Prénom</th><th>Carte Membre</th><th>Livre Emprunté</th></tr></thead><tbody>';

                            // Parcourir les données et construire chaque ligne du tableau
                            data.forEach(function (utilisateur) {
                                tableHtml += '<tr><td>' + utilisateur.id_utilisateur + '</td><td>' + utilisateur.nom + '</td><td>' + utilisateur.prenom + '</td><td>' + utilisateur.carte_membre + '</td><td>' + (utilisateur.livre_emprunte ? utilisateur.livre_emprunte : 'Aucun') + '</td></tr>';
                            });

                            tableHtml += '</tbody></table>';

                            // Afficher le tableau dans une zone de la page
                            $('#resultatUtilisateurs').html(tableHtml);
                            listeUtilisateursVisible = true;
                        },
                        error: function () {
                            alert('Erreur lors du chargement de la liste des utilisateurs.');
                        }
                    });
                }
            });
        });

        $(document).ready(function () {
        // Intercepter la soumission du formulaire d'emprunt
        $('#empruntForm').submit(function (e) {
            e.preventDefault(); // Empêcher le formulaire de se soumettre normalement

            // Envoyer les données du formulaire via AJAX
            $.ajax({
                url: 'emprunter.php',
                method: 'POST',
                data: $(this).serialize(), // Envoie les données du formulaire
                dataType: 'json', // Attend une réponse JSON du serveur
                success: function (response) {
                    console.log(response); // Ajoutez cette ligne
    $('#messageContainer').html('<p>' + response.message + '</p>');
    if (response.success) {
        $('#empruntForm')[0].reset();
    }
                    // Mettre à jour le messageContainer avec le message reçu
                    $('#messageContainer').html('<p>' + response.message + '</p>');

                    // Effacer le formulaire si l'emprunt est réussi
                    if (response.success) {
                        $('#empruntForm')[0].reset();
                    }
                },
                error: function () {
                    alert('Erreur lors de la communication avec le serveur.');
                }
            });
        });
    });

    </script>
     </script>
    <footer>
    <button id="twit">
    <svg viewBox="0 0 16 16" class="bi bi-twitter" fill="currentColor" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
    </svg>
    <span>Twitter</span>
</button>

    <p>Copyright © 2023 DWWM</p>
    </footer>
</body>

</html>