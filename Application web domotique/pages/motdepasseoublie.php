<title>Domotech - Connexion</title>
<link rel="stylesheet" href="css/compte/motdepasseoublie.css">

<?php
// session_destroy();
if (isset($_POST["envoyer"]) || isset($_POST["envoyer2"]) || isset($_SESSION["mail"])) {
    if (!isset($_SESSION["mail"])) {$_SESSION["mail"] = addslashes($_POST["email"]);}
    $ORes = $Bdd->query("SELECT * FROM users WHERE mail = '$_SESSION[mail]'");
    if ($Usr = $ORes->fetch()) {
        $question = TRUE;
        if (isset($_POST["envoyer2"])) {
            if ($_POST["reponse"] == $Usr->Reponse) {
                $_SESSION["newmdp"] = bin2hex(random_bytes(5));
                $newmdp = sha1($_SESSION["newmdp"]);
                $ORes = $Bdd->query("UPDATE users SET mdp = '$newmdp' WHERE mail = '$_SESSION[mail]'");
                header("Refresh:0; url=index.php?p=connexion");
            } else {
                $erreur2 = "<p style='color:red;'>Mauvaise réponse, vous pouvez réessayer</p>";
            }
        }
        ?>
        <div class="">
            <div class="page">
                <h1 style="text-decoration:underline;">Mot de passe oublié</h1>
                <?php if (isset($erreur2)) { echo "<h2 style='margin-bottom:45px;color:red;'>$erreur2</h2><br>"; } else { echo "<h2 style='margin-bottom:45px;'>Rentrez la réponse à votre question</h2><br>"; } ?>
                <form action="" method="POST">
                    <label for="question"><?php echo $Usr->Question; ?></label><br>
                    <input type="text" id="email" name="reponse"><br>
                    <br>
                    <button class="btnenvoyer" name="envoyer2">Envoyer</button>
                </form>
            </div>
        </div>
        <?php
        
    } else {
        $erreur = "Cette adresse n'existe pas";
        unset($_SESSION["mail"]);
    }
}
if (!isset($question)) {
    ?>
    <!-- Début de la page d'oublie de mot de passe -->
    <div class="">
        <div class="page">
            <h1 style="text-decoration:underline;">Mot de passe oublié</h1>
            <?php if (isset($erreur)) { echo "<h2 style='margin-bottom:45px;color:red;'>$erreur</h2><br>"; } else { echo "<h2 style='margin-bottom:45px;'>Rentrez l'une des deux informations ci-dessous</h2><br>"; } ?>
            <form action="" method="POST">
                <label for="email" >Veuilliez rentrer votre adresse mail :</label><br>
                <input type="email" id="email" name="email">
                <br><br>
                <button class="btnenvoyer" name="envoyer">Envoyer</button>
            </form>
        </div>
    </div>
    <?php
}