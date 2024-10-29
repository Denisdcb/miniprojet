<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            background-color: black;
        }   
    </style>
</head>
<body class="vh-100">

    <!-- Formulaire de connection -->
    <div class="content col-12 d-flex flex-column justify-content-center h-100">
    <h1 class="text-center content text-light">Login</h1>
    <div class="container-fluid col-3 d-flex flex-column justify-content-center rounded-1 content h-50 bg-dark bg-opacity-75 text-light main_cont border border-2 border-success">
        <form action="login.php" method="post" class="row">
            <div class="col-12 p-2 d-flex flex-column">
                <label for="username" class="form-label align-self-center fs-3">User</label>
                <input type="text" id="username" name="user_name" class="form-control" placeholder="Username" required>
            </div>
            <div class="col-12 p-2 d-flex flex-column">
                <label for="password" class="form-label align-self-center fs-3">Password</label>
                <input type="password" id="password" name="user_password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-12 p-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Connect</button>
            </div>
            <div class="p-2 d-flex flex-column align-items-center">
                <p>Dont have an account, sign-in here..</p>
                <a class="btn btn-warning" href="signin.php">Register</a>
            </div>
        </form>
<?php

use function PHPSTORM_META\elementType;

    session_start();

    // Connection à la BDD par appel d'un fichier externe
    require_once 'connect.php';

    // Récupération des utilisateurs inscrit
    $query = "SELECT name FROM users";
    $stmt = $pdo->query($query);
    $users = $stmt->fetchAll();
    $check[0] = "0";
    foreach($users as $value) {
        $check[] = $value['name'];
    }

    // Vérification des informations de connection
    $user_name = htmlspecialchars($_POST['user_name']);
    $user_password = htmlspecialchars($_POST['user_password']);

    // Recupération du mot de passe en fonction du nom d'utilisateur entrer
    if(!empty($user_name) && !empty($user_password)) {
        $query = "SELECT password FROM users WHERE name = '$user_name'";
        $stmt = $pdo->query($query);
        $passwordHash = $stmt->fetch()['password'];

        // Vérification de l'extisense du nom d'utilisateur entrer et enregistrement des erreurs dans un tableau
        $errors = [];
        if(array_search($user_name, $check) == false) {
            $errors[] = "Account ".$user_name." doesnt exist, please verify and submit again";
        }

        // Vérification du mot de passe si valide redirection vers index, si non erreurs
        else {
            if(password_verify($user_password, $passwordHash)) {

                // Récupération de l'id de l'utilisateur pour l'inscrire dans $_SESSION
                $query = "SELECT id FROM users WHERE name = '$user_name'";
                $stmt = $pdo->query($query);
                $id = $stmt->fetch()['id'];
                $_SESSION['login'] = $id;
                $_SESSION['name'] = $user_name;
            }
            else {
                $errors[] = "Wrond password, please verify and try again";
            }
        }

        // Si le tableau d'erreurs est vide, message de succés et redirection vers l'index si non affichage des erreurs
        if(empty($errors)) {
            echo "<p style='color:green'>Welcome redirection soon...</p>";
            header('refresh: 3; url="index.php"');
        }
        else {
            foreach($errors as $value) {
                echo "<p style='color:red'>$value</p>";
            }
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