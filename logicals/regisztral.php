<?php
// Hibakeresés bekapcsolása - ha kész vagy, ezeket törölheted
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['utonev'])) {
    try {
        // Csatlakozás az Omega szerverhez
        $dbh = new PDO('mysql:host=mysql.omega;dbname=fel12', 'fel12', 'Asd123asd',
                array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        
        $sqlSelect = "select id from felhasznalok where bejelentkezes = :bejelentkezes";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo']));
        
        if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $uzenet = "A felhasználói név már foglalt!";
            $ujra = true;
        }
        else {
           
            $sqlInsert = "insert into felhasznalok(csaladi_nev, uto_nev, bejelentkezes, jelszo)
                          values(:csaladinev, :utonev, :bejelentkezes, :jelszo)";
            $stmt = $dbh->prepare($sqlInsert); 
            $stmt->execute(array(
                ':csaladinev' => $_POST['vezeteknev'], 
                ':utonev' => $_POST['utonev'],
                ':bejelentkezes' => $_POST['felhasznalo'], 
                ':jelszo' => sha1($_POST['jelszo'])
            )); 

            if($stmt->rowCount()) {
                $newid = $dbh->lastInsertId();
                $uzenet = "A regisztrációja sikeres.<br>Azonosítója: {$newid}";                     
                $ujra = false;
            }
            else {
                $uzenet = "A regisztráció nem sikerült.";
                $ujra = true;
            }
        }
    }
    catch (PDOException $e) {
        $uzenet = "Hiba: " . $e->getMessage();
        $ujra = true;
    }      
}
else {
    header("Location: .");
    exit();
}
?>