<?php 
    require_once '../service/dbConnect.php';
    
    // Démarrer la session
    session_start();

    // Vérifier la non-existance de la clé userId dans $_SESSION
    if(!isset($_SESSION['userId'])){
        header('location: ./signin.php');
        exit();
    }
    
    // Si le chargement de cette ressource fait suite à la soumission du formulaire, alor on autorise le traitement des données.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ok'])) {

        // Sécuriser les données dans $_POST
        $_POST = filter_input_array(INPUT_POST, [
            'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ]);

        // Je récupèrer les valeur de $_POST et celle qui manquent (createdAt par exemple) dans des variable
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        $idTodo = $_SESSION['userId'];

        // Vérifier les champ requi pour gérer les eurreurs
        if(!$title){
            $errors['title'] = ERROR_REQUIRED;
        }
        if(!$description){
            $errors['description'] = ERROR_REQUIRED;
        }


        // Au chargement de la page, je souhaite envoyer une requète de type SELECT pour afficher le titre et la description dans le formulaire.
        $sql = "INSERT INTO todo (title, description, author) Values(:title, :description, :id);";

        // Je verifie si j'ai accés à une instance de connexion PDO
        if (isset($db_connexion)) {
            $statement = $db_connexion->prepare($sql);
        }

        // J'associe les paramètres nommées avec les bonnes variables
        $statement->bindParam(':title', $title);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':id', $idTodo);

        // Je l'exécute
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
    <title>CreateTodo | </title>

    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/navBar.css">
</head>
<body>
    <h1>Créer votre Todo</h1>
    <form action="#" method="POST">
        <div>
            <label for="idTitle">Titre</label>
            <input type="text" id="idTitle" name="title" required> 
        </div>
        <div>
            <label for="idDescription">Description</label>
            <textarea name="description" id="idDescription" cols="50" rows="10" required></textarea>
        </div>
        <div>
            <input type="submit" name="ok">
        </div>
    </form>
</body>
</html>