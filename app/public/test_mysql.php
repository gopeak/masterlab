<?php



#print_r($_SERVER);

$mysqli = new mysqli("localhost", "root", "Masterlab123", "masterlab_ci");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* Insert rows */
$mysqli->query("CREATE TABLE Language SELECT * from CountryLanguage");
printf("Affected rows (INSERT): %d\n", $mysqli->affected_rows);

$mysqli->query("ALTER TABLE Language ADD Status int default 0");

/* update rows */
$mysqli->query("UPDATE Language SET Status=1 WHERE Percentage > 50");
printf("Affected rows (UPDATE): %d\n", $mysqli->affected_rows);

/* delete rows */
$mysqli->query("DELETE FROM Language WHERE Percentage < 50");
printf("Affected rows (DELETE): %d\n", $mysqli->affected_rows);

/* select all rows */
$result = $mysqli->query("SELECT CountryCode FROM Language");
printf("Affected rows (SELECT): %d\n", $mysqli->affected_rows);

/* Delete table Language */
$mysqli->query("DROP TABLE Language");

$result = $mysqli->query("Select @@sql_mode");

$row = $mysqli->fetch_array($result,MYSQLI_ASSOC);
print_r($row);

/* close connection */
$mysqli->close();
?>
