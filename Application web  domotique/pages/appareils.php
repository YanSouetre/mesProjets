<title>Domotech - Appareils</title>
<link rel="stylesheet" href="css/appareils/appareils.css">
<?php
if(isset($_SESSION["online"])) {
  ?>
  <!-- BOUTONS DE SUP ET AJOUT DE PIECE  -->
  <div class="box">
    <a class="bouttonss" href="#popup1">Ajouter une pièce </a>
    <a class="bouttonss2" href="#popup3">Modifier le nom d'une pièce</a>
    <a class="bouttonss1" href="#popup2">Supprimer une pièce</a>
  </div>

  <!-- POPUP DU BTN AJOUTER UNE PIECE  -->
  <form action="" method="POST">
    <div id="popup1" class="overlay">
      <div class="popup">
        <h2>Ajouter une pièce</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
          <div class="form__group field">
              <input type="input" class="form__field" placeholder="Nom de la pièce" name="nomdelapiece" id='nom de la pièce' required />
              <label for="name" class="form__label">Nom/pièce</label>
          </div>
        </div>
          <div class="multi-button skin1">
            <button type="submit">Ajouter</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- POPUP DU BTN modif UNE PIECE  -->
  <form action="" method="POST">
    <div id="popup3" class="overlay">
      <div class="popup3">
        <h2>Modifier le nom d'une piece</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
        <div class="content">
            <label class="custom-select" for="styledSelect1">
              <select id="styledSelect1" name="options2" required >
                <option value="">
                  Choisissez une pièce
                </option>
                <?php
                //  on selectionne les pieces de lutilisateur
                  $req2 = "SELECT * FROM lieu WHERE usersid = '$_SESSION[userid]'"; 
                  $ORes2 = $Bdd->query($req2);
                  while ($lieu = $ORes2->fetch()){
                    ?>
                      <option value= <?php echo $lieu->id;  ?>>
                      <!-- on récupère les id des pieces pour pouvoir les supp par la suite  -->
                        <?php echo $lieu->nom; ?>
                        <!-- on affiche le nom des pièces dans le selecteur -->
                      </option>
                    <?php
                  }
                ?>
              </select>
            </label>
          </div>
          <div class="form__group2 field2">
              <input type="input" class="form__field2" placeholder="modifdelapiece" name="modifdelapiece" id='modifdelapiece' required />
              <label for="name" class="form__label2">Modifier/pièce</label>
          </div>     
        </div>
          <div class="multi-button skin3">
            <button name="modifr" type="submit">Modifier</button>
          </div>
        </div>
      </div>
    </div>
  </form>
<?php 

  if(isset($_POST["modifdelapiece"]) && isset($_POST["modifdelapiece"])  && isset($_POST["modifr"]))
  {
    if(!empty($_POST["modifdelapiece"]))
    {
      $lieum = addslashes($_POST["modifdelapiece"]);
      $options2 = addslashes($_POST["options2"]);
      $req222 = "UPDATE lieu SET nom = '$lieum' WHERE usersid = '$_SESSION[userid]' and id = '$options2'";
      $ORes222 = $Bdd->query($req222);
      ?>
      <script>
        document.location.href="index.php?p=appareils";
      </script>
    <?php
    }
  }
    ?>


  <?php 
  // ajout de la pièce (précision du nom de la pièce)
  // on vérifie si l'élément à utiliser pour notre req existe 
  if(isset($_POST["nomdelapiece"])){
    $piece = addslashes($_POST["nomdelapiece"]);
    $req = "INSERT INTO lieu (usersid,nom) VALUES ('$_SESSION[userid]','$piece')"; 
    $ORes = $Bdd->query($req);
    $ORes999 = $Bdd->query("UPDATE stats SET pieces = (SELECT COUNT(*) FROM lieu WHERE usersid = '$_SESSION[userid]') WHERE usersid = '$_SESSION[userid]'");
    unset($_POST["nomdelapiece"]);
    ?>
    <script>
      document.location.href="index.php?p=appareils";
    </script>
  <?php
  }
  ?>

  <form action="" method="POST">
    <!-- POPUP DE BTN SUR UNE PIECE  -->
    <div id="popup2" class="overlay">
      <div class="popup2">
        <h2>Supprimer une pièce</h2>
        <a class="close" href="#">&times;</a>
          <div class="content">
            <label class="custom-select" for="styledSelect1">
              <select id="styledSelect1" name="options">
                <option value="">
                  Choisissez une pièce
                </option>
                <?php
                //  on selectionne les pieces de lutilisateur
                  $req2 = "SELECT * FROM lieu WHERE usersid = '$_SESSION[userid]'"; 
                  $ORes2 = $Bdd->query($req2);
                  while ($lieu = $ORes2->fetch()){
                    ?>
                      <option value= <?php echo $lieu->id;  ?>>
                      <!-- on récupère les id des pieces pour pouvoir les supp par la suite  -->
                        <?php echo $lieu->nom; ?>
                        <!-- on affiche le nom des pièces dans le selecteur -->
                      </option>
                    <?php
                  }
                ?>
              </select>
            </label>
          </div>
        <!-- btn supp dans le popup  -->
        <div class="multi-button skin2">
          <button type="submit" name="suppr">Supprimer</button>
        </div>
      </div>
    </div>
  </form>

  <?php 

  // suppression de la pièce (boutton appuyé)
  if(isset($_POST["suppr"])) {
    $req2 = "SELECT * FROM lieu WHERE usersid = '$_SESSION[userid]'"; 
    $ORes2 = $Bdd->query($req2);
    while ($lieu = $ORes2->fetch()){
      if($_POST["options"] == $lieu->id)
      {
        $id = $_POST["options"];
        $req3 = "DELETE FROM lieu WHERE id = '$id'";
        $ORes3 = $Bdd->query($req3);
        $ORes999 = $Bdd->query("UPDATE stats SET pieces = (SELECT COUNT(*) FROM lieu WHERE usersid = '$_SESSION[userid]') WHERE usersid = '$_SESSION[userid]'");
        ?>
        <script>
          document.location.href="index.php?p=appareils";
        </script>
      <?php
      }
    }
    unset($_POST["suppr"]);unset($_POST["options"]);
  } 

  ?>

  <!-- titre  -->
  <h4 class="wordCarousel">
    <div class="div">
        <li class="li">Liste des pièces</li>
    </div>
  </h4>


  <?php 


  // ajout appa / suppression appa
  foreach ($_POST as $key => $value) { 
    if((explode("-",$key))[0] == "options" ) {
      if(isset($_POST["ajoutappareils"])) {
        unset($_POST["ajoutappareils"]);
        $lieuid = explode("-",$key)[1];
        $typeid = $value;
        switch($typeid)
        {
          case 1 : $nom = "Ampoule";break;
          case 2 : $nom = "Alarme";break;
          case 3 : $nom = "Chauffage";break;
          case 4 : $nom = "Volets";break;
          default : $erreur = True;break;
        }
        //si erreur modification manuel de luser 
        if(!isset($erreur))
        {
          $etat = 0;
          $etatprecision = "";
          $req99 = "INSERT INTO objets (lieuid,typeid,nom,etat,etatprecision,usersid) VALUES ('$lieuid','$typeid','$nom','$etat','$etatprecision','$_SESSION[userid]')";
          $ORes99 = $Bdd->query($req99);
          $ORes999 = $Bdd->query("UPDATE stats SET objets = (SELECT COUNT(*) FROM objets WHERE usersid = '$_SESSION[userid]') WHERE usersid = '$_SESSION[userid]'");
          $_POST["ajoutappareils"] = false;
          ?>
            <script>
              document.location.href="index.php?p=appareils";
            </script>
          <?php
        }
      } else if (isset($_POST["supprappareils"])) {
        unset($_POST["supprappareils"]);
        $id = $value;
        $req99 = "DELETE FROM objets WHERE id = '$id' and  usersid = '$_SESSION[userid]'";
        $ORes99 = $Bdd->query($req99); unset($id);
        $ORes999 = $Bdd->query("UPDATE stats SET objets = (SELECT COUNT(*) FROM objets WHERE usersid = '$_SESSION[userid]') WHERE usersid = '$_SESSION[userid]'");
        ?>
        <script>
          document.location.href="index.php?p=appareils";
        </script>
      <?php
      }
    }
  }


  // liste et affiche les pièces de l'utilisateur
  $req2 = "SELECT * FROM lieu WHERE usersid = '$_SESSION[userid]'";
  $ORes2 = $Bdd->query($req2);

  while ($lieu = $ORes2->fetch()) { ?>
    <!-- boutons d'ajouts  -->
    <div class="box2-<?php echo $lieu->id; ?>">
      <h2 id="police"><?php echo $lieu->nom; ?></h2>
      <a class="button45" href="#popupajout-<?php echo $lieu->id;?>">Ajouter un appareil</a>
      <a class="button46" href="#popupsup-<?php echo $lieu->id;?>">Supprimer un appareil</a>

    <form action="" method="POST">
        <!-- pop up btn ajouter "ajouter un appareil" dans piece-->
        <div id="popupajout-<?php echo $lieu->id;?>" class="overlay45">
        <div class="popupajout-<?php echo $lieu->id;?>">
          <h2>Ajouter un appareil</h2>
          <a class="close" href="#">&times;</a>
          <div class="content">
            <label class="custom-select" for="styledSelect1">
              <select id="styledSelect1" name="options-<?php  echo $lieu->id; ?>">
                <option value="">
                  Choisissez un appareil
                </option>
                <option value="1">
                  Ampoule
                </option>
                <option value="3">
                  Chauffage
                </option>
                <option value="2">
                  Alarme
                </option>
                <option value="4">
                  Volets
                </option>
              </select>
            </label>
          </div>
          <div class="multi-button skin12">
            <input type="hidden" name="ajoutappareils" value="0" />
            <button type="submit">Ajouter</button>
          </div>
        </div>
      </div>
    </form>
    <!-- Style popup ajout -->
    <style>
    <?php echo ".box2-$lieu->id";?>{
      float: left;
      z-index: 1;
      width: 90%;
    }
    <?php echo ".popupajout-$lieu->id";?> .button455 {
      margin-bottom: -1%;
      margin-left: 60%;
    }

    <?php echo ".popupajout-$lieu->id";?> {
      margin: 70px auto;
      padding: 20px;
      background: #fff;
      border-radius: 5px;
      width: 30%;
      position: relative;
      transition: all 5s ease-in-out;
    }

    <?php echo ".popupajout-$lieu->id";?> h2 {
      margin-right: 10px;
      font-size:30px ;
      margin-top: 0;
      color: #333;
      font-family: Tahoma, Arial, sans-serif;
    }
    <?php echo ".popupajout-$lieu->id";?> .close {
      margin-left: 10px;
      position: absolute;
      top: 20px;
      right: 30px;
      transition: all 0.5s;
      font-size: 30px;
      font-weight: bold;
      text-decoration: none;
      color: #333;
    }
    <?php echo ".popupajout-$lieu->id";?> .close:hover {
      color: #06D85F;
    }
    <?php echo ".popupajout-$lieu->id";?> .content {
      max-height: 30%;
      overflow: auto;
    }

    @media screen and (max-width: 768px){
      <?php echo ".popupajout-$lieu->id";?>{
      width: 80%;
      }
    }
    </style>
    <form action="" method="POST">
      <!-- popup btn supp  "supp un appa "   -->
      <div id="popupsup-<?php echo $lieu->id;?>" class="overlay46">
        <div class="popupsup-<?php echo $lieu->id;?>">
          <h2>Supprimer un appareil</h2>
          <a class="close" href="#">&times;</a>
          <div class="content">
            <label class="custom-select" for="styledSelect1">
              <select id="styledSelect1" name="options-<?php  echo $lieu->id; ?>">
                <option value="">
                  Choisissez un appareil
                </option>
                <?php 
                $req4 = "SELECT * FROM objets WHERE lieuid = '$lieu->id'";
                $ORes4 = $Bdd->query($req4);
                while ($Objet = $ORes4->fetch()) {
                  ?>
                  <option value="<?php echo $Objet->id; ?>">
                    <?php echo $Objet->nom; ?>
                  </option>
                  <?php
                }
                ?>
              </select>
            </label>
            </div>
          <div class="multi-button skin2">
            <button name="supprappareils" type="submit">Supprimer</button>
          </div>
        </div>
      </div>
    </form>
    <!-- style popup suppr -->
    <style>
      <?php echo ".popupsup-$lieu->id";?> {
        margin: 70px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 50%;
        position: relative;
        transition: all 5s ease-in-out;
      }

      <?php echo ".popupsup-$lieu->id";?> h2 {
        font-size:30px ;
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
      }
      <?php echo ".popupsup-$lieu->id";?> .close {
        margin-left: 10px;
        position: absolute;
        top: 20px;
        right: 30px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
      }
      <?php echo ".popupsup-$lieu->id";?> .close:hover {
        color: #d80606;
      }
      <?php echo ".popupsup-$lieu->id";?> .content {
        max-height: 30%;
        overflow: auto;
      }

      @media screen and (max-width: 768px){
        <?php echo ".popupsup-$lieu->id";?>{
        width: 80%;
        height: 20%;
        padding-bottom : 20%;
        }
      }
    </style>
    <?php
    $req4 = "SELECT * FROM objets WHERE lieuid = '$lieu->id'";
    $ORes4 = $Bdd->query($req4);
    while ($Objet = $ORes4->fetch()) { 
      if ($Objet->typeid == 1 && $Objet->etat == 0){ ?>
      <!-- Affichage objet -->
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front1">
              <div class="contents">
                <img src="images/lamp.png" />
                <h3>Ampoule</h3>
                <p>Ampoule dans  <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      } else if ($Objet->typeid == 1 && $Objet->etat == 1){ ?>
    <!-- Affichage objet -->
      <div class="wrapper">
        <div class="tile job-bucket">
          <div class="front">
            <div class="contents">
              <img src="images/lamp.png" />
              <h3>Ampoule</h3>
              <p>Ampoule dans  <?php echo $lieu->nom; ?></p>
              <div class="buttons">
                <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      } else if ($Objet->typeid == 2 && $Objet->etat == 0) {  ?>
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front1">
              <div class="contents">
                <img src="images/alarm.png" />
                <h3>Alarme</h3>
                <p>Alarme dans <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      } else if ($Objet->typeid == 2 && $Objet->etat == 1) {  ?>
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front">
              <div class="contents">
                <img src="images/alarm.png" />
                <h3>Alarme</h3>
                <p>Alarme dans <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php
      } else if ($Objet->typeid == 3 && $Objet->etat == 0) { ?>
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front1">
              <div class="contents">
                <img src="images/thermometer.png" />
                <h3>Chauffage</h3>
                <p>Chauffage dans <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
        } else if ($Objet->typeid == 3 && $Objet->etat == 1) { ?>
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front">
              <div class="contents">
                <img src="images/thermometer.png" />
                <h3>Chauffage</h3>
                <p>Chauffage dans <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      } else if ($Objet->typeid == 4  && $Objet->etat == 0){ ?>
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front1">
              <div class="contents">
                <img src="images/volets.png" />
                <h3>Volet</h3>
                <p>Volet dans <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      } else if ($Objet->typeid == 4  && $Objet->etat == 1){ ?>
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front">
              <div class="contents">
                <img src="images/volets.png" />
                <h3>Volet</h3>
                <p>Volet dans <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      } else if ($Objet->typeid == 4  && $Objet->etat == 2){ ?>
        <div class="wrapper">
          <div class="tile job-bucket">
            <div class="front2">
              <div class="contents">
                <img src="images/volets.png" />
                <h3>Volet</h3>
                <p>Volet dans <?php echo $lieu->nom; ?></p>
                <div class="buttons">
                  <a class="button1" href="?p=controle#<?php echo $Objet->id;?>">Paramètres </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      }
    }
  }
} else {
  ?>
  <div style="text-align:center;margin-top:250px;font-size:100px;">
    <p style="color:red;">Accès refusé</p>
  </div>
  <?php
}







