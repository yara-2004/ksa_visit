<?php
include 'db.php';

$sql = "SELECT * FROM Regions";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Regions</title>
</head>
<body>
    <h2>Regions</h2>
    <ul>
        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
            <li>
                <h3><?php echo $row['Name']; ?></h3>
                <p><?php echo $row['Description']; ?></p>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
