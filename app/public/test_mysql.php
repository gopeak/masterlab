<?php


#print_r($_SERVER);

$mysqli = new mysqli("localhost", "root", 'Masterlab123@#', "masterlab_ci");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$sqlMode = "SET SQL_MODE='IGNORE_SPACE,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
$ret = $mysqli->query($sqlMode);
var_dump($ret);

$query = "Select @@sql_mode";
$result = $mysqli->query($query);
$row = $result->fetch_array(MYSQLI_NUM);
print_r($row);

echo $mysqli->get_server_info();

/* close connection */
$mysqli->close();

?>