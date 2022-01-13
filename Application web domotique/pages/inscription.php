<?php 
if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["mail"]) && isset($_POST["adresse"])) {
    if (((empty($_POST["nom"]) && empty($_POST["prenom"]) && empty($_POST["mail"]))) == FALSE) {
        if (isset($_POST["mdp1"]) && isset($_POST["mdp2"])) {
            if ($_POST["mdp1"] == $_POST["mdp2"] && (empty($_POST["mdp1"]) == FALSE)) {
                $adresse = $_POST["adresse"];
                if (isset($_POST["question"]) && isset($_POST["reponse"])) $question = addslashes($_POST["question"]); $reponse = addslashes($_POST["reponse"]);
                $prenom = addslashes($_POST["prenom"]);
                $nom = addslashes($_POST["nom"]);
                $mail = addslashes($_POST["mail"]);
                $mdp = sha1($_POST["mdp1"]);
                if(isset($_POST["Civilité"])) {
                    $sexe = ($_POST["Civilité"]);
                }
                else {
                    $sexe = "Autre";
                }
                // si l'utilisateur existe déjà...
                $req = "SELECT * FROM users WHERE mail = '$mail'";
                $ORes = $Bdd->query($req);
                if($Usr = $ORes->fetch()) {
                    $erreur = "Votre compte existe déjà";
                }
                if (filter_var($mail, FILTER_VALIDATE_EMAIL) == FALSE) {
                    $erreur = "Vous devez mettre une adresse mail valide.";
                }
                if (!isset($erreur)) {
                    // 1 CREER LA REQUETE
                    $req = "INSERT INTO users (mail, prenom, nom, mdp, adresse, sexe, Question, Reponse) VALUES ('$mail', '$prenom', '$nom', '$mdp', '$adresse', '$sexe', '$question', '$reponse') ";
                    // 2 EXECUTER
                    $ORes = $Bdd->query($req);
                    $id = $Bdd->lastInsertId();
                    $ORes2 = $Bdd->query("INSERT INTO stats (usersid, pieces, objets) VALUES ('$id', '0', '0')");
                    $_SESSION['subscribed'] = TRUE;
                    header("Refresh:0; url=index.php?p=connexion");
                }
            } else $erreur = "Vos mots de passe ne correspondent pas";
        } else $erreur = "Vos mots de passe ne correspondent pas";
    } else {
        $erreur = "Veuillez rentrer toutes les informations";
    }
}
?>
<title>Domotech - Inscription</title>
<link rel="stylesheet" href="css/compte/inscription.css">

<!-- page d'inscription -->
<form action="" method="POST">
    <div class="page">
        <h1 style="margin-bottom: 45px;text-decoration:underline;">Inscription</h1>
        <label for="nom">Entrez votre nom et</label><label for="prenom"> votre prénom</label><br>
        <input type="text" placeholder="Votre nom" style="margin-right: 5px;" id="nom" name="nom"><input type="text" placeholder="Votre prénom" id="prenom" name="prenom"><br>
        <label for="sexe">Civilité : </label><br>
        <select name="Civilité" id="sexe">
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
        <option value="Autre">Autre</option>
        </select><br> <br>
        <label for="question">Entrez une question pour la récuperation du compte :</label><br>
        <input type="text" id="question" name="question" placeholder="Quels est ton plat préféré ?"> <input type="text" id="reponse" name="reponse" placeholder="Spaghetti à la bolognaise"><br>
        <label for="mail">Entrez votre mail :</label><br>
        <input type="email" id="mail" name="mail" placeholder="exemple@exemple.com"><br>
        <label for="adresse">Entrez votre adresse :</label><br>
        <input type="text" id="adresse" name="adresse" placeholder="2 rue des partiels"><br>
        <label for="password">Entrez votre mot de passe :</label><br>
        <input type="password" id="password" name="mdp1" placeholder="*****"><br>
        <label for="password2">Entrez à nouveau votre mot de passe :</label><br>
        <input type="password" id="password2" name="mdp2" placeholder="*****"><br><br>
        <button type="submit" style="margin-top: 25px;">S'inscrire</button>
        <?php if (isset($erreur)) {echo "<p style='color:red;'>$erreur</p>";} ?>
        <p>Vous avez déjà un compte ?<br/><a href="?p=connexion" class="liens">Cliquez ici pour vous connecter !</a></p>
    </div>
</form>
<!-- Fin de la page d'inscription -->