<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>SignIn</title>
    <style>
        body {
            margin: 0;
            background-color: black;
        }
    </style>
</head>
<body class="vh-100">
<!-- Création du formulaire d'inscription -->
<div class="content col-12 d-flex flex-column justify-content-center h-100">
    <h1 class="text-center text-light">Register</h1>
    <div class="container-fluid col-3 d-flex flex-column border border-2 border-primary rounded text-light justify-content-center bg-dark bg-opacity-75">
        <form action="signin.php" method="post" class="row">
            <div class="col-12 p-2">
                <label for="username" class="form-label">User</label>
                <input type="text" id="username" name="user_name" class="form-control" placeholder="Username.." required>
            </div>
            <div class="col-12 p-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="user_password" class="form-control" placeholder="Password.." required>
            </div>
            <div class="col-12 p-2">
                <label for="mail" class="form-label">Adresse E-Mail</label>
                <input type="email" id="mail" name="user_mail" class="form-control" placeholder="E-Mail.." required>
            </div>
            <div class="col-12 p-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    
<?php
    session_start();

    //Connection à la BDD et récupération des utilisateur déjà inscrit
    require_once 'connect.php';
    $query = "SELECT * FROM users";
    $stmt = $pdo->query($query);
    $users = $stmt->fetchAll();
    $check[0] = "0";
    foreach($users as $value) {
        $check[] = $value['name'];
    }

    // Filtrage des données recu dans le formulaire
    $user_name = htmlspecialchars($_POST['user_name']);
    $user_password = htmlspecialchars($_POST['user_password']);

    // Sécurisation du mot de passe avec password_hash
    $user_passwordHash = password_hash($user_password, PASSWORD_DEFAULT);
    $user_mail = htmlspecialchars($_POST['user_mail']);
    $user_mail = filter_input(INPUT_POST, 'user_mail', FILTER_SANITIZE_EMAIL);

    // Vérification si les champs sont bien remplies et affichages des erreurs dans un tableau errors
    $errors = []; 
    if(!empty($user_name) && !empty($user_password) && !empty($user_mail)) {
        if(array_search($user_name, $check) != false) { 
            $errors[] = "Account ".$user_name." already exist, please choose another and submit again";
        }
        if(strlen($user_name) < 3 || strlen($user_name) > 10) {
            $errors[] = "Verify that name containt more than 3 chars and less than 10 !";
        }
        if(strlen($user_password) < 6) {
            $errors[] = "Password should get 6 chars minimum";
        }
        if(!$user_mail) {
            $errors[] = "Mail is invalid, check and submit again";
        }
    }
    // Si le tableau d'erreurs est vide on valide l'envoie dans la BDD si non on affiche les erreurs   
    if(empty($errors) && !empty($_POST)) {
        //Inscription du nouvel utilisateur dans la BDD 
        $query = "INSERT INTO users (name, password, mail) VALUES (:name, :password, :mail)";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':name', $user_name, \PDO::PARAM_STR);
        $stmt->bindValue(':password', $user_passwordHash, \PDO::PARAM_STR);
        $stmt->bindValue(':mail', $user_mail, \PDO::PARAM_STR);
        $stmt->execute();
        ?> <p class="text-success">Account created, redirection to login..</p> <?php

        //Creation d'une nouvelle table pour l'utilisateur dans la BDD
        $query = "CREATE TABLE $user_name (id INT AUTO_INCREMENT PRIMARY KEY, friends VARCHAR(50), post_id INT, users_id INT)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        //Redirection vers la page login
        unset($_POST);
        header('refresh: 3; url="login.php"');
    }
    else{
        foreach($errors as $value) {
            echo "<p style='color:red'>$value</p>";
        }
    }
?>
    </div>
</div>
<?php
// Fermeture de la connexion 
$pdo = null;
?>
</body>
</html>