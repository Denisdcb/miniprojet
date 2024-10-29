<?php
    session_start();
    // Destruction de la session si logger, si non logger renvoie vers la page login
    if(!empty($_SESSION['login']))
    {
        session_destroy();
        unset($_SESSION);
        header("refresh: 3, login.php");
    }
    else
    {
        header("location: login.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Logout</title>
</head>
<body>
    <h2 style="color:blue;">You are deconnected, redirecting to login soon..</h2>
</body>
</html>