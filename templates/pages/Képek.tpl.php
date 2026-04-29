<?php

if (isset($_SESSION['login']) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['uj_kep'])) {
    $mappa = 'images/galeria/'; 
    if (!is_dir($mappa)) mkdir($mappa, 0777, true);

    $fajl_nev = $_FILES['uj_kep']['name'];
    $forras = $_FILES['uj_kep']['tmp_name'];
    $kiterjesztes = strtolower(pathinfo($fajl_nev, PATHINFO_EXTENSION));
    $engedelyezett = array("jpg", "jpeg", "png", "gif");

    if (in_array($kiterjesztes, $engedelyezett)) {
        $cel = $mappa . time() . "_" . $fajl_nev;
        if (move_uploaded_file($forras, $cel)) {
            echo "<h3 style='color:green;'>Sikeres feltöltés!</h3>";
        } else {
            echo "<h3 style='color:red;'>Hiba: Nem sikerült a mentés (jogosultság?)!</h3>";
        }
    } else {
        echo "<h3 style='color:red;'>Hiba: Csak képet tölthetsz fel!</h3>";
    }
}
?>

<h2>Galéria</h2>

<?php if(isset($_SESSION['login'])): ?>
    <div style="background: #555555; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <h3>Új kép feltöltése</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="uj_kep" required>
            <button type="submit">Feltöltés</button>
        </form>
    </div>
<?php endif; ?>

<div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
   <?php
    $mappa = 'images/galeria/'; 
    $fajlok = glob($mappa . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    
    if ($fajlok) {
        foreach ($fajlok as $kep) {
            echo '<div style="border: 2px solid #ddd; padding: 5px; background: #555555; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);">';
           
            echo '<img src="/' . $kep . '" width="250" style="display:block; object-fit: cover;">';
            echo '</div>';
        }
    } else {
        echo "<p>Még nincs feltöltött kép a galériában.</p>";
    }
    ?>
</div>