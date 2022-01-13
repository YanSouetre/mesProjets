<!-- Début du code de la barre de navigation -->
<link rel="stylesheet" href="css/global/global.css">
<?php if (isset($_SESSION["online"])) { // si l'utilisateur est en ligne, on lui affiche une navbar avec un bouton de déconnexion
    if ($Dmd = ($Bdd->query("SELECT * FROM demandes WHERE friendid = '$_SESSION[userid]'"))->fetch()) {$i = TRUE;} else {$i = FALSE;} ?>
    <ul class="menu">
        <li class="logoNav"><a href="?p=accueil">DOMOTECH<span class="mini"></span></a></li>
        <li><a id="accueil" href="?p=accueil">Accueil</a></li>
        <li><a id="appareils" href="?p=appareils">Mes appareils</a></li>
        <li><a id="controle" href="?p=controle">Contrôles</a></li>
        <li><a id="moncompte" href="?p=moncompte">Mon compte</a></li>
        <li><a id="classement" href="?p=classement">Classement</a></li>
        <?php
        if (isset($_GET["p"]) == FALSE) { $_GET["p"] = "accueil"; }  // Si la donné de session p n'existe pas on la crée et elle sera egal à l'accueil?> 
        <style>
            /* changer l'apparence de la balise a qui correspond à la page utilisé */
            <?php echo "#" . $_GET["p"]; ?> {
                text-decoration:underline;
                color:aquamarine;
            }

            #loupe img{
                width: 20px;
                height: 20px;
                cursor:pointer;
                vertical-align: middle;
               

            }

            #cloche img{
                width: 20px;
                height: 20px;
                cursor:pointer;    
                vertical-align: middle;
            }
        </style>
        <li class="btn"><a id="" href="?p=connexion" style="color:rgba(255, 0, 0, 0.562);">Se déconnecter</a></li>
        <li class="btn"><a href="?p=notification" id="cloche"><img src="images/cloche<?php if ($i) {echo "2";}?>.png" alt=""></a></li>
        <li class="btn"><a href="?p=recherche" id="loupe"><img src="images/loupe.png" alt=""></a></li>
        <li class="btn"><a id="ami"href="?p=ami">Amis</a></li>
    </ul>  

    <nav role="navigation">
        <div class="fond2">
            <div class="nav2" id="menuToggle">
            <input class="nav2" id="checkbox" type="checkbox" />

            <span><img id="logoburg" src="images/burger.png"></span>

            <ul class="nav2" id="menu">
                <li><a id="accueil" href="?p=accueil">Accueil</a></li>
                <li><a id="appareils" href="?p=appareils">Mes appareils</a></li>
                <li><a id="salon" href="?p=salon">Contrôles</a></li>
                <li><a id="moncompte" href="?p=moncompte">Mon compte</a></li>
                <li><a id="classement" href="?p=classement">Classement</a></li>
                <li><a id="ami"href="?p=ami">Amis</a></li>
                <li><a href="?p=recherche" id="loupe"><img src="images/loupe.png" alt=""></a></li>
                <li><a href="?p=notification" id="cloche"><img src="images/cloche.png" alt=""></a></li>
                <li class="btn"><a href="?p=connexion" style="color:rgba(255, 0, 0, 0.562);">Se déconnecter</a></li>
            </ul>
            </div>
        </div>
    </nav>
<?php } else { // sinon on affiche le menu avec le bouton de connexion ?>
    <ul class="menu">
        <li class="logoNav"><a href="?p=accueil">DOMOTECH<span class="mini"></span></a></li>
        <li><a id="accueil" href="?p=accueil">Accueil</a></li>
        <li><a id="appareils" href="?p=connexion">Mes appareils</a></li>
        <li><a id="salon" href="?p=connexion">Contrôles</a></li>
        <li><a id="moncompte" href="?p=connexion">Mon compte</a></li>
        <li><a id="classement" href="?p=classement">Classement</a></li>
        <?php
        if (isset($_GET["p"]) == FALSE) { $_GET["p"] = "accueil"; } ?>
        <style>
            <?php echo "#" . $_GET["p"]; ?> {
                text-decoration:underline;
                color:aquamarine;
            }

            #loupe img{
                width: 20px;
                height: 20px;
                cursor:pointer;
                vertical-align: middle;
               

            }

            #cloche img{
                width: 20px;
                height: 20px;
                cursor:pointer;    
                vertical-align: middle;
            }
        </style>
        <li class="btn"><a id="" href="?p=connexion" style="color:rgb(0, 255, 93, 0.562);">Se connecter</a></li>
    </ul>  

    <nav role="navigation">
        <div class="fond2">
            <div class="nav2" id="menuToggle">
            <input class="nav2" id="checkbox" type="checkbox" />

            <span><img id="logoburg" src="images/burger.png"></span>

            <ul class="nav2" id="menu">
                <li><a id="accueil" href="?p=accueil">Accueil</a></li>
                <li><a id="appareils" href="?p=connexion">Mes appareils</a></li>
                <li><a id="salon" href="?p=connexion">Contrôles</a></li>
                <li><a id="moncompte" href="?p=connexion">Mon compte</a></li>
                <li><a id="classement" href="?p=classement">Classement</a></li>
                <li class="btn"><a href="?p=connexion" style="color:rgb(0, 255, 93);">Se connecter</a></li>
            </ul>
            </div>
        </div>
    </nav>
<?php }