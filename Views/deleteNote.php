<?php
require_once '../Controllers/ElevesCrud.php';
session_start();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $db = new EleveCrud;
    $db->deleteNote($_GET['id']);
    $_SESSION['message'] = 'Success, Note supprimée';
    header('Location: ./edit.php?id=' . $_GET['id']);
} else {
    $_SESSION['erreur'] = 'ID introuvable';
    header('Location: ../index.php');
}
