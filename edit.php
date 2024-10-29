<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Home</title>
</head>
<body>
<?php
    session_start();

    // Redirection si non logger
    if(empty($_SESSION['login']))
    {
        header('location: login.php');
    }

    // Connection à la BDD par fichier externe
    require_once 'connect.php';

    // Récupération du nom de l'utilisateur connecter
    $id = htmlspecialchars($_SESSION['login']);
    $name = htmlspecialchars($_SESSION['name']); 
?>
    <header>
        <!-- Menu de navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link " href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                </ul>
                <span class="navbar-text position-absolute top-0 end-0 px-1">
                <?php 
                    echo "<h3>Bienvenue : " . ucfirst($name) . "</h3>";
                ?>
                </span>
            </div>
        </nav>
    </header>
    <?php
        // Récupération du message a modifier 
        $id_post = htmlspecialchars($_GET['update']);
        $query = "SELECT message FROM post WHERE id = $id_post";
        $stmt = $pdo->query($query);
        $post = $stmt->fetch()['message'];  
    ?>
        <!-- Affichage du formulaire contenant le message à modifier -->
        <form action="" method="post" class="d-flex flex-column col-6">
            <label for="update_post" class="form-label fs-3 m-0 text-center">Modify post :</label>
            <hr class="border border-2 border-primary">
            <textarea id="update_post" name="update_post" class="form-control"><?php echo $post;?></textarea>
            <button class="btn btn-primary opacity-75 col-4 mt-2 align-self-center" type="submit">Save</button>
        </form>
        <?php
            // Vérification du formulaire et mise à jour dans la BDD
            $new_post = htmlspecialchars($_POST['update_post']);
            if(!empty($new_post)) {
                $query = "UPDATE post SET message = '$new_post' where id = $id_post";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                // Redirection vers la page index après la modification
                header('refresh: 0; url="index.php"');
            }
        ?>
<?php
// Fermeture de la connexion 
$pdo = null;
?>
</body>
</html>