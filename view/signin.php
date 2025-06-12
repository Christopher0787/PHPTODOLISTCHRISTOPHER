<?php
    // Les imports
    require_once '../service/dbConnect.php';


    // Démarrer une session
    session_start();

    // Je vérifie si j'ai un utilisateur ou un visiteur pour le rediriger si besoin
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
        'password' => ''
    ];
    $message = $_SESSION['message'] ?? '';
    $_SESSION['message'] = '';

    // Ce if est présent uniquement pour exécuter le traitement des données suite à la soummission du formulaire 
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['OK'])){
        // 1ere chose à faire : NETTOYER / FILTRER TOUTES les datas
        $_POST = filter_input_array( INPUT_POST, [
            'userName' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ]);

        //  Je stocke TOUTES les datas reçues ET sécurisées dans des variables
        $userName = $_POST['userName'] ?? '';
        $password = $_POST['password']  ?? '';

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

        if($userName && (mb_strlen($password) >= PASSWORD_NUMBER_OF_CHARACTERS)){
            $sql = 'SELECT id, username, password FROM user WHERE username = :userName;';

            // Si j'ai accès à une instance de connexion PDO, alors j'envoie ma requète
            if(isset($db_connexion)){
                $db_statement = $db_connexion->prepare($sql);
            }
            // Envoie de la requète
            $db_statement->execute(array(
                ':userName' => $userName
            ));

            // Les datas reçues sont stockées dans un tableau associatif (clé/valeur) grâce à l'option PDO::FETCH_ASSOC définie lors l'instanciation de mon instance de connexion
            $data = $db_statement->fetch();

            // Comparer le hash du mot de passe saisi avec le hash provenant de la BDD avec l'appel à la fonction password_verify()
            if(password_verify($password, $data['password'])){
                // Valider la connexion
                $_SESSION['userId'] = $data['id'];
                header('location: ./homeConnected.php');
                exit();
            }
            else{
                // Si le mot de passe est erronné
               $message = "<span class='message'>Mauvais mot de passe, veuillez réessayer !</span>"; 
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
    <title>TodoList | Se connecter</title>


</head>
<body>
    <section class="container">
        <div class="block p-20 form-container">
            <h1>Se connecter !</h1>

            <div class="form-control">
                <?= $message ?>
            </div>

            <form action="#" method="post">
                <div class="form-control">
                    <label for="idUserName">Pseudo</label>
                    <input type="text" id="idUserName" name="userName">
                    <div class="area-error">
                        <?= $errors['userName'] ? '<p class="text-error">' . $errors['userName'] . '</p>' : "" ?>
                    </div>
                    
                    <label for="idPassword">Mot de passe</label>
                    <input type="password" id="idPassword" name="password">
                    <div class="area-error">
                        <?= $errors['password'] ? '<p class="text-error">' . $errors['password'] . '</p>' : "" ?>
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