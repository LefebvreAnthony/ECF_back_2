<?php
require_once '../Controllers/ElevesCrud.php';
session_start();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db = new EleveCrud;
    $db->delete($_GET['id']);
    $_SESSION['message'] = 'Success, Etudiant supprimé';
    header('Location: ../index.php');
} else {
    $_SESSION['erreur'] = 'ID introuvable';
    header('Location: ../index.php');
}
