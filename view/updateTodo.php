<?php 
    require_once '../service/dbConnect.php';

    // Démarrer la session
    session_start();
    
    // Vérifier la non-existance de la clé userId dans $_SESSION
    if(!isset($_SESSION['userId'])){
        header('location: ./signin.php');
        exit();
    }

    // Je récupère l'id en paramètre de l'url avec $_GET
    $idTodo = $_GET['id'];
   

    // Au chargement de la page, je souhaite envoyer une requète de type SELECT pour afficher le titre et la description dans le formulaire.
    $sql = "SELECT * FROM todo WHERE id = :idTodo";

    // Je verifie si j'ai accés à une instance de connexion PDO
    if (isset($db_connexion)) {
        $statement = $db_connexion->prepare($sql);
    }

    // Dans $statment j'associe les paramètre nommés avec les bonne variable
    $statement->bindParam(':idTodo', $idTodo);

    // J'exécute la requète paramétre nommé (requète securisées)
    $statement->execute();

    // Dans une variable, je stock le todo récupéré
    $todo = $statement->fetch();
    
    // je recupère le title et la description du todo
    $title = $todo['title'];
    $description = $todo['description'];

    // Si le chargement de cette ressource fait suite à la soumission du formulaire, alor on autorise le traitement des données.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ok'])) {

        // Sécuriser les données dans $_POST
        $_POST = filter_input_array(INPUT_POST, [
            'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ]);

        // Je récupèrer les valeur de $_POST et celle qui manquent (createdAt par exemple) dans des variable
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Ecrire la requète SQL de type UPDATE
        $sql = 'UPDATE todo SET title = :title, description = :description WHERE id = :idTodo;';

        // La préparer
        if (isset($db_connexion)) {
            $statement = $db_connexion->prepare($sql);
        }

        // Associer les paramètres avecc les variable
        $statement->bindParam(':title', $title);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':idTodo', $idTodo);

        // Envoyer la requète 
        $statement->execute();

        // Si tout est ok, faire la redirection
        $nb = $statement->rowCount();       
        if ($nb === 1) {
            header('location: ./homeConnected.php');
            exit();
        }
    }

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpDateTodo |</title>
</head>
<body>
    <h1>Modifier votre Todo</h1>
    <form action="#" method="POST">
        <div>
            <label for="idTitle">Titre</label>
            <input type="text" id="idTitle" name="title" value="<?= htmlspecialchars($title); ?>" required> 
        </div>
        <div>
            <label for="idDescription">Description</label>
            <textarea name="description" id="idDescription" cols="50" rows="10" required><?= htmlspecialchars($title); ?></textarea>
        </div>
        <div>
            <input type="submit" name="ok">
        </div>

    </form>
</body>
</html>