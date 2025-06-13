<?php
    require_once '../service/dbConnect.php';

    // Démarrer la session
    session_start();
    
    // Vérifier la non-existance de la clé userId dans $_SESSION
    if(!isset($_SESSION['userId'])){
        header('location: ./signin.php');
        exit();
    }
    $userId = $_SESSION['userId'];

    // Récupérer les 5 todoList les plus récents s'ils existent
    $sql = "SELECT id, title FROM todo WHERE author = :userId ORDER BY createdAt DESC LIMIT 5;";

    // Si j'ai accès à une instance de connexion PDO, alors j'envoie ma requète
    if(isset($db_connexion)){
        $statement = $db_connexion->prepare($sql);
    }
    $statement->bindParam(':userId', $userId);
    $statement->execute();

    // Je récupère les 5 todos dans un tableau à indices ordonnées. Il est multidimensionnel.
    $todos = $statement->fetchAll();

    // Je souhaite afficher les titres des 5 todos reçus dans <section>
    $htmlTodos = "<section id='listTitleTodos'>"; 

    // Je boucle sur $todos afin de manipuler 1 par 1 chaque todo
    for($i = 0 ; $i < count($todos) ; $i++){
        $htmlTodos .= "<a href='./readTodo.php?id=" . $todos[$i]['id']. "'>" . $todos[$i]['title'] . '</a>';
    }

    $htmlTodos .= '</section>';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoList | Accueil connecté</title>

    <link rel="stylesheet" href="../style/main.css">
</head>
<body>
    <header>
        <?php require_once './compenent/navBar.php';?>
    </header>
    <h1>Réservée aux UTILISATEURS</h1>
    <p>Bienvenu sur votre todoList</p>

    <!-- Les 5 todos à afficher -->
    <?= $htmlTodos; ?>

    <section id="todoArea">
        <div id="todoRow">
            <a href="./readTodo.php?id=2">titre 1</a>
            <div> 
                <a href="./updateTodo.php?id=6"><img src="../img/plume.png" alt="logo editer le todo" class="icone"></a>
                <a href="./deleteTodo.php?id=6"><img src="../img/poubelle.png" alt="Logo suppression todo" class="icone"></a>
            </div>
        </div>
    </section>
</body>
</html>