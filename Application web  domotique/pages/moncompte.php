<title>Domotech - Compte</title>
<link rel="stylesheet" href="css/compte/moncompte.css">
<!-- Début de la page de mon compte -->
<!-- dive page rassamblant deux autres div -->
<?php
if(isset($_SESSION["online"])) {
    // changement de mdp, adresse mail, nom, prenom ou adresse
    if (isset($_POST["valider"])) {
        if(!empty($_POST["mdpa"])) {
            $confirm = "";
            $req = "SELECT * FROM users WHERE id = '$_SESSION[userid]'";
            $ORes = $Bdd->query($req);
            if ($Usr = $ORes->fetch()) {
                if (sha1($_POST["mdpa"]) == $Usr->mdp) {
                    // changement de nom
                    if(!empty($_POST["nom"])) {
                        $nom = addslashes($_POST["nom"]);
                        $req2 = "UPDATE users SET nom = '$nom' WHERE id = $_SESSION[userid]";
                        $ORes2 = $Bdd->query($req2);
                        $confirm = $confirm . "Le nom a bien été changé<br/>";
                    }
                    // changement de prenom
                    if(!empty($_POST["prenom"])) {
                        $prenom = addslashes($_POST["prenom"]);
                        $req2 = "UPDATE users SET prenom = '$prenom' WHERE id = $_SESSION[userid]";
                        $ORes2 = $Bdd->query($req2);
                        $confirm = $confirm . "Le prénom a bien été changé<br/>";
                    }
                    // changement d'adresse
                    if(!empty($_POST["adresse"])) {
                        $adresse = addslashes($_POST["adresse"]);
                        $req2 = "UPDATE users SET adresse = '$adresse' WHERE id = $_SESSION[userid]";
                        $ORes2 = $Bdd->query($req2);
                        $confirm = $confirm . "L'adresse a bien été changée<br/>";
                    }
                    // changement de mdp
                    if(!empty($_POST["mdp1"])) {
                        if ($_POST["mdp1"] == $_POST["mdp2"]) {
                            $mdp = sha1($_POST["mdp1"]);
                            $req2 = "UPDATE users SET mdp = '$mdp' WHERE id = $_SESSION[userid]";
                            $ORes2 = $Bdd->query($req2);
                            $confirm = $confirm . "Le mot de passe a bien été enregistré<br/>";
                        } else $erreur = "Vos mots de passes ne correspondent pas";
                    }
                    // changement de mail
                    if(!empty($_POST["mail"])) {
                        $mail = addslashes($_POST["mail"]);
                        $req2 = "UPDATE users SET mail = '$mail' WHERE id = $_SESSION[userid]";
                        $ORes2 = $Bdd->query($req2);
                        $confirm = $confirm . "L'adresse mail a bien été changée";
                    }
                } else {
                    $erreur = "Le mot de passe de base n'est pas correct";    
                }
            }
        } else $erreur = "Vous devez rentrer votre mot de passe actuel";
    }
    // changement de photo
    if(isset($_POST["validerimage"])) {
        if (basename($_FILES["fichier"]["name"]) != NULL) { // si un fichier a été mis
            $target_file = "imagesusers/" . basename($_FILES["fichier"]["name"]);
            $target_file =  substr($target_file, 0, -4) . 1 . substr($target_file, -4);
            if(getimagesize($_FILES["fichier"]["tmp_name"]) != false) { // si la taille du fichier n'est pas résonable
                $uploaderror = 1;
            } else {
                $uploaderror = 0;
            }

            // si le fichier existe déjà on ajoute + 1 à la fin du nom
            while (file_exists($target_file)) {
                $lastchar = $target_file[strlen($target_file)-5];
                $numb = (int)$lastchar + 1;
                $target_file = substr($target_file, 0, -5) . "$numb" . substr($target_file, -4);
            }

            // vérification du format
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) {
                $uploaderror = 0;
            }

            // Si il y a eu une erreur
            if ($uploaderror == 0) {
                $erreur2 = "Votre fichier n'est pas valide";
            } else {
                if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $target_file)) {
                    $confirm2 = "Le fichier ". htmlspecialchars(basename( $_FILES["fichier"]["name"])) . " a été mis à jour";
                    // on mets en BDD le nom du fichier, sans le nom du dossier
                    $target_file = substr($target_file, 12, (strlen($target_file)-1));
                    $requp = "UPDATE users SET photo = '$target_file' WHERE id = $_SESSION[userid]";
                    $OResup = $Bdd->query($requp);
                } else { // si le fichier n'a pas réussi à s'enregistrer
                    $erreur2 = "Une erreur s'est produite...";
                }
            }
        } else { // si aucune photo n'a été mis, ont reset l'image
            $confirm2 = "Votre photo a bien été réinitialisé";
            $requp = "UPDATE users SET photo = '' WHERE id = $_SESSION[userid]";
            $OResup = $Bdd->query($requp);
        }
    }

    $req = "SELECT * FROM users WHERE id = '$_SESSION[userid]'";
    $ORes = $Bdd->query($req);
    if ($Usr = $ORes->fetch()) {
        if (empty($Usr->adresse)) {$adresse = "Adresse non précisé";}
        else {$adresse = $Usr->adresse;}
        ?>
        <div class="page">
            <!-- div pour le profil / changements d'informations -->
            <div class="profil">
                <form action="" method="POST">
                    <h1>Gestion du compte</h1>
                    <input type="text" name="prenom" placeholder="<?php echo $Usr->prenom; ?>"> <input type="text" name="nom" placeholder="<?php echo $Usr->nom; ?>">
                    <input type="text" name="adresse" placeholder="<?php echo $adresse; ?>" style="margin-top: 5px;"><br><br>
                    <label for="email" >Changement d'adresse email ou de mot de passe:</label>
                    <input type="email" name="mail" placeholder="<?php echo $Usr->mail; ?>" id="email"><br>
                    <input type="password" name="mdpa" placeholder="Mot de passe actuel" style="margin: 10px;"> <br>
                    <input type="password" name="mdp1" placeholder="Nouveau mot de passe"> <br>
                    <input type="password" name="mdp2" placeholder="Confirmer le mot de passe" style="margin-top:5px;">
                    <br><br>
                    <?php if(isset($erreur)) {echo "<p style='color:red;'>$erreur</p>";unset($erreur);} ?>
                    <?php if(isset($confirm)) {echo "<p style='color:green;'>$confirm</p>";unset($confirm);} ?>
                    <button class="button" name="valider">Valider</button>
                </form>
            </div>
            <!-- div seulement pour la photo -->
            <div class="photo">
                <form action="" method="POST" enctype="multipart/form-data">
                    <p style="text-decoration:underline;margin-bottom:45px;">Photo de profil</p>
                    <img style="height: 100px; width: 100px;" src="<?php if(empty($Usr->photo)) {echo 'images/user.png';} else {echo 'imagesusers/'.$Usr->photo;} ?>" alt="Photo d'utilisateur"><br>
                    <label for="fichierphoto">Changer la photo de profil :</label>
                    <input type="file" name="fichier" id="fichierphoto"><br><br>
                    <?php if(isset($erreur2)) {echo "<p style='color:red;'>$erreur2</p>";unset($erreur2);} ?>
                    <?php if(isset($confirm2)) {echo "<p style='color:green;'>$confirm2</p>";unset($confirm2);} ?>
                    <button class="button2" value="Upload Image" name="validerimage">Valider</button>
                </form>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div style="text-align:center;margin-top:250px;font-size:100px;">
      <p style="color:red;">Accès refusé</p>
    </div>
    <?php
}


