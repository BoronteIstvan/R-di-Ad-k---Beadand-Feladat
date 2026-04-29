<?php
if (isset($_SESSION['login'])) {
    try {
        $dbh = new PDO('mysql:host=mysql.omega;dbname=fel12', 'fel12', 'Asd123asd',
                      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8');

        $sql = "SELECT nev, email, szoveg, datum FROM uzenetek ORDER BY datum DESC";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $uzenetek = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $hiba = "Adatbázis hiba: " . $e->getMessage();
    }
}
?>