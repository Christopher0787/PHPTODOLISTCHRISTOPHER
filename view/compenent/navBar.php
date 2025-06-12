<?php


// session_start();

$listLi = '';
    // Si c'est un utilisateur
    if(isset($_SESSION['userId']) && $_SESSION['userId'] !== null){
        
        // Les différents <li> réservés aux utilisateurs
        $listLi .= '
            <li><a href="/view/homeConnected.php">Accueil utilisateur</a></li>
            <li><a href="/view/createTodo.php">Créer une tâche</a></li>
            <li><a href="/view/disconnect.php">Se déconnecter</a></li>
        ';
    }
    // Si j'ai un visiteur
    else{
        // Les différents <li> réservés aux visiteurs
        $listLi .= '
            <li><a href="./view/signup.php">S\'inscrire</a></li>
            <li><a href="./view/signin.php">Se connecter</a></li>
        ';
    }
?>


<nav>
    <ul>
        <li><a href="/index.php">Accueil</a></li>
        <?= $listLi; ?>
    </ul>
</nav>
<span id="burgerMenu">
    <span></span>
    <span></span>
    <span></span>
</span>