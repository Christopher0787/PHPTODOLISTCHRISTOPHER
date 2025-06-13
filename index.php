<?php
    require_once './view/compenent/navBar.php';

    session_start();
    
    $listLi = '';
    // Si c'est un utilisateur
    if (isset($_SESSION['userId'])) {
        // Les différent <li> réservés aux utilisateur
        $listLi .= '
        <li><a href="./view/homeConnected.php">Accueil Utilisateur</a></li>
        <li><a href="./view/disconnect.php">Se deconnecter</a></li>
        ';
    }
    // Si j'ai un visiteur 
    else {
        // Les différent <li> réservés aux visiteur
        $listLi .= '
            <li><a href="/view/signup.php">S\'inscrire</a></li>
            <li><a href="/view/signin.php">Se connecter</a></li>
            ';
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todolist</title>
</head>
<body>
    <header>

    </header>

    <main>
        <h1>Bienvenue sur la todolistChristopher</h1>
        <h2>La TodoList du codeur</h2>
    </main>
    
    <footer></footer>
</body>
</html>