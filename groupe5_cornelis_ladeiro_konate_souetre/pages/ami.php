<?php
if(isset($_SESSION["online"])) {
    foreach($_POST as $key => $value) {
        if((explode("-",$key))[0] == "ref" ) { // supprimer l'amis
            $id = addslashes(explode("-",$key)[1]);
            $ORes = $Bdd->query("SELECT * FROM amis WHERE usersid = '$_SESSION[userid]' AND friendid = '$id'");
            if ($Usr = $ORes->fetch()) {
                $ORes2 = $Bdd->query("DELETE FROM amis WHERE usersid = '$id' AND friendid = '$_SESSION[userid]'");
                $ORes2 = $Bdd->query("DELETE FROM amis WHERE usersid = '$_SESSION[userid]' AND friendid = '$id'");
                $Ami = ($Bdd->query("SELECT prenom, nom FROM users WHERE id = '$id'"))->fetch();
                $err = "Vous n'êtes plus amis avec $Ami->nom $Ami->prenom";
            } else {
                $err = "Demande expirée";
            }
        }
    }

    $ORes = $Bdd->query("SELECT usersid, friendid, (DATEDIFF(CURDATE(),date) + 1) as jour FROM amis WHERE usersid = '$_SESSION[userid]'");
    ?> <div style="display:flex;justify-content:center;"> <?php
    if (isset($msg)) { echo "<div><p style='color:green;'>$msg</p></div>"; }
    if (isset($err)) { echo "<div><p style='color:red;'>$err</p></div>"; }
    while ($Usr = $ORes->fetch()) {
        $yes = TRUE;
        $Prs = ($Bdd->query("SELECT * FROM users WHERE id = '$Usr->friendid'"))->fetch();
        ?>
        <div style="border-radius:10px;text-align:center;background-color:white;width:290px;height:140px;margin:20px;display: inherit;justify-content: space-between;">
            <div style="text-align:center;"><img src="<?php if(empty($Prs->photo)) { echo "images/user.png"; } else { echo "imagesusers/$Prs->photo"; } ?>" style="border-radius:9px;height:140px;width:140px;" alt="Photo d'utilisateur"></div>
            <div style="text-align:center;padding-right:3px;">
                <p><?php echo "$Prs->nom $Prs->prenom<br><br>Vous êtes amis<br>depuis $Usr->jour jours"; ?></p>
                <form action="" method="POST">
                    <button type="submit" name="ref-<?php echo $Prs->id; ?>">Retirer de mes amis</button>
                </form>
            </div>
        </div>
        <?php
    }
    if (!isset($yes)) {
        ?>
            <div style="border-radius:10px;text-align:center;background-color:white;width:350px;height:75px;margin:20px;">
                <p>Vous n'avez pas encore d'amis<br>Cliquez sur la loupe en haut à droite pour en ajouter</p>
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