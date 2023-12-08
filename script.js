function showBooks() {
    hideAllSections();
    document.getElementById("books").style.display = "block";
}

function showUsers() {
    hideAllSections();
    document.getElementById("users").style.display = "block";
}

function showBorrows() {
    hideAllSections();
    document.getElementById("borrows").style.display = "block";
}

function hideAllSections() {
    document.getElementById("books").style.display = "none";
    document.getElementById("users").style.display = "none";
    document.getElementById("borrows").style.display = "none";
}
function addBook() {
    // Récupérer les valeurs du formulaire
    var title = document.getElementById("title").value;
    var author = document.getElementById("author").value;
    var summary = document.getElementById("summary").value;
    var publicationDate = document.getElementById("publicationDate").value;
    var category = document.getElementById("category").value;

    // Validation des données (vous pouvez ajouter une logique de validation supplémentaire)

    // Ajouter le livre à la liste ou à la base de données
    var bookList = document.getElementById("bookList");
    var newBook = document.createElement("div");
    newBook.innerHTML = `<strong>${title}</strong> - ${author} (${publicationDate})<br>${summary}<br>Catégorie: ${category}<hr>`;
    bookList.appendChild(newBook);

    // Réinitialiser le formulaire
    document.getElementById("bookForm").reset();
}

function addBook() {
    var title = document.getElementById("bookTitle").value;
    var author = document.getElementById("bookAuthor").value;

    // Logique pour ajouter le livre à la base de données ou à la liste des livres
    console.log(`Livre ajouté : ${title} par ${author}`);

    // Réinitialiser le formulaire
    document.getElementById("addBookForm").reset();
}

function addUser() {
    var name = document.getElementById("userName").value;
    var email = document.getElementById("userEmail").value;

    // Logique pour ajouter l'utilisateur à la base de données ou à la liste des utilisateurs
    console.log(`Utilisateur ajouté : ${name} (${email})`);

    // Réinitialiser le formulaire
    document.getElementById("addUserForm").reset();
}