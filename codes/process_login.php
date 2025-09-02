<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Review</title>

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
    include_once "inc/databaseFunctions.php";

    $email = $errorMsg = "";
    $success = true;

    if (isset($_POST['email']) && isset($_POST['pwd'])) {
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
        if ($success){
            authenticateUser();
        }else{
            header("Location: login.php?error=2");
        }
    
        if ($success) {
            header("Location: index.php");
        }else{
            header("location: login.php?error=1");
        }
    } else {
        header("Location: login.php?error=2");
    }
    
    ?>

<?php
/*
* Helper function to authenticate the login.
*/
function authenticateUser()
{
    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success, $admin;

    $conn = ConnectToDatabase_pdo();
    if (!$conn){
        echo "Connection failed: ". $conn->connect_error;
    }else{
        try{
            $stmt = $conn->prepare("SELECT * FROM Users WHERE Email=?");
            $stmt->execute([$email]);
            $result = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                // Note that email field is unique, so should only have
                // one row in the result set.
                
                $fname = $result[1];;
                $lname = $result[2];
                $pwd_hashed = $result[3];
                if ($result[4] == 1){
                    $admin = true;
                }else{
                    $admin = false;
                }

                // Check if the password matches:
                if (!password_verify($_POST["pwd"], $pwd_hashed)) {
                    $errorMsg.= "Email not found or password doesn't match...";
                    $success = false;
                }
            } else {
                $errorMsg = "Email not found or password doesn't match...";
                $success = false;
                header("location: login.php?error=1");
            }
        
                $stmt = null;
        }catch (Exception $e) {
            echo $e->getMessage();
            header("location: login.php?error=1");
        }
        }
        
        // Set Session if valid user
        include_once "inc/sessionFunctions.php";

        // Set Session if valid user
        LoginSession($fname, $lname, $email, $admin);
        $conn = null;
}


/*
* Helper function to sanitize user input.
*/
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>