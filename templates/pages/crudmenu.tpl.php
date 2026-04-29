<?php
// 1. Adatbázis csatlakozás (HOST, USER, PASS, DB)
$db_conn = new mysqli("mysql.omega", "fel12", "Asd123asd", "fel12");
$db_conn->set_charset("utf8mb4");

if ($db_conn->connect_error) {
    die("Hiba az adatbázis csatlakozásakor.");
}

// 2. MŰVELETEK (Törlés és Mentés)

// TÖRLÉS
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $db_conn->query("DELETE FROM crud_telepulesek WHERE id = $id");
    echo "<script>location.href='./crudmenu';</script>";
    exit;
}

// MENTÉS (Új vagy Módosítás)
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $n = $_POST['nev'];
    $m = $_POST['megye'];
    
    if (!empty($id)) {
        // Módosítás
        $stmt = $db_conn->prepare("UPDATE crud_telepulesek SET nev=?, megye=? WHERE id=?");
        $stmt->bind_param("ssi", $n, $m, $id);
    } else {
        // Új felvétel
        $stmt = $db_conn->prepare("INSERT INTO crud_telepulesek (nev, megye) VALUES (?, ?)");
        $stmt->bind_param("ss", $n, $m);
    }
    $stmt->execute();
    echo "<script>location.href='./crudmenu';</script>";
    exit;
}

// 3. SZERKESZTÉSI ADATOK LEKÉRÉSE
$e_id = ""; $e_n = ""; $e_m = "";
if (isset($_GET['edit'])) {
    $res = $db_conn->query("SELECT * FROM crud_telepulesek WHERE id = " . intval($_GET['edit']));
    if ($row = $res->fetch_assoc()) {
        $e_id = $row['id']; 
        $e_n = $row['nev']; 
        $e_m = $row['megye'];
    }
}
?>

<div style="background:#262626; color:white; padding:20px; border-radius:8px; font-family: Arial, sans-serif;">
    <h2>Települések Kezelése</h2>
    
    <form method="POST" action="" style="margin-bottom:20px; background:#333; padding:15px; border-radius:5px;">
        <input type="hidden" name="id" value="<?= $e_id ?>">
        Név: <input type="text" name="nev" value="<?= $e_n ?>" required style="padding:5px; margin-right:10px;">
        Megye: <input type="text" name="megye" value="<?= $e_m ?>" required style="padding:5px; margin-right:10px;">
        <button type="submit" name="save" style="padding:5px 15px; cursor:pointer; font-weight:bold;">Mentés</button>
        <?php if($e_id): ?>
            <a href="./crudmenu" style="color:#ccc; font-size:12px; margin-left:10px;">Mégse</a>
        <?php endif; ?>
    </form>

    <table border="1" style="width:100%; border-collapse:collapse; text-align:center; background:#333;">
        <tr style="background:#444; color:#ccc;">
            <th style="padding:10px;">ID</th>
            <th>Település</th>
            <th>Megye</th>
            <th>Műveletek</th>
        </tr>
        <?php
        $adatok = $db_conn->query("SELECT * FROM crud_telepulesek ORDER BY id DESC");
        while($r = $adatok->fetch_assoc()): ?>
        <tr style="border-bottom: 1px solid #444;">
            <td style="padding:8px;"><?= $r['id'] ?></td>
            <td><?= $r['nev'] ?></td>
            <td><?= $r['megye'] ?></td>
            <td>
                <a href="./crudmenu?edit=<?= $r['id'] ?>" style="color:cyan; text-decoration:none;">Szerkesztés</a> | 
                <a href="./crudmenu?delete=<?= $r['id'] ?>" style="color:#ff4d4d; text-decoration:none;" onclick="return confirm('Biztosan törlöd?')">Törlés</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>