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

    // Démarrage de la session, redirection si non logger
    session_start();
    if(empty($_SESSION['login']))
    {
        header('location: login.php');
    }
    if(!empty($_POST)) {
        header('location: index.php');
    }
    if(!empty($_GET)) {
        header('location: index.php');
    }
    

    // Connection à la BDD par fichier externe
    require_once 'connect.php';

?>
    <header>
        <!-- Menu de navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link " href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                </ul>
                <span class="navbar-text position-absolute top-0 end-0 px-1">
                <?php 
                    // Affichage du nom de l'utilisateur connecter
                    echo "<h3>Bienvenue : " . ucfirst($_SESSION['name']) . "</h3>";
                ?>
                </span>
            </div>
        </nav>
    </header>
    <div class="d-flex mx-1 my-1">

        <!-- Affichage des utilisateurs enregistrer sur le site -->
        <div class="col-4 d-flex flex-column">
            <p class="align-self-center text-decoration-underline text-primary fs-3 mb-0">Users registred :</p>
            <?php

                // Récupération des données utilisateurs enregistrer
                $query = "SELECT id, name, mail FROM users WHERE id > 1";
                $stmt = $pdo->query($query);
                $infos = $stmt->fetchAll();

                // Récupération des amis de l'utilisateur connecté
                $query2 = "SELECT friends FROM {$_SESSION['name']}";
                $stmt2 = $pdo->query($query2);
                $friends = $stmt2->fetchAll();
                // Inscription de la liste d'amis dans un tableau
                $check[0] = 0 ;
                foreach($friends as $value) {
                    $check[] = $value['friends'];
                }

                // Affichage des utilisateurs enregistrés 
                if (!empty($infos)) {
                    foreach($infos as $value) { ?>
                        <div class="mt-2 bg-warning bg-opacity-50 rounded">
                            Name : <?php echo ucfirst($value['name']); ?>
                        </div>
                        <div class="mb-1 bg-light rounded">
                            E-mail : <?php echo $value['mail']; ?>
                        </div>
                        <?php

                        // Verification si déja amis ou non
                        if($value['name'] === $_SESSION['name']) {}
                        elseif(array_search($value['name'], $check) != false) {
                            ?>
                                <!-- Déjà amis, option suppresions -->
                                <p class="fs-6 text-success my-0">Already friend</p>
                                <a class="btn btn-danger opacity-75 col-3 align-self-end m-1 p-0" href="?delfriend=<?php echo $value['name'];?>">Delete friend</a>
                            <?php
                        }
                        else {
                            ?>
                                <!-- Pas encore amis, option ajout -->
                                <a class="btn btn-success align-self-center p-0" href="?addfriend=<?php echo $value['name'];?>">Add friend</a>
                            <?php
                        }                   
                    }
                }
                // Cas ajout amis
                if(isset($_GET['addfriend'])) {
                    $addfriend = htmlspecialchars($_GET['addfriend']);
                    $delfriend = htmlspecialchars($_GET['delfriend']);

                    // Récupération de l'id du friend a ajouter pour l'inscrire dans la table de l'utilisateur connecté
                    $query3 = "SELECT id FROM users WHERE name = '$addfriend'";
                    $stmt3 = $pdo->query($query3);
                    $friend_id = $stmt3->fetch()['id'];

                    // Inscription dans la BDD du nouvel amis en requête préparée
                    $query4 = "INSERT INTO {$_SESSION['name']} (friends, users_id) VALUES (:addfriend, :id)";
                    $stmt4 = $pdo->prepare($query4);
                    $stmt4->bindValue(':addfriend', $addfriend, PDO::PARAM_STR);
                    $stmt4->bindValue(':id', $friend_id, PDO::PARAM_INT);
                    $stmt4->execute();
                    unset($_GET);
                    header('refresh: 0; url="index.php"');  
                }

                // Cas supression amis
                if(isset($_GET['delfriend'])) {
                    $addfriend = htmlspecialchars($_GET['addfriend']);
                    $delfriend = htmlspecialchars($_GET['delfriend']);
                    
                    // Récupération de l'id du friend a supprimer pour le desinscrire dans la table de l'utilisateur connecté
                    $query3 = "SELECT id FROM users WHERE name = '$addfriend'";
                    $stmt3 = $pdo->query($query3);
                    $friend_id = $stmt3->fetch()['id'];

                    // Supression de l'amis dans la table de l'utilisateur
                    $query4 = "DELETE FROM {$_SESSION['name']} WHERE friends = '$delfriend'";
                    $stmt4 = $pdo->query($query4);
                    unset($_GET);
                    header('refresh: 0; url="index.php"'); 
                }
            ?>
        </div>

        <!-- Post d'un nouveau message -->
        <div class="container-fluid col-8 d-flex flex-column mx-0">
            <p class="fs-3 text-decoration-underline text-primary align-self-center mb-0">POSTS :</p>
            <div class="col-12">
                <form action="index.php" method="post">
                    <label for="post" class="form-label fs-4 py-0 mt-0 text-decoration-underline text-secondary">Post new messages <></label>
                    <textarea class="col-12 form-control" id="post" name="user_post" placeholder="Type your message here..."></textarea>
                    <button type="submit" class="btn btn-primary p-0 my-1 w-25 opacity-75">Send</button>
                </form>
                <hr class="border-4 border-primary">
            </div>
            <?php
                // Inscription du message dans la BDD
                if(isset($_POST['user_post'])) {
                    $userpost = htmlspecialchars($_POST['user_post']);
                    $query = "INSERT INTO post (users_id, message, author) VALUES (:login, :post, :author)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindValue(':login', $_SESSION['login'], PDO::PARAM_STR);
                    $stmt->bindValue(':post', $userpost, PDO::PARAM_STR);
                    $stmt->bindValue(':author', $_SESSION['name'], PDO::PARAM_STR);
                    $stmt->execute();
                    unset($_POST);
                    header('refresh: 0; url="index.php"');
                }
            ?>
            <!-- Affichage des messages postés -->
            <div class="fs-4 text-secondary text-decoration-underline col-12">Recent posts :</div>
            <div class="mt-2 d-flex flex-wrap">

                <?php
                    // Récupération des messages dans la BDD
                    $query = "SELECT id, users_id, message, author FROM post";
                    $stmt = $pdo->query($query);
                    $posts = $stmt->fetchAll();
                    foreach($posts as $value) {
                ?>
                        <div class="border border-primary border-opacity-50 rounded col-8 d-flex flex-column mb-2">
                            <div class="align-self-center text-decoration-underline bg-warning bg-opacity-50 rounded w-25 text-center pb-1 border border-dark mt-1">Author : <?php echo ucfirst($value['author']); ?></div>
                            <div class="col-12 ps-1 py-1"><?php echo $value['message']; ?></div>
                            <div class="align-self-end bg-success bg-opacity-50 rounded-1 me-1 mb-1">Liked by :
                                <?php
                                    // Récupération des utilisateur ayant liké le post
                                    $query2 = "SELECT users.name, post_like.users_id, post_like.post_id FROM users JOIN post_like ON users.id = post_like.users_id";
                                    $stmt2 = $pdo->query($query2);
                                    $like = $stmt2->fetchAll();
                                    foreach($like as $likes) {
                                        if($value['id'] == $likes['post_id']) {
                                            echo ucfirst($likes['name']."-");
                                        }
                                    }
                                ?>
                            </div>
                            <?php 
                                // Modification du post si il appartient à l'utilisateur loggé
                                if($value['users_id'] == $_SESSION['login']) {
                                    ?><a class="btn btn-warning opacity-75 align-self-center p-0 m-1" href="edit.php?update=<?php echo $value['id'];?>">Modify</a><?php   
                                }                                
                            ?>
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                        <?php
                            // Option like/Unlike des posts
                            $query2 = "SELECT users.name FROM users JOIN post_like on users.id = post_like.users_id AND post_like.post_id = {$value['id']} and users.id = {$_SESSION['login']}";
                            $stmt2 = $pdo->query($query2);
                            $row2 = $stmt2->fetch();
                            if(empty($row2['name'])) {
                                ?>
                                    <a class="btn btn-primary opacity-75 align-self-center ps-4 pe-4" href="?users_id=<?php echo$_SESSION['login'];?>&post_id=<?php echo $value['id'];?>">Like</a>
                                <?php
                            }
                            else {
                                ?>
                                    <a class="btn btn-danger opacity-75 align-self-center" href="?del_users_id=<?php echo$_SESSION['login'];?>&del_post_id=<?php echo $value['id'];?>">Unlike</a>
                                <?php
                                }
                        ?>
                        </div>
                        <?php
                            // Inscription dans la BDD du like
                            
                            if(isset($_GET['users_id']) && isset($_GET['post_id']) && $value['id'] == $_GET['post_id']) {
                                $postLikeUserId = htmlspecialchars($_GET['users_id']);
                                $postLikeId = htmlspecialchars($_GET['post_id']);
                                $query2 = "INSERT INTO post_like (users_id, post_id) VALUES (:login, :post_id)";
                                $stmt2 = $pdo->prepare($query2);
                                $stmt2->bindValue(':login', $postLikeUserId);
                                $stmt2->bindValue(':post_id', $postLikeId);
                                $stmt2->execute();
                            }

                            // Supression dans la BDD du unlike
                            if(isset($_GET['del_users_id']) && isset($_GET['del_post_id']) && $value['id'] == $_GET['del_post_id']) {
                                $delUId = htmlspecialchars($_GET['del_users_id']);
                                $delPostId = htmlspecialchars($_GET['del_post_id']);
                                $query2 = "DELETE FROM post_like WHERE users_id = {$_SESSION['login']} AND post_id = {$_GET['del_post_id']}";
                                $stmt2 = $pdo->query($query2);
                            }
                    }
                        ?>
            </div>
        </div>
    </div>
<?php
// Fermeture de la connexion 
$pdo = null ;
?>
</body>
</html>