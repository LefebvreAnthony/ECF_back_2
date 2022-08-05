<?php

require_once '../Controllers/ElevesCrud.php';

$request = new EleveCrud;
$allEleves = $request->getOne($_GET['id']);

if ($_POST) {
    var_dump($_POST);
    if (
        isset($_POST['prenom']) && !empty(['prenom']) &&
        isset($_POST['nom']) && !empty(['nom'])
    ) {
        $request->updateOne($_GET['id'], $_POST['prenom'], $_POST['nom']);
        echo "<meta http-equiv='refresh' content='0'>";
    } else if (
        isset($_POST['note']) && !empty(['note'])
    ) {
        $request->updateOneNote($_POST['id'], $_POST['note']);
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

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
        <h1 class=" text-center">Editer un élève</h1>
    </header>
    <main class="container">
        <h2 class="text-center">Elève <?= $allEleves[0]['prenom'] . " " . $allEleves[0]['nom'] ?></h2>
        <table class="table">
            <form method="POST">
                <thead>
                    <th scope="col">ID_étudiant</th>
                    <th scope="col"><label for="prenom">Prénom</label></th>
                    <th scope="col"><label for="nom">Nom</label></th>
                    <th scope="col">Modifier</th>
                    <th scope="col">Supprimer</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $allEleves[0]['id_etudiant'] ?></td>
                        <td>
                            <input type="text" name="prenom" id="prenom" value="<?= $allEleves[0]['prenom'] ?>">
                        </td>
                        <td>
                            <input type="text" name="nom" id="nom" value="<?= $allEleves[0]['nom'] ?>">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="delete.php?id=<?= $allEleves[0]['id_etudiant'] ?>">supprimer</a>
                        </td>

                    </tr>
                </tbody>
            </form>
        </table>
        <h2 class="text-center mt-5">Notes & Matières</h2>
        <table class="table">
            <thead>
                <td scope="col">Matières</td>
                <td scope="col"><label for="note">Notes</label></td>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </thead>
            <tbody>

                <?php
                foreach ($allEleves as $info) {
                ?>
                    <form method="POST">
                        <input class="invisible" type="number" name="id" id="id" value="<?= $info['id'] ?>">
                        <tr>
                            <td><?= $info['matiere'] ?></td>
                            <td>
                                <input type="number" name="note" id="note" step="0.01" value="<?= $info['note'] ?>">
                            </td>
                            <td>
                                <button type="submit" class=" btn btn-primary">Modifier</button>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="deleteNote.php?id=<?= $info['id'] ?>">supprimer</a>
                            </td>
                        </tr>
                    </form>
                <?php
                }
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>