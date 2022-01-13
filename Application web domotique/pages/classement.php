<?php
    $Stats = ($Bdd->query("SELECT SUM(pieces) as sommepieces, SUM(objets) as sommeobjets FROM `stats`"))->fetch();
    echo "<div style='display:flex;justify-content:center;font-size:20px;color:white;text-align:center;'><p>Voici le classement des 10 premiers utilisateurs avec leurs statistiques<br>$Stats->sommeobjets objets ont étés crées sur le site, avec un total de $Stats->sommepieces pièces</p></div>";
    $ORes = $Bdd->query("SELECT s.pieces, s.objets, (DATEDIFF(CURDATE(),u.firstco) + 1) as jour, u.nom, u.prenom, u.photo FROM stats as s LEFT JOIN users as u ON id = s.usersid ORDER BY s.objets DESC LIMIT 10");
    while ($Usr = $ORes->fetch()) {
        ?>
        <div style="display:flex;justify-content:center;">
            <div style="border-radius:10px;text-align:center;background-color:white;width:260px;height:120px;margin:20px;display: inherit;justify-content: space-between;">
                <div style="text-align:center;"><img src="<?php if(empty($Usr->photo)) { echo "images/user.png"; } else { echo "imagesusers/$Usr->photo"; } ?>" style="border-radius:9px;height:120px;width:120px;" alt="Photo d'utilisateur"></div>
                <div style="text-align:center;padding-right:3px;">
                    <?php echo "$Usr->nom $Usr->prenom<br><br><br>"; ?>
                    <?php echo "Pièces crées : $Usr->pieces<br>"; ?>
                    <?php echo "Objets crées : $Usr->objets"; ?>
                    <?php echo "<br>Actif depuis $Usr->jour jours<br>"; ?>
                </div>
            </div>
        </div>
        <?php
    }