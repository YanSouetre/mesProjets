<?php
if(isset($_SESSION["online"])) {
    foreach($_POST as $key => $value) {
        if((explode("-",$key))[0] == "acc" ) { // accepter la demande
            $id = addslashes(explode("-",$key)[1]);
            $ORes = $Bdd->query("SELECT * FROM demandes WHERE usersid = '$id' AND friendid = '$_SESSION[userid]'");
            if ($Usr = $ORes->fetch()) {
                $ORes2 = $Bdd->query("DELETE FROM demandes WHERE usersid = '$id' AND friendid = '$_SESSION[userid]'");
                $ORes2 = $Bdd->query("INSERT INTO amis (usersid, friendid) VALUES ('$_SESSION[userid]', '$id'), ('$id', '$_SESSION[userid]')");
                $Ami = ($Bdd->query("SELECT prenom, nom FROM users WHERE id = '$id'"))->fetch();
                $msg = "Vous êtes désormais ami avec $Ami->nom $Ami->prenom";
            } else {
                $err = "Demande expirée";
            }
        } else if((explode("-",$key))[0] == "ref" ) { // refuser la demande
            $id = addslashes(explode("-",$key)[1]);
            $ORes = $Bdd->query("SELECT * FROM demandes WHERE usersid = '$id' AND friendid = '$_SESSION[userid]'");
            if ($Usr = $ORes->fetch()) {
                $ORes2 = $Bdd->query("DELETE FROM demandes WHERE usersid = '$id' AND friendid = '$_SESSION[userid]'");
                $Ami = ($Bdd->query("SELECT prenom, nom FROM users WHERE id = '$id'"))->fetch();
                $err = "Vous avez refusé la demande de $Ami->nom $Ami->prenom";
            } else {
                $err = "Demande expirée";
            }
        }
    }

    $ORes = $Bdd->query("SELECT * FROM demandes WHERE friendid = '$_SESSION[userid]'");
    ?> <div style="display:flex;justify-content:center;"> <?php
    if (isset($msg)) { echo "<div><p style='color:green;'>$msg</p></div>"; }
    if (isset($err)) { echo "<div><p style='color:red;'>$err</p></div>"; }
    while ($Usr = $ORes->fetch()) {
        $yes = TRUE;
        $Prs = ($Bdd->query("SELECT * FROM users WHERE id = '$Usr->usersid'"))->fetch();
        ?>
        <div style="border-radius:10px;text-align:center;background-color:white;width:265px;height:120px;margin:20px;display: inherit;justify-content: space-between;">
            <div style="text-align:center;"><img src="<?php if(empty($Prs->photo)) { echo "images/user.png"; } else { echo "imagesusers/$Prs->photo"; } ?>" style="border-radius:9px;height:120px;width:120px;" alt="Photo d'utilisateur"></div>
            <div style="text-align:center;padding-right:3px;">
                <p><?php echo "$Prs->nom $Prs->prenom<br>Vous a ajouté en ami<br><br>"; ?></p>
                <form action="" method="POST">
                    <button type="submit" name="acc-<?php echo $Prs->id; ?>">Accepter</button>
                    <button type="submit" name="ref-<?php echo $Prs->id; ?>">Refuser</button>
                </form>
            </div>
        </div>
        <?php
    }
    if (!isset($yes)) {
        ?>
        <div style="border-radius:10px;text-align:center;background-color:white;width:265px;height:50px;margin:20px;">
            <p>Vous n'avez pas de notifications</p>
        </div>
        <?php
    }
    ?> </div> <?php
} else {
    ?>
    <div style="text-align:center;margin-top:250px;font-size:100px;">
      <p style="color:red;">Accès refusé</p>
    </div>
    <?php
}