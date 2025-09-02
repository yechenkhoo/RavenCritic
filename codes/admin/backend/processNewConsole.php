<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $conn, $name,$errorMsg, $success;
$success = true;
$errorMsg = "";
include_once "../../inc/databaseFunctions.php";
$conn = ConnectToDatabase_pdo();
include_once "../../inc/sessionFunctions.php";
// Prevent unauthenticated/unauthorized user from accessing this page 
if ($_SESSION['admin'] != true || $_SESSION['logged_in'] != true) {
    header("Location: ../../login.php");
    exit();
}



//set the variable 
//validate 
if (empty($_POST["console_name"])) {   
    $errorMsg .= "Console Name is required.<br>";
    $success = false;
}else{
    $name = sanitize_input($_POST["console_name"]);
}

if ($success){
    //user prepared statement
    // Prepare the statement
    $stmt = $conn->prepare("INSERT INTO Consoles (Console) VALUES (?)");
    // Bind and Execute the query statement:
    try{
        $stmt->execute([$name]);
    } catch (Exception $e) {
        $success = false;
    } finally {
        $stmt = null;
    }
}else{
    //echo error msg
    echo "<h4>The following input errors were detected:</h4>";
    echo "<p>" . $errorMsg . "</p>";
}


echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center; flex-direction: column;'>";
if($success){
    // Display successful registration message
    echo " <img src='../../images/logo.png' width='114' height='67' alt='Logo'>";
    echo "<h4>Console $name has been successfully added to database </h4>";
    echo "<a href='../admin.php'>Click here to return to admin page</a>";
}else{
    // Display successful registration message
    echo " <img src='../../images/logo.png' width='114' height='67' alt='Logo'>";
    echo "<h4>Please choose another console name</h4>";
    echo "<a href='../admin.php'>Click here to return to admin page</a>";
}
echo "</div>";












function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>