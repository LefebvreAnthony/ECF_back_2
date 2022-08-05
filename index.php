<?php

require_once './Controllers/ElevesCrud.php';

$request = new EleveCrud;

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
    $pages = $request->pagination();

    $allEleves = $request->getAll($_GET['page']);
} else {
    $pages = $request->pagination();
    $currentPage = 1;
    $allEleves = $request->getAll($currentPage);
}

if ($_GET) {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $request->searchOne($_GET['search']);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Accueil</title>
</head>

<body>
    <header class="mb-5">
        <h1 class=" text-center">Accueil gestion d'élèves</h1>
        <form method="GET" class="container">
            <div class="input-group my-5 px-5">
                <input class="form-control" type="search" name="search" id="search" placeholder="Rechercher un étudiant">
                <div class="input-group-append">
                    <button class="btn btn-primary input-group-text">Rechercher</button>
                </div>
            </div>
        </form>
        <?php
        if (!empty($_GET['search'])) {

        ?>
            <div class="container mb-5">
                <h2 class="text-center">Résultats recherche :</h2>
                <table class="table">
                    <thead>
                        <th scope="col">ID_etudiant</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($search as $info) {
                        ?>
                            <tr>
                                <td><?= $info['id_etudiant'] ?></td>
                                <td><?= $info['prenom'] ?></td>
                                <td><?= $info['nom'] ?></td>
                                <td><a class="btn btn-primary" href="./Views/edit.php?id=<?= $info['id_etudiant'] ?>">modifier</a></td>
                                <td><a class="btn btn-danger" href="./Views/delete.php?id=<?= $info['id_etudiant'] ?>">supprimer</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>

    </header>
    <main class="container">
        <div class="mb-3">
            <h2 class="text-center">Tableau d'élèves</h2>
            <!-- <a href="./Views/createStudent.php" class="btn btn-success">Ajouter un étudiant</a href="./Views/createStudent.php"> -->
        </div>
        <table class="table">
            <thead>
                <th scope="col">ID_etudiant</th>
                <th scope="col">Prenom</th>
                <th scope="col">Nom</th>
                <th scope="col">Notes</th>
                <th scope="col">Moyenne générale</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </thead>
            <tbody>
                <?php
                foreach ($allEleves as $info) {
                ?>
                    <tr>
                        <td><?= $info['id_etudiant'] ?></td>
                        <td><?= $info['prenom'] ?></td>
                        <td><?= $info['nom'] ?></td>
                        <td><?= $info['note'] ?></td>
                        <td><?= $info['moyenne'] ?></td>
                        <td><a class="btn btn-primary" href="./Views/edit.php?id=<?= $info['id_etudiant'] ?>">modifier</a></td>
                        <td><a class="btn btn-danger" href="./Views/delete.php?id=<?= $info['id_etudiant'] ?>">supprimer</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <nav class="row ">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>"><a class="page-link" href="index.php?page=<?= $currentPage - 1 ?>">Précédente</a></li>
                <?php
                for ($i = 1; $i < $pages + 1; $i++) {
                ?>
                    <li class="page-item <?= ($currentPage == $i) ? "disabled" : "" ?>"><a class="page-link" href="index.php?page=<?= $i ?>"><?= $i ?></a></li>
                <?php
                }
                ?>
                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>"><a class="page-link" href="index.php?page=<?= $currentPage + 1 ?>">Suivante</a></li>
            </ul>
        </nav>
    </main>
</body>

</html>