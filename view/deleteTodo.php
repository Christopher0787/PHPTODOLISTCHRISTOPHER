<?php 
    require_once '../service/dbConnect.php';
    
    // Démarrer la session
    session_start();

    // Vérifier la non-existance de la clé userId dans $_SESSION
    if(!isset($_SESSION['userId'])){
        header('location: ./signin.php');
        exit();
    }

    // Je récupère l'id du todo à Lire (afficher)
    $idTodo = $_GET['id'];

    // je souhaite supprimer une requète de type DELETE pour supprimer le titre et la description dans le formulaire.
    $sql = "DELETE FROM todo WHERE id = :idTodo";

    // Je verifie si j'ai accés à une instance de connexion PDO
    if (isset($db_connexion)) {
        $statement = $db_connexion->prepare($sql);
    }

    // Dans $statment j'associe les paramètre nommés avec les bonne variable
    $statement->bindParam(':idTodo', $idTodo);

    // J'exécute la requète paramétre nommé (requète securisées)
    $statement->execute();

    header('location: ./homeConnected.php');
    exit();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeleteTodo</title>
</head>
<body>
    <h1>Supprimer votre Todo</h1>
</body>
</html>