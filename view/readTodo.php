<?php
require_once '../service/dbConnect.php';

session_start();

    // Vérifier la non-existance de la clé userId dans $_SESSION
    if(!isset($_SESSION['userId'])){
        header('location: ./signin.php');
        exit();
    }

    // Je récupère l'id du todo à Lire (afficher)
    $idTodo = $_GET['id'];
    
    //  J'écris la requète à envoyer
    $sql = 'SELECT * FROM todo WHERE id = :idTodo;';
    
    // Si j'ai accès à une instance de connexion PDO, alors j'envoie ma requète
    if(isset($db_connexion)){
        $statement = $db_connexion->prepare($sql);
    }

    // J'associe les paramètres nommées avec les bonnes variables
    $statement->bindParam(':idTodo', $idTodo);

    // Je l'exécute
    $statement->execute();

    // Je récupère l'UNIQUE résultat de ma requète
    $todo = $statement->fetch();

    // Je souhaite afficher les titres des 5 todos reçus dans <article>
    $htmlArticle = "<article id='todo'>";
    $htmlArticle .= "<p>" . $todo['title'] . "</p>";
    $htmlArticle .= "<p>" . $todo['description'] . "</p>";
    $htmlArticle .= "<p>Article créé le " . $todo['createdAt'] . "</p>";
    
    $htmlArticle .= "<p>L'article a-t-il été validé ? ";
    $htmlArticle .= $todo['isDone'] ? 'OUI' : 'NON';
    $htmlArticle .= "</p>";
    
    $htmlArticle .= '</article>';

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoList | Lire un todo</title>

    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
    <header>
        <?php require_once './component/navBar.php';?>
    </header>

    <?= $htmlArticle; ?>

</body>
</html>