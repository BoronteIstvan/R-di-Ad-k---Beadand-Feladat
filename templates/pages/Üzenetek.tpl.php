<?php

if (!isset($_SESSION['login'])) {
    echo "<h2>Hiba</h2><p>Ezt az oldalt csak bejelentkezett felhasználók tekinthetik meg!</p>";
} else {
    try {
        
        $dbh = new PDO('mysql:host=mysql.omega;dbname=fel12', 'fel12', 'Asd123asd',
                      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8');

        
        $sql = "SELECT nev, email, szoveg, datum FROM uzenetek ORDER BY datum DESC";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $uzenetek = $sth->fetchAll(PDO::FETCH_ASSOC);
?>

    <h2 style="color: white;">Beérkezett üzenetek</h2>
    <table style="width:100%; border-collapse: collapse; background-color: #222; color: white; border: 1px solid #444;">
        <thead>
            <tr style="background-color: #444; text-align: left;">
                <th style="padding: 12px; border: 1px solid #555;">Küldés ideje</th>
                <th style="padding: 12px; border: 1px solid #555;">Név</th>
                <th style="padding: 12px; border: 1px solid #555;">E-mail</th>
                <th style="padding: 12px; border: 1px solid #555;">Üzenet</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($uzenetek as $u): ?>
                <tr style="border-bottom: 1px solid #333;">
                    <td style="padding: 10px; border: 1px solid #333;"><?php echo $u['datum']; ?></td>
                    <td style="padding: 10px; border: 1px solid #333; font-weight: bold;">
                        <?php echo ($u['nev'] ? htmlspecialchars($u['nev']) : "Vendég"); ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #333; color: #aaa;"><?php echo htmlspecialchars($u['email']); ?></td>
                    <td style="padding: 10px; border: 1px solid #333;"><?php echo nl2br(htmlspecialchars($u['szoveg'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
    } catch (PDOException $e) {
        echo "Adatbázis hiba: " . $e->getMessage();
    }
}
?>