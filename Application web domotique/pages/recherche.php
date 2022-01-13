<?php
if(isset($_SESSION["online"])) {
    if (isset($_POST["add"])) {
        if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) == FALSE) {
            $err = "Vous devez rentrer un mail valide.";
        } else {
            // si il a un compte
            $ORes = $Bdd->query("SELECT * FROM users WHERE mail = '$_POST[mail]'");
            if ($Usr = $ORes->fetch()) {
                // si il s'ajoute lui même
                if ($Usr->id == $_SESSION["userid"]) {
                    $err = "Vous ne pouvez pas vous ajouter en ami...";
                } else {
                    // si ils sont déjà amis
                    $ORes2 = $Bdd->query("SELECT * FROM amis WHERE usersid = '$_SESSION[userid]' AND friendid = '$Usr->id'");
                    if ($Usr2 = $ORes2->fetch()) {
                        $err = "Cette personne est déjà dans votre liste d'amis";
                    } else {
                        // si il a déjà fait une demande
                        $ORes2 = $Bdd->query("SELECT * FROM demandes WHERE usersid = '$_SESSION[userid]' AND friendid = '$Usr->id'");
                        if ($Usr2 = $ORes2->fetch()) {
                            $err = "Vous avez déjà demandé cette personne en ami";
                        } else {
                            // si son amis lui a déjà fait une demande
                            $ORes2 = $Bdd->query("SELECT * FROM demandes WHERE usersid = '$Usr->id' AND friendid = '$_SESSION[userid]'");
                            if ($Usr2 = $ORes2->fetch()) {
                                $err = "Cette personne vous demande déjà en amis";
                            } else {
                                // on peut ajouter la personne
                                $ORes2 = $Bdd->query("INSERT INTO demandes (usersid, friendid) VALUES ('$_SESSION[userid]','$Usr->id')");
                                $msg = "Votre demande à $Usr->nom $Usr->prenom a bien été envoyée";
                            }
                        }
                    }
                }
            } else {
                $err = "L'utilisateur n'est pas inscrit sur la plateforme. Merci de vérifier l'email.";
            }
        }
    }
    ?>

    <div style="width:100%;height:120px;text-align:center;background-color:white;">
        <p>Rentrez ci dessous l'adresse email de la personne que vous voulez ajouter en ami</p>
        <form action="" method="POST">
            <br><input type="mail" name="mail">
            <button type="submit" name="add">Ajouter</button>
        </form>
        <?php if(isset($msg)) {echo "<p style='color:green'>$msg</p>";unset($msg);} ?>
        <?php if(isset($err)) {echo "<p style='color:red'>$err</p>";unset($err);} ?>
    </div>

    <?php
    $ORes = $Bdd->query("SELECT * FROM demandes WHERE usersid = '$_SESSION[userid]'");
    while($Dmd = $ORes->fetch()) {
        $Ami = ($Bdd->query("SELECT prenom, nom, photo FROM users WHERE id = '$Dmd->friendid'"))->fetch();
        ?>
        <div style="display:flex;justify-content:center;">
            <div style="border-radius:10px;text-align:center;background-color:white;width:265px;height:120px;margin:20px;display: inherit;justify-content: space-between;">
                <div style="text-align:center;"><img src="<?php if(empty($Ami->photo)) { echo "images/user.png"; } else { echo "imagesusers/$Ami->photo"; } ?>" style="border-radius:9px;height:120px;width:120px;" alt="Photo d'utilisateur"></div>
                <div style="text-align:center;padding-right:3px;">
                    <p><?php echo "$Ami->nom $Ami->prenom<br><br><br><br>Demande en attente..." ?></p>
                </div>
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