<title>Domotech - Connexion</title>
<link rel="stylesheet" href="css/compte/connexion.css">
<!-- page de connexion -->
<?php
    if (isset($_SESSION["online"])) { // deconnexion
        session_destroy();
        $deco = "Vous avez bien été déconnecté du site";
    }
    if (isset($_SESSION["mail"])) unset($_SESSION["mail"]);

    if (isset($_POST["usermail"]) && isset($_POST["userpassword"])) {
        $mail = addslashes($_POST["usermail"]);
        $mdp = sha1($_POST["userpassword"]);

        if (filter_var($mail, FILTER_VALIDATE_EMAIL) == FALSE) {
            $erreur = "Vous devez rentrer un mail.";
        } else {

            // 1 CREER LA REQUETE
            $req = "SELECT * FROM users WHERE mail = '$mail'";
            // 2 EXECUTER
            $ORes = $Bdd->query($req);
            // 3 PARCOURIR LE RESULTAT
            if ($Usr = $ORes->fetch()) {
                if ($Usr->mdp == $mdp) {
                    $trouve = TRUE;
                    $_SESSION["userid"] = $Usr->id;
                    $_SESSION['username'] = $Usr->prenom;
                    $_SESSION['nom'] = $Usr->nom;
                    $_SESSION['Civilité'] = $Usr->sexe;
                    $lastco=date("Y-m-d H:i:s");
                    $req2 = "UPDATE users SET lastco = '$lastco' WHERE id = '$Usr->id'"; 
                    $ORes2 = $Bdd->query($req2);
                } else {
                    $trouve = FALSE;
                }
            }
            if (isset($trouve)) {
                if ($trouve == TRUE) {
                    $_SESSION["online"] = TRUE;
                    $_SESSION["justonline"] = TRUE;
                    unset($trouve);
                    header("Refresh:0; url=index.php?p=accueil");
                } else {
                    $erreur = "Mot de passe incorrect.";
                    unset($trouve);
                }
            } else {
                $erreur = "Ce compte n'est pas incrit...";
            }

        }
    }
?>
<form action="" method="POST">
    <div class="page">
        <h1 style="text-decoration:underline;">Page de connexion</h1><br><br>
        <?php if (isset($deco)) {echo "<p style='color:green;margin-top:0px;'>$deco</p>"; unset($deco);} ?>
        <?php if (isset($_SESSION['subscribed'])) {unset($_SESSION['subscribed']);echo "<p style='color:green;margin-top:0px;'>Vous êtes désormais inscrit, vous pouvez vous connecter ci dessous.</p>";} ?>
        <?php if (isset($_SESSION["newmdp"])) {echo "<p style='color:green;margin-top:0px;'>Votre nouveau mot de passe est : $_SESSION[newmdp]</p>";unset($_SESSION["newmdp"]); } ?>
        <div id = "exple">
            <input type="email" placeholder="Email" style="margin-bottom: 5px;" name="usermail"><br><br>
            <div class="pl">
            <input type="password" placeholder="Mot de passe" style="margin-bottom: 5px;" id = "userpassword" name="userpassword">
            <img src="images/eye.png" id = "eye" onClick="changer()" /><br><br>   
            </div>
        </div>
        <button type="submit">Se connecter</button>
        <?php if (isset($erreur)) {echo "<p style='color:red;'>$erreur</p>";} ?>
        <p><a class="liens" href="?p=motdepasseoublie">J'ai oublié mon mot de passe</a><br><a class="liens" href="?p=inscription">Créer un nouveau compte</a></p>
    </div>
</form>



<script>
    e = true;
    function changer() {
        if(e == true) {
            document.getElementById("userpassword").setAttribute("type", "text");
            document.getElementById("eye").src="images/ZE.png";
            e = false;
        }
        else if (e == false) {
            document.getElementById("userpassword").setAttribute("type", "password");
            document.getElementById("eye").src="images/eye.png";
            e = true;
        }
    }

</script>
<!-- fin de la page de connexion -->