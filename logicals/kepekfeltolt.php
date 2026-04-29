<?php
session_start();
if (isset($_SESSION['login']) && isset($_FILES['uj_kep'])) {
    $mappa = 'images/galeria/'; 
    if (!is_dir($mappa)) mkdir($mappa, 0777, true);

    $fajl_nev = $_FILES['uj_kep']['name'];
    $forras = $_FILES['uj_kep']['tmp_name'];
    $kiterjesztes = strtolower(pathinfo($fajl_nev, PATHINFO_EXTENSION));
    
    $engedelyezett = array("jpg", "jpeg", "png", "gif");

    if (in_array($kiterjesztes, $engedelyezett)) {
        $cel = $mappa . time() . "_" . $fajl_nev;

        if (move_uploaded_file($forras, $cel)) {
            $uzenet = "Sikeres feltöltés!";
        } else {
            $uzenet = "Hiba: A mentés sikertelen! Ellenőrizd a 777-es jogot!";
        }
    } else {
        $uzenet = "Hiba: Rossz fájlformátum!";
    }
    
  
    header("Location: kepek"); 
    exit();
} else {
    
    header("Location: kepek");
    exit();
}