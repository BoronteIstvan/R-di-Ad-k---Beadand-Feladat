<?php
if (isset($_SESSION['login'])) {
    try {
        $dbh = new PDO('mysql:host=mysql.omega;dbname=fel12', 'fel12', 'Asd123asd',
                      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8');

       
        if (isset($_GET['delete'])) {
            $sth = $dbh->prepare("DELETE FROM crud_telepulesek WHERE id = ?");
            $sth->execute([$_GET['delete']]);
            header("Location: index.php?oldal=crudmenu");
            exit();
        }

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
            $id = $_POST['id']; 
            $nev = $_POST['nev']; 
            $megye = $_POST['megye'];
            if (empty($id)) {
                $sth = $dbh->prepare("INSERT INTO crud_telepulesek (nev, megye) VALUES (?, ?)");
                $sth->execute([$nev, $megye]);
            } else {
                $sth = $dbh->prepare("UPDATE crud_telepulesek SET nev=?, megye=? WHERE id=?");
                $sth->execute([$nev, $megye, $id]);
            }
            header("Location: index.php?oldal=crudmenu");
            exit();
        }

        $edit_row = ['id' => '', 'nev' => '', 'megye' => ''];
        if (isset($_GET['edit'])) {
            $sth = $dbh->prepare("SELECT * FROM crud_telepulesek WHERE id = ?");
            $sth->execute([$_GET['edit']]);
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            if ($res) $edit_row = $res;
        }

        
        $sth = $dbh->query("SELECT * FROM crud_telepulesek ORDER BY id DESC");
        $lista = $sth->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $hiba = "Hiba: " . $e->getMessage();
    }
}
?>