<?php
include "inc/databaseFunctions.php";
$conn = ConnectToDatabase_pdo();
include "inc/sessionFunctions.php";
StopSession($conn);


header("Location: index.php");
exit();
?>