<?php

abstract class CrudFunction
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
    protected function closeConnexion()
    {
        return $db = '';
    }

    private function pagination()
    {
    }
    protected function RequestSql(string $request)
    {
        $connexion = $this->getConnexion();
        $query = $connexion->prepare($request);


        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $connexion = $this->closeConnexion();

        return $result;
    }
}
