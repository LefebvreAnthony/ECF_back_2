<?php


class EleveCrud
{
    private $dbName = 'root';
    private $password = '';
    private $db = "";


    // LANCE CONNEXION DB METHOD
    private function getConnexion()
    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=ecf2_backend', $this->dbName, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->db;
        } catch (PDOException $e) {
            print 'Erreur ! : ' . $e->getMessage() . '<br>';
            die();
        }
    }

    // FERME LA CO DB METHOD
    private function closeConnexion()
    {
        return $this->db = '';
    }

    // CALCULER NOMBRES DETUDIANTS PAR PAGE METHOD
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

    // CREATE ETUDIANT METHOD

    // public function createOne(string $nom, string $prenom)
    // {
    //     $nom = strip_tags($nom);
    //     $prenom = strip_tags($prenom);
    //     $nom = ucfirst($nom);
    //     $prenom = ucfirst($prenom);

    //     // $request = "INSERT INTO `etudiants` (nom, prenom) VALUES (:nom, :prenom);";

    //     // $connexion = $this->getConnexion();
    //     // $query = $connexion->prepare($request);
    //     // $query->bindParam(':nom', $nom, pdo::PARAM_STR);
    //     // $query->bindParam(':prenom', $prenom, pdo::PARAM_STR);

    //     // $query->execute();

    //     // FOR GO TO PAGE
    //     $request = "SELECT id_etudiant FROM `etudiants` ORDER BY `etudiants`.id_etudiant DESC;";

    //     $connexion = $this->getConnexion();
    //     $query = $connexion->prepare($request);

    //     $query->execute();

    //     $id = $query->fetch(PDO::FETCH_ASSOC);
    //     var_dump($id);
    //     $id = (int) $id['id_etudiant'];
    //     var_dump($id);
    //     $connexion = $this->closeConnexion();

    //     return header('Location: ../Views/edit.php?id=' . $id);
    // }

    // RECHERCHER TOUT LES ETUDIANTS METHOD
    public function getAll(int $currentPage)
    {

        $nbrPage = 6;
        $first = ($currentPage * $nbrPage) - $nbrPage;


        $request = "SELECT etudiants.id_etudiant, prenom, nom, GROUP_CONCAT(note SEPARATOR '<br>') AS note, AVG(note) AS moyenne
        FROM `etudiants` INNER JOIN `examens` ON `etudiants`.id_etudiant=`examens`.id_etudiant 
        GROUP BY `etudiants`.id_etudiant LIMIT :premier, :nbr;";
        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindParam(':premier', $first, PDO::PARAM_INT);
        $query->bindParam(':nbr', $nbrPage, PDO::PARAM_INT);


        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $connexion = $this->closeConnexion();
        return $result;
    }

    // RECCUPERER UN ETUDIANT AVEC ID METHOD
    public function getOne(int $id)
    {
        $id = strip_tags($id);

        $request = "SELECT etudiants.id_etudiant, prenom, nom, note, AVG(note) AS moyenne, matiere,`examens`.id
        FROM `etudiants` 
        INNER JOIN `examens` 
        ON `etudiants`.id_etudiant=`examens`.id_etudiant 
        WHERE `etudiants`.id_etudiant =:id; ";

        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $connexion = $this->closeConnexion();

        return $result;
    }
    // RECHERCHER UN ETUDIANT METHOD
    public function searchOne(string $etudiant)
    {
        $etudiant = explode(' ', $etudiant);

        $etudiantName = strip_tags($etudiant[0]);
        $etudiantName = ucfirst($etudiantName);
        $etudiantName = "%$etudiantName%";

        if (count($etudiant) > 1) {
            $etudiantLastName = strip_tags($etudiant[1]);
            $etudiantLastName = ucfirst($etudiantLastName);
            $etudiantLastName = "%$etudiantLastName%";
        } else {
            $etudiantLastName = "%null%";
        }

        $request = "SELECT nom, prenom, id_etudiant
        FROM `etudiants` 
        WHERE prenom LIKE :etudiant
        OR nom LIKE :etudiant 
        OR prenom LIKE :etudiantName AND nom LIKE :etudiantLastName 
        OR prenom LIKE :etudiantLastName AND nom LIKE :etudiantName";

        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindParam(':etudiant', $etudiantName, pdo::PARAM_STR);
        $query->bindParam(':etudiantName', $etudiantName, pdo::PARAM_STR);
        $query->bindParam(':etudiantLastName', $etudiantLastName, pdo::PARAM_STR);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    // UPDATE ETUDIANT METHOD
    public function updateOne(int $id, string $prenom, string $nom)
    {
        $id = strip_tags($id);
        $prenom = strip_tags($prenom);
        $nom = strip_tags($nom);

        $request = "UPDATE `etudiants` SET
            prenom = :prenom,
            nom = :nom 
            WHERE id_etudiant = :id
        ;";

        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindParam(':nom', $nom, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();

        $connexion = $this->closeConnexion();
    }

    // UPDATE ONE NOTE METHOD
    public function updateOneNote(int $id, float $note)
    {
        $id = strip_tags($id);
        $note = strip_tags($note);

        $request = "UPDATE `examens` SET
            note = :note
            WHERE id = :id
        ;";

        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);
        $query->bindParam(':note', $note, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();

        $connexion = $this->closeConnexion();

        return 'yes';
    }
    // DELETE ETUDIANT WITH EXAMENS METHOD
    public function delete(int $id)
    {
        $id = strip_tags($id);

        $requests = ["DELETE FROM `etudiants` WHERE `etudiants`.id_etudiant=:id;", "DELETE FROM `examens` WHERE `examens`.id_etudiant = :id "];

        $connexion = $this->getConnexion();

        foreach ($requests as $req) {
            var_dump($req);
            $query = $connexion->prepare($req);

            $query->bindParam(':id', $id, PDO::PARAM_INT);

            $query->execute();
        }

        $connexion = $this->closeConnexion();

        return ['code' => 'Etudiant supprimé'];
    }

    // DELETE NOTE METHOD
    public function deleteNote(int $id)
    {
        $id = strip_tags($id);

        $request = "DELETE FROM `examens` WHERE `examens`.id = :id ";

        $connexion = $this->getConnexion();

        $query = $connexion->prepare($request);

        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();

        $connexion = $this->closeConnexion();

        return ['code' => 'Note supprimée'];
    }
}
