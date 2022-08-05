<?php

if ($_POST) {
    if (
        isset($_POST['nom']) && !empty($_POST['nom']) &&
        isset($_POST['prenom']) && !empty($_POST['prenom'])
    ) {
        require_once '../Controllers/ElevesCrud.php';

        $request = new EleveCrud;

        $request->createOne($_POST['nom'], $_POST['prenom']);
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
    <title>Créer un étudiant</title>
</head>

<body>
    <main class="container d-flex flex-column vh-100 justify-content-center">
        <h1 class="text-center mb-5">Creer un étudiant</h1>
        <form method="POST">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom étudiant">
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom étudiant">
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-success">Ajouter</button>
            </div>
        </form>
    </main>
</body>

</html>