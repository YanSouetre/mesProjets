<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/domotech.png">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <?php
    session_start();
    include("Bdd.php"); // pour avoir accès à l'objet $Bdd et intéragir avec notre BDD
    include("header.php"); // afficher la barre de naviguation
    error_reporting(E_ERROR | E_PARSE); // cacher les erreurs et warnings à l'utilisateur

    // afficher la page affichée
    if(isset($_GET['p'])) {
        $page = $_GET['p'] . ".php"; // variable qui correspond au nom du fichier
        if(file_exists("$page"))
            include("$page");
        else if(file_exists("pages/$page")) // on vérifies dans notre dossier 'pages' aussi
            include("pages/$page");
        else {
            ?>
            <div style="text-align:center;margin-top:250px;font-size:100px;">
                <p style="color:red;">Page inexistante</p>
            </div>
            <?php
        }
    } else {
        include("accueil.php"); // on affiche l'accueil si la donnée de session 'p' n'existe pas
    }
    ?>
</body>

</html>