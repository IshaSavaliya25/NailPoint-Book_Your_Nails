<?php
include("db.php");
$result = $conn->query("SELECT * FROM users");
echo "<h3>Users</h3><table border='1'>";
while($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td></tr>";
}
echo "</table>";
?>
