<?php

    $bdUser = "root";
    $bdPasswd = "";
    $dbname="domotique2021";
    $host = "localhost";

    try{
        $Bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$bdUser,$bdPasswd);
        $Bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    catch (PDOExsception $e)
    {
        echo "IMPOSSIBLE DE SE CONNECTER";
    }