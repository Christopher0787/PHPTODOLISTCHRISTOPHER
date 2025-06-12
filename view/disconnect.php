<?php
    // Je (re)démarre la session
    session_start();

    // Je réinitialise $_SESSION (la clé userId ne doit plus exister)
    unset($_SESSION);
    // Appelle à la fonction pour détruire la session courante
    session_destroy();

    // Puis je redirige le visiteur vers la page d'accueil du site
    header('location: ../index.php');
    exit();