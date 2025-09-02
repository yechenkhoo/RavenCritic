<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <link rel='icon' type='image/x-icon' href='/images/favicon.png'>

  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
  crossorigin="anonymous">
  
  <!--CSS-->
  <link rel="stylesheet" href="css/main.css">


  <!--Bootstrap JS-->
  <script defer
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous">
  </script>

  <!-- JS -->
  <script defer src="js/main.js"></script>

  <!-- Glider CSS -->
  <link rel="stylesheet" type="text/css" href="css/glider.css">


  <!-- Poppins Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/poppins.css">

</head>
<body>
    

<main class="container"> 

<?php
include "inc/databaseFunctions.php";

$email = $errorMsg = "";
$success = true;


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

if (!empty($_POST["fname"])) {
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

if (empty($_POST["pwd_confirm"])) {
    $errorMsg .= "Password confirmation is required.<br>";
    $success = false;
} else {
    if ($_POST["pwd"] != $_POST["pwd_confirm"]) {
        $errorMsg .= "Passwords do not match.<br>";
        $success = false;
    }
}
if ($success){
    MemberRegistration(); // Save member to database
}

echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center; flex-direction: column;'>";
if ($success) {
    // Display successful registration message
    echo "<a href='index.php' title='Home'> <img src='images/logo.png' width='114' height='67' alt='Logo'></a>";
    echo "<h4>Registration successful!</h4>";
    echo "<p>Email: " . $email . "</p>";
    if (empty($_POST["fname"])) {
        echo "<h4>Thank you for signing up, " . $_POST["lname"] . "!</h4>";
    } else {
        echo "<h4>Thank you for signing up, " . $_POST["fname"] . " " . $_POST["lname"] . "!</h4>";
    }
    echo "<h4>Please head over to the <a href='login.php'>Login Page</a> to login.</h4>";
    echo "<button type='button' class='btn btn-success' style='margin-top: 20px;'><a href='login.php' style='color: white; text-decoration: none;'>Login Page</a></button>";
} else {
    echo "<a href='index.php' title='Home'> <img src='images/logo.png' width='114' height='67' alt='Logo'></a>";
    echo "<h4>The following input errors were detected:</h4>";
    echo "<p>" . $errorMsg . "</p>";
    echo "<button type='button' class='btn btn-danger' style='margin-top: 20px;'><a href='login.php#register' style='color: white; text-decoration: none;'>Return to Sign up</a></button>";
}
echo "</div>";


function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function MemberRegistration()
{
    global $fname, $lname, $email, $pwdhashed, $errorMsg, $success;

    $conn = ConnectToDatabase_pdo();
    if (!$conn){
        echo "Connection failed: ". $conn->connect_error;
    }else{
        
        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO Users(FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?)");
        // Bind and Execute the query statement:
        try{
            $stmt->execute([$fname, $lname, $email, $pwdhashed]);
        } catch (Exception $e) {
            // $errorMsg = "Execute failed: (" . $e->getMessage() . ") " .
            //     $stmt->error;
            $errorMsg = "Registration failed, please check if email has been registered before.";
            $success = false;
        } finally {
            $stmt = null;
        }
        $conn = null;
        
    }
}
?>
</main>
  
</body>
</html>