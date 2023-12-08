<?php

class DAO {
    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "";
    private $database = "mediatheque";
    private $charset = "utf8";
    public $bdd;
    private $error;

    public function __construct() {
    }


    
    public function connexion() {
        try {
            // On se connecte à MySQL
            $this->bdd = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset,
                $this->user,
                $this->password
            );


        } catch (Exception $e) {
            // En cas d'erreur, on affiche un message
            $this->error = 'Erreur : ' . $e->getMessage();
        }
    }

    /* méthode pour fermer la connexion à la base de données */
    public function disconnect() {
        $this->bdd = null;
    }

    /* méthode pour récupérer la dernière erreur fournie par le serveur mysql */
    public function getLastError() {
        return $this->error;
    }

    
}
