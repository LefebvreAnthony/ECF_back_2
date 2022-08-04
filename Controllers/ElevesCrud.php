<?php

require_once 'CrudFunction.php';

class EleveCrud
{
    private $dbName = 'root';
    private $password = '';

    private function getConnexion()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=ecf2_backend', $this->dbName, $this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        } catch (PDOException $e) {
            print 'Erreur ! : ' . $e->getMessage() . '<br>';
            die();
        }
    }

    private function closeConnexion()
    {
        return $db = '';
    }

    public function pagination()
    {
        $connexion = $this->getConnexion();

        $request = "SELECT COUNT(*) AS total FROM `etudiants`";

        $query = $connexion->prepare($request);
        $query->execute();

        $result = $query->fetch();
        $number = (int) $result['total'];

        $nbrPage = 6;

        $pages = ceil($number / $nbrPage);
        return $pages;
    }

    public function getAll(int $currentPage)
    {

        $nbrPage = 6;
        $first = ($currentPage * $nbrPage) - $nbrPage;


        $request = "SELECT etudiants.id_etudiant, prenom, nom, GROUP_CONCAT(note SEPARATOR ' ; ') AS note, AVG(note) AS moyenne
        FROM `etudiants` INNER JOIN `examens` ON `etudiants`.id_etudiant=`examens`.id_etudiant 
        GROUP BY `etudiants`.id_etudiant LIMIT :premier, :nbr;";
        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindValue(':premier', $first, PDO::PARAM_INT);
        $query->bindValue(':nbr', $nbrPage, PDO::PARAM_INT);


        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $connexion = $this->closeConnexion();
        return $result;
    }

    public function getOne(int $id)
    {
        $id = strip_tags($id);

        $request = "SELECT etudiants.id_etudiant, prenom, nom, note, matiere, id_examen
        FROM `etudiants` 
        INNER JOIN `examens` 
        ON `etudiants`.id_etudiant=`examens`.id_etudiant 
        WHERE `etudiants`.id_etudiant =:id; ";

        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $connexion = $this->closeConnexion();

        return $result;
    }

    public function updateOne($id, $prenom = null, $nom = null)
    {
        $id = strip_tags($id);

        $request = "SELECT etudiants.id_etudiant, prenom, nom, note, matiere, id_examen
        FROM `etudiants` 
        INNER JOIN `examens` 
        ON `etudiants`.id_etudiant=`examens`.id_etudiant 
        WHERE `etudiants`.id_etudiant =:id; ";

        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $connexion = $this->closeConnexion();

        return $result;
    }

    public function delete(int $id)
    {
        $id = strip_tags($id);

        $requests = ["DELETE FROM `etudiants` WHERE `etudiants`.id_etudiant=:id;", "DELETE FROM `examens` WHERE `examens`.id_etudiant = :id "];

        $connexion = $this->getConnexion();

        foreach ($requests as $req) {
            var_dump($req);
            $query = $connexion->prepare($req);

            $query->bindValue(':id', $id, PDO::PARAM_INT);

            $query->execute();
        }

        return ['code' => 'Etudiant supprimé'];
    }
}
