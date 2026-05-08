<?php

try {
    $dbh = new PDO('mysql:host=mysql.omega;dbname=fel12', 'fel12', 'Asd123asd',
                  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8');
} catch (PDOException $e) {
    echo "Adatbázis hiba!";
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO uzenetek (nev, email, szoveg, datum) VALUES (?, ?, ?, NOW())";
    $sth = $dbh->prepare($sql);
    $sth->execute([$_POST['nev'], $_POST['email'], $_POST['szoveg']]);
    echo "<h3 style='color:green;'>ELMENTVE! </h3>";
}
?>

<h2>Kapcsolat</h2>
<form action="" method="post"> Név: <input type="text" name="nev" required><br>
    Email: <input type="email" name="email" required><br>
    Üzenet: <textarea name="szoveg" required></textarea><br>
    <button type="submit">Küldés</button>
</form>