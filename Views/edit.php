<?php

require_once '../Controllers/ElevesCrud.php';

$request = new EleveCrud;
$allEleves = $request->getOne($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Edit Eleve</title>
</head>

<body>
    <header class="mb-5">
        <h1 class=" text-center">Editer un élèves</h1>
    </header>
    <main class="container">
        <h2 class="text-center">Résultat élève</h2>
        <table class="table">
            <thead>
                <th scope="col">ID_étudiant</th>
                <th scope="col">Prenom</th>
                <th scope="col">Nom</th>
                <th scope="col">ID_examen</th>
            </thead>
            <tbody>
                <tr>
                    <td><?= $allEleves[0]['id_etudiant'] ?></td>
                    <td><?= $allEleves[0]['prenom'] ?></td>
                    <td><?= $allEleves[0]['nom'] ?></td>
                    <td><?= $allEleves[0]['id_examen'] ?></td>

                </tr>
            </tbody>
            <thead>

                <?php
                foreach ($allEleves as $info) {
                ?>
                    <td scope="col">Matières</td>
                    <td scope="col">Note</td>
                <?php
                }
                ?>
            </thead>
            <tbody>

                <?php
                foreach ($allEleves as $info) {
                ?>
                    <td><?= $info['matiere'] ?></td>
                    <td><?= $info['note'] ?></td>
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="">
            <a class="btn btn-primary" href="#">Editer</a>
            <a class="btn btn-danger" href="delete.php?id=<?= $allEleves[0]['id_etudiant'] ?>">supprimer</a>
        </div>
    </main>
</body>

</html>