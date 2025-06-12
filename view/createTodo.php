<?php 
    require_once '../service/dbConnect.php';
    
    // Démarrer la session
    session_start();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreateTodo | </title>
</head>
<body>
    <h1>CreateTodo</h1>
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