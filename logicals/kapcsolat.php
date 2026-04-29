<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nev = $_POST['nev'] ?? '';
    $email = $_POST['email'] ?? '';
    $szoveg = $_POST['szoveg'] ?? '';
    
    $hibak = [];

    if (strlen($nev) < 3) $hibak[] = "A név túl rövid!";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $hibak[] = "Hibás e-mail formátum!";
    if (strlen($szoveg) < 10) $hibak[] = "Az üzenet túl rövid!";

    if (empty($hibak)) {
        try {
            $dbh = new PDO('mysql:host=mysql.omega;dbname=fel12', 'fel12', 'Asd123asd',
                          array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $dbh->query('SET NAMES utf8');

            $sql = "INSERT INTO uzenetek (nev, email, szoveg, datum) VALUES (?, ?, ?, NOW())";
            $sth = $dbh->prepare($sql);
            $sth->execute([$nev, $email, $szoveg]);

             
             header("Location: ../index.php?oldal=kapcsolat&siker=1");
             exit;

            
            echo "<html><body style='font-family:sans-serif; text-align:center; padding:50px;'>";
            echo "<h1 style='color:green;'>Sikeres mentés!</h1>";
            echo "<p>Köszönjük, az üzeneted bekerült az adatbázisba.</p>";
            echo "<a href='../Kapcsolat' style='background:#FF6600; color:white; padding:10px; text-decoration:none;'>Vissza a főoldalra</a>";
            echo "</body></html>";
            exit;

        } catch (PDOException $e) {
            die("Adatbázis hiba: " . $e->getMessage());
        }
    } else {
        die("Hiba: " . implode(", ", $hibak));
    }
}
?>