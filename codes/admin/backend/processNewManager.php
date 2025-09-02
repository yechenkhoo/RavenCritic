<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $conn, $fname, $lname, $email, $pwdhashed, $errorMsg, $success,$pwd ;
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
if (empty($_POST["fname"])) {   
}else{
    $fname = sanitize_input($_POST["fname"]);
}

if (empty($_POST["lname"])) {
    $errorMsg .= "Last Name is required.<br>";
    $success = false;
} else {
    $lname = sanitize_input($_POST["lname"]);
}

if (empty($_POST["pwd"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $pwdhashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
}

if (empty($_POST["pwd_cfm"])) {
    $errorMsg .= "Password confirm is required.<br>";
    $success = false;
} else {
    if ($_POST["pwd"] != $_POST["pwd_cfm"]) {
        $errorMsg .= "Passwords do not match.<br>";
        $success = false;
    }
}

if (empty($_POST["email"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    $email = sanitize_input($_POST["email"]);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMsg .= "Invalid email format.<br>";
    $success = false;
}

//echo all the values such as name and email
if ($success){
    //user prepared statement
    // Prepare the statement
    $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Password, Email , Admin ) VALUES (?,?,?,?,?)");
    // Bind and Execute the query statement:
    try{
        $stmt->execute([$fname, $lname,$pwdhashed ,$email,1]);
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
    echo "<h4>Admin Registration successful!</h4>";
    echo "<p>Email: " . $email . "</p>";
    if (empty($_POST["fname"])) {
        echo "<h4>Created admin succesfully,  " . $lname . "!</h4>";
    } else {
        echo "<h4>Created admin succesfully, " . $fname . " " . $lname . "!</h4>";
    }
    StopSession();
    echo "<h4>Please head over to the <a href='../../login.php'>Login Page</a> to login.</h4>";
    
}else{

    echo " <img src='../../images/logo.png' width='114' height='67' alt='Logo'>";
    echo "<h4>Please choose another email address</h4>";
    //echo link to return to addManager page
    echo "<a href='../admin.php#addManager'>Click here to return to addManager page</a>";
}
echo "</div>";












function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>