<title>Domotech - Controle</title>
<link rel="stylesheet" href="css/controle/controle.css">
<!-- Début du code de contrôle -->
<!-- Boutons -->
<?php
if(isset($_SESSION["online"])) {
    // fonction starts with
    function str_starts_with ( $haystack, $needle ) {
        return strpos( $haystack , $needle ) === 0;
    }
    // etats des boutons on/off/stop
    if (isset($_POST)) {
        foreach ($_POST as $key => $value) {
            if(str_starts_with($key, 'on-')) { //on-id
                $id = explode("-",$key)[1]; //recupère seulement l'id
                $req3 = "UPDATE objets SET etat = 1 WHERE id = '$id'";
                $ORes3 = $Bdd->query($req3);
            } else if (str_starts_with($key, 'off-')) { //off-id
                $id = explode("-",$key)[1];
                $req3 = "UPDATE objets SET etat = 0 WHERE id = '$id'";
                $ORes3 = $Bdd->query($req3);
            } else if (str_starts_with($key, 'stop-')) { //stop-id
                $id = explode("-",$key)[1];
                $req3 = "UPDATE objets SET etat = 2 WHERE id = '$id'";
                $ORes3 = $Bdd->query($req3);
            }
        }
    }
    // changement etats ampoule
    if (isset($_POST["Enregistrer1"])) {
        $req4 = "SELECT * FROM objets WHERE id = '$_POST[Enregistrer1]'";
        $ORes4 = $Bdd->query($req4);
        if ($Obj = $ORes4->fetch()) {
            $precision = $_POST["couleur"] . ";" . $_POST["lumi"]; //#c12f2f;80
            $req3 = "UPDATE objets SET etatprecision = '$precision' WHERE id = '$_POST[Enregistrer1]'";
            $ORes3 = $Bdd->query($req3);
        }
        unset($_POST["Enregistrer1"]);
    }
    // changement etats alarme
    if (isset($_POST["Enregistrer2"])) {
        $req4 = "SELECT * FROM objets WHERE id = '$_POST[Enregistrer2]'";
        $ORes4 = $Bdd->query($req4);
        if ($Obj = $ORes4->fetch()) {
            $precision = $_POST["activation"] . ";" . $_POST["desactivation"];//08:10;16:30
            $req3 = "UPDATE objets SET etatprecision = '$precision' WHERE id = '$_POST[Enregistrer2]'";
            $ORes3 = $Bdd->query($req3);
        }
        unset($_POST["Enregistrer2"]);
    }
    // changement etats chauffage
    if (isset($_POST["Enregistrer3"])) {
        $req4 = "SELECT * FROM objets WHERE id = '$_POST[Enregistrer3]'";
        $ORes4 = $Bdd->query($req4);
        if ($Obj = $ORes4->fetch()) {
            $precision = $_POST["temperature"] . ";" . $_POST["activation"] . ";" . $_POST["desactivation"];
            $req3 = "UPDATE objets SET etatprecision = '$precision' WHERE id = '$_POST[Enregistrer3]'";
            $ORes3 = $Bdd->query($req3);
        }
        unset($_POST["Enregistrer3"]);
    }
    // changement etats volets
    if (isset($_POST["Enregistrer4"])) {
        $req4 = "SELECT * FROM objets WHERE id = '$_POST[Enregistrer4]'";
        $ORes4 = $Bdd->query($req4);
        if ($Obj = $ORes4->fetch()) {
            $precision = $_POST["activation"] . ";" . $_POST["desactivation"];
            $req3 = "UPDATE objets SET etatprecision = '$precision' WHERE id = '$_POST[Enregistrer4]'";
            $ORes3 = $Bdd->query($req3);
        }
        unset($_POST["Enregistrer4"]);
    }
?>
<!-- Interface -->
<?php
    $pceExist = False;
    $req = "SELECT * FROM lieu WHERE usersid = '$_SESSION[userid]'";
    $ORes = $Bdd->query($req);   
    while ($Lieu = $ORes->fetch()){ 
        $pceExist = True; ?>
        <div class="piece"> <!-- Affichage des pièces -->
            <h1><?php echo "Vous êtes dans : ".$Lieu->nom; ?></h1>
            <a href="?p=appareils"><input type="button" value="Vers mes appareils" class="btnRetour"></a>
        </div> 

        <section class="carousel">       <!-- Affichage des objets -->   
            <ul class="carousel-items"> 
        <?php
        $objExist = False; 
        $req2 = "SELECT * FROM objets WHERE lieuid = '$Lieu->id'";
        $ORes2 = $Bdd->query($req2);
        while ($Objets = $ORes2->fetch()){
            $objExist = True;

            //Ampoule
            if($Objets->typeid == 1){?>         <!-- Typeid = 1 Pour l'ampoule -->
                <form action="" method="POST">
                    <div class="carousel-item">
                        <div id="<?php echo $Objets->id;?>" class="card">
                            <h1 class="titre">Ampoule</h1> 
                            <input name="on-<?php echo $Objets->id;?>" type="submit" value="ON" class="btnOnOff" style="<?php if($Objets->etat == 1) { echo "background-color:green;"; }; ?>"> <!-- bouton ON -->
                            <input name="off-<?php echo $Objets->id;?>" type="submit" value="OFF" class="btnOnOff" style="<?php if($Objets->etat == 0) { echo "background-color:red;"; }; ?>"> <!-- bouton OFF -->
                            <br>
                            <label for="couleur">Changer la couleur :</label>
                            <input type="color" name="couleur" id="couleur" value="<?php if (empty($Objets->etatprecision)) { echo "000000";} else { echo explode(";", $Objets->etatprecision)[0]; } ?>"> <!-- Couleur -->
                            <br>
                            <input type="range" name="lumi" id="lumi" value="<?php if (empty($Objets->etatprecision)) { echo "000000";} else { echo explode(";", $Objets->etatprecision)[1]; } ?>"> <!-- Luminosité -->
                            <label for="lumi">Luminosité</label>
                            </br>
                            <button class="btnRetour" type="submit" name="Enregistrer1" value="<?php echo $Objets->id; ?>">Sauvegarder les paramètres</button>
                        </div>
                    </div>
                </form>
            <?php
            }

            //L'alarme
            if($Objets->typeid == 2){?> 
                <form action="" method="POST">        <!-- Typeid = 2 Pour l'alarme -->
                    <div class="carousel-item">
                        <div id="<?php echo $Objets->id;?>" class="card">
                            <h1 class="titre">Alarme</h1>
                            <input name="on-<?php echo $Objets->id;?>" type="submit" value="ON" class="btnOnOff" style="<?php if($Objets->etat == 1) { echo "background-color:green;"; }; ?>"> <!-- bouton ON -->
                            <input name="off-<?php echo $Objets->id;?>" type="submit" value="OFF" class="btnOnOff" style="<?php if($Objets->etat == 0) { echo "background-color:red;"; }; ?>"> <!-- bouton OFF -->
                            <br>
                            <label for="activation">Programmer une heure d'activation :</label>
                            <input name="activation" class="time" type="time" id="activation" value="<?php if (!empty($Objets->etatprecision)) { echo explode(";", $Objets->etatprecision)[0]; } ?>"> <!-- sélecteur d'heure -->
                            <br>
                            <label for="desactivation">Programmer une heure de désactivation :</label>
                            <input name="desactivation" class="time" type="time" id="desactivation" value="<?php if (!empty($Objets->etatprecision)) { echo explode(";", $Objets->etatprecision)[1]; } ?>"> <!-- sélecteur d'heure -->
                            </br>
                            <button class="btnRetour" type="submit" name="Enregistrer2" value="<?php echo $Objets->id; ?>">Sauvegarder les paramètres</button>
                        </div>
                    </div>
                </form>
            <?php
            }

            //Chauffage
            if($Objets->typeid == 3){?>   
                <form action="" method="POST">      <!-- Typeid = 3 Pour le chauffage -->
                    <div class="carousel-item">
                        <div id="<?php echo $Objets->id;?>" class="card">
                            <h1 class="titre">Chauffage</h1> 
                            <input name="on-<?php echo $Objets->id;?>"  type="submit" value="ON" class="btnOnOff" style="<?php if($Objets->etat == 1) { echo "background-color:green;"; }; ?>"> <!-- bouton ON -->
                            <input name="off-<?php echo $Objets->id;?>" type="submit" value="OFF" class="btnOnOff" style="<?php if($Objets->etat == 0) { echo "background-color:red;"; }; ?>"> <!-- bouton OFF -->
                            <br>
                            <label for="temperature">Programmer une température :</label>
                            <input name="temperature" type="number" id="temperature" placeholder="<?php if (!empty($Objets->etatprecision)) { echo explode(";", $Objets->etatprecision)[0] . "°C"; } else { echo "°C"; } ?>"> <!-- sélecteur de numéros -->
                            <br>
                            <label for="activation">Programmer une heure d'activation :</label>
                            <input name="activation" class="time" type="time" id="activation" value="<?php if (!empty($Objets->etatprecision)) { echo explode(";", $Objets->etatprecision)[1]; } ?>"> <!-- sélecteur d'heure -->
                            <br>
                            <label for="desactivation">Programmer une heure de désactivation :</label>
                            <input name="desactivation" class="time" type="time" id="desactivation" value="<?php if (!empty($Objets->etatprecision)) { echo explode(";", $Objets->etatprecision)[2]; } ?>"> <!-- sélecteur d'heure -->
                            </br>
                            <button class="btnRetour" type="submit" name="Enregistrer3" value="<?php echo $Objets->id; ?>">Sauvegarder les paramètres</button>
                        </div>
                    </div>
                </form>
            <?php
            }

            //Volets 
            if($Objets->typeid == 4){?>    
                <form action="" method="POST">     <!-- Typeid = 4 Pour les volets -->
                    <div class="carousel-item">
                        <div id="<?php echo $Objets->id;?>" class="card">
                            <h1 class="titre">Volets</h1> 
                            <input name="on-<?php echo $Objets->id;?>" type="submit" value="Ouvrir" class="btnOnOff" style="<?php if($Objets->etat == 1) { echo "background-color:green;"; }; ?>"> <!-- bouton OUVRIR -->
                            <input name="off-<?php echo $Objets->id;?>" type="submit" value="Fermer" class="btnOnOff" style="<?php if($Objets->etat == 0) { echo "background-color:red;"; }; ?>"> <!-- bouton FERMER -->
                            <input name="stop-<?php echo $Objets->id;?>" type="submit" value="Stop" class="btnOnOff" style="<?php if($Objets->etat == 2) { echo "background-color:red;"; }; ?>"> <!-- bouton STOP -->
                            <br>
                            <label for="activation">Programmer une heure d'activation :</label>
                            <input name="activation" class="time" type="time" id="activation" value="<?php if (!empty($Objets->etatprecision)) { echo explode(";", $Objets->etatprecision)[0]; } ?>"> <!-- sélecteur d'heure -->
                            <br>
                            <label for="desactivation">Programmer une heure de désactivation :</label>
                            <input name="desactivation" class="time" type="time" id="desactivation" value="<?php if (!empty($Objets->etatprecision)) { echo explode(";", $Objets->etatprecision)[1]; } ?>"> <!-- sélecteur d'heure -->
                            </br>
                            <button class="btnRetour" type="submit" name="Enregistrer4" value="<?php echo $Objets->id; ?>">Sauvegarder les paramètres</button>
                        </div>
                    </div>
                </form>
                <?php
            }
        }

        //Si aucun objet n'a été trouvé
        if ($objExist == False){ ?>
            <div id="pasObjets">
                <h2>Aucun objets enregistrés dans cette pièce !</h2>
                <a href="?p=appareils"><input type="button" value="Vers mes appareils" class="btnRetour"></a> 
            </div>
            <?php
        }
            ?>
            </ul>
        </section>
        <?php
    }

    //si aucun pièce n'a été trouvé
    if ($pceExist == False){ ?>
        <div id="pasObjets">
            <h2>Il n'y a pas de pièces !</br> Veuillez en créer une</h2>
            <a href="?p=appareils"><input type="button" value="Vers mes appareils" class="btnRetour"></a> 
        </div> <?php
    }
} else {
    ?>
    <div style="text-align:center;margin-top:250px;font-size:100px;">
        <p style="color:red;">Accès refusé</p>
    </div>
    <?php
}