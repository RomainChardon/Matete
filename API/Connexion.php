<?php
require('Annonce.php');
require('Categorie.php');
require('Lieu.php');
require('Producteur.php');
class Connexion{
    private $bdd;
    
    /**
     * __construct
     * Constructeur de la classe Connexion (Définir les identifiants de connexion à la BDD)
     * @return void
     */
    function __construct(){
        try {
            $this->bdd = new PDO('mysql:host=localhost; dbname=matete; charset=utf8', "root", "Lurcat2020");
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

        
    /**
     * RecupererAnnonces
     * Récupère les annonces ayant été mise en ligne
     * @return void
     */
    function RecupererAnnonces(){

        $requete = $this->bdd->prepare('SELECT * FROM annonce a INNER JOIN lieu l ON l.id = a.lieu_id INNER JOIN categorie c ON c.id = a.categorie_id INNER JOIN users u ON u.id = a.producteur_id');
        $requete->execute();
        $annoncesPOO = array();


        while ($row = $requete->fetch()) {
            $p = new Producteur($row['id'],$row['nom'],$row['prenom'],$row['tel'],$row['mail'],$row['mdp'],$row['roles']);
            $c = new Categorie($row['id'],$row['libelle']); 
            $l = new Lieu($row['id'],$row['coo_x'],$row['coo_y'],$row['desc_lieu'],$row['nom']);
            $a = new Annonce($row['id'],$row['lieu_id'],$row['categorie_id'],$row['producteur_id'],$row['creneaux_debut'],$row['creneaux_fin'],$row['libelle_produit'],$row['prix_unitaire'],$row['quantite'],$row['status'],$row['date_mise_en_ligne'],$l,$c,$p);
            if ($row['status'] == "EnLigne"){
                array_push($annoncesPOO,$a);
            }
            
        }
        return $annoncesPOO;
    }
    }

?>