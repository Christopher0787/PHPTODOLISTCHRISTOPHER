<?php
    require_once './compenent/navBar.php';
    require_once '../service/dbConnect.php';

    // Je démarre une session... 
    session_start();

    // ... pour vérifier si j'ai un utilisateur ou un visiteur pour le rediriger si besoin
    if(isset($_SESSION['userId'])){
        header('location: ./homeConnected.php');
        exit();
    }

    const PASSWORD_NUMBER_OF_CHARACTERS = 12;
    // Dans des constantes, je stocke tous les messages d'erreur
    const ERROR_REQUIRED = 'Veuillez renseigner ce champ !';
    const ERROR_PASSWORD_NUMBER_OF_CHARACTERS = 'Le mot de passe doit contenir ' . PASSWORD_NUMBER_OF_CHARACTERS . ' caractères';

    // Je crée un tableau $errors dans lequel j'ajouterai les messages d'erreur dès que nécessaire. Je crée autant de clé que d'<input> dans le formulaire. ET, je leur affecte pour valeur un string vide.
    $errors = [
        'userName' => '',
        'password' => '',
        'email' => ''
    ];
    $message = '';

    // Ce if est présent uniquement pour exécuter le traitement des données suite à la soummission du formulaire 
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['OK'])){
        // 1ere chose à faire : NETTOYER / FILTRER TOUTES les datas
        $_POST = filter_input_array( INPUT_POST, [
            'userName' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL
        ]);

        //  Je stocke TOUTES les datas reçues ET sécurisées dans des variables
        $userName = $_POST['userName'] ?? '';
        $password = $_POST['password']  ?? '';
        $email = $_POST['email']  ?? '';

        // Gestion des oublis/erreurs utilisateurs
        if(!$userName){
            $errors['userName'] = ERROR_REQUIRED;
        }
        if(!$password){
            $errors['password'] = ERROR_REQUIRED;
        }
        elseif(mb_strlen($password) < PASSWORD_NUMBER_OF_CHARACTERS){
            $errors['password'] = ERROR_PASSWORD_NUMBER_OF_CHARACTERS;
        }
        if(!$email){
            $errors['email'] = ERROR_REQUIRED;
        }

        // Vérifier si le userName ET l'email ont déjà été utilisé. Ces 2 colonnes doivent avoir des valeur uniques !!
        if($userName && (mb_strlen($password) >= PASSWORD_NUMBER_OF_CHARACTERS) && $email){
            //  Préparer la requète SQL
            $sql = 'SELECT username FROM user WHERE username = :userName OR email = :email;';

            // Si j'ai accès à une instance de connexion PDO, alors j'envoie ma requète
            if(isset($db_connexion)){
                $db_statement = $db_connexion->prepare($sql);
            }

            // J'associe les paramètres nommées avec les bonnes variables
            $db_statement->bindParam(':userName', $userName);
            $db_statement->bindParam(':email', $email);
            
            // Envoie de la requète
            $db_statement->execute();

            // Je compte le nombre d'enregistrement qui réponde à la requète
            $nb = $db_statement->rowCount();

            // Si je n'ai reçu aucun resultat, alors je valide l'envoi d'une requète INSERT INTO
            if($nb <= 0){
                //  Faire le requète INSERT INTO
                $sql = 'INSERT INTO user VALUES (DEFAULT, :userName, :password, :email, DEFAULT);';
                //  La préparer
                $db_statement = $db_connexion->prepare($sql);

                // J'associe les paramètres nommées avec les bonnes variables
                $db_statement->bindParam(':userName', $userName);
                $db_statement->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
                $db_statement->bindParam(':email', $email);

                // L'exécuter
                $db_statement->execute();

                $_SESSION['message'] = "<span class='message'>Votre compte a été créé !</span>";
                // Appel à la fonction header() avec un string en paramètre. Ce string doit toujours commencer par  : "location: " puis le chemin vers la ressource pour une redirection UNIQUEMENT.
                header('location: ./signin.php');
                exit();
            }
            else{
                $message = "<span class='message'>Le pseudo ou l'email choisi a déjà été utilisé. Choisissez-en un autre !</span>";
            }
        }
        else{
            $message = "<span class='message'>Veuillez renseigner tous les champs !</span>";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoList | S'inscrire</title>
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/form.css">

</head>
<body>
    <section class="container">
        <div class="block p-20 form-container">
            <h1>Inscrivez-vous !</h1>

            <div class="form-control">
                <?= $message ?>
            </div>

            <form action="#" method="post">
                <div class="form-control">
                    <label for="idUserName">Pseudo</label>
                    <input type="text" id="idUserName" name="userName" required>
                    <div class="area-error">
                        <?= $errors['userName'] ? '<p class="text-error">' . $errors['userName'] . '</p>' : "" ?>
                    </div>
                    
                    <label for="idPassword">Mot de passe</label>
                    <input type="password" id="idPassword" name="password" required>
                    <div class="area-error">
                        <?= $errors['password'] ? '<p class="text-error">' . $errors['password'] . '</p>' : "" ?>
                    </div>

                    <!-- TODO : Ajouter label + input pour double saisie du mdp + traitement dans la partie PHP --> 

                    <label for="idEmail">E-mail</label>
                    <input type="email" id="idEmail" name="email" required>
                    <div class="area-error">
                        <?= $errors['email'] ? '<p class="text-error">' . $errors['email'] . '</p>' : "" ?>
                    </div>

                    <div class="form-color">
                        <input type="submit" value="Valider votre inscription" name="OK" class="btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>