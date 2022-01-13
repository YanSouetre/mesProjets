<!-- ---- Début du code de la page d'accueil ---- -->
<title>Domotech - Accueil</title>
<link rel="stylesheet" href="css/accueil.css">
<?php 
if (isset($_SESSION["justonline"])) {   // Lorsque l'utilisateur viens de se connecter
    unset($_SESSION["justonline"]);     // Dès que l'utilisateur regenère la page le msg ne va plus s'afficher
    if ($_SESSION["Civilité"] == 'Homme') {
        echo "<p style='color:aquamarine; font-size: 40px;' >Bienvenue Monsieur $_SESSION[nom] ! Vous êtes désormais connecté.<p>";
    }
    else if  ($_SESSION["Civilité"] == 'Femme') {
        echo "<p style='color:aquamarine; font-size: 40px;' >Bienvenue Madame $_SESSION[nom] ! Vous êtes désormais connecté.<p>";
    }
    else {
        echo "<p style='color:aquamarine; font-size: 40px;' >Bienvenue $_SESSION[username] ! Vous êtes désormais connecté.<p>";
    }
}


?>
<!-- ---- Premier article ---- -->

<div class="Tab1">
    <h1 class="Tab1Titre">DOMOTECH</h1>
    <h1 class="Tab1Ti">Qui sommes nous ?</h1>
    <p class="Tab1Text">Nous sommes simple avec des vies simples, et nous voulons simplement simplifier votre vie, <br>nous sommes une bande d'amis et nous cherchons la simplicité à son paroxisme,<br> n'hésitez pas à nous rejoindre ! <br> Et faites partie de l'élite de la simplicité.
    <br></p>
    <p class= "Tab1Ti">Découvrez nos produits !</p>
</div>

<h1 class="Tab1Ti">Nos différents produits</h1>


<section class="carousel">       <!-- Affichage des objets -->   
    <ul class="carousel-items"> 
        <div class="carousel-item">
            <div class="card">
                <h1 class="Tab1Titre">Thermomètre</h1>
                <p class="Tab2Text"><img src="images/thermometer.png" alt="thermometer"></p>
                <p>De quoi refroidir l'ambiance...</p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
                <h1 class="Tab1Titre">Lampe</h1>
                <p class="Tab3Text"><img src="images/lamp.png" alt="lamp"></p>
                <p>Pour illuminer votre journée</p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
                <h1 class="Tab1Titre">Alarme</h1>
                <p class="Tab4Text"><img src="images/alarm.png" alt="alarm"></p>
                <p>Ne vous inquiétez pas on surveille !</p>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
                <h1 class="Tab1Titre">Volets</h1>
                <p class="Tab5Text"><img src="images/volets.png" alt="volets"></p>
                <p>On ne les ouvrira pas en pleine nuit 😉</p>
            </div>
        </div>
    </ul>
</section>
    


