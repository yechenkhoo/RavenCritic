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
        require_once "inc/databaseFunctions.php";
        $conn = ConnectToDatabase_pdo();
    
        require_once "inc/sessionFunctions.php";
        global $session;
        global $fname, $lname, $email, $pwdhashed, $errorMsg_edit, $success ,$chg_pwd ,$admin;
        $chg_pwd = false;
        $admin = $_SESSION['admin'];
        $success = true;
        $errorMsg = "";
        $email = $_SESSION['email'];

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

        } else {
            $chg_pwd = true;
            $pwdhashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        }
        
        if (empty($_POST["pwd_cfm"])) {
            if ($chg_pwd) {
                $errorMsg .= "Password confirm is required.<br>";
                $success = false;
            }
        } else {
            if ($_POST["pwd"] != $_POST["pwd_cfm"]) {
                $errorMsg .= "Passwords do not match.<br>";
                $success = false;
            }
        }

        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center; flex-direction: column;'>";
        //if sucess validation,update to db
        if ($success){
            updateToDB();
        }else{
            //echo error msg 
            echo "<a href='index.php' title='Home'> <img src='images/logo.png' width='114' height='67' alt='Logo'></a>";
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
        }

        if($success_db){
            echo "<a href='index.php' title='Home'> <img src='images/logo.png' width='114' height='67' alt='Logo'></a>";
            if ($fname == "") {
                echo "<h4>You have update your name to " . $lname . "!</h4>";
            } else {
                echo "<h4>You have update your name to " . $fname . " " . $lname . "!</h4>";
            }
            if ($chg_pwd) {
                echo "<h4>You have update your password!</h4>";
            }

            echo "<button type='button' class='btn btn-success'><a href='index.php' class='button-link'>Return to Home</a></button>";

        }else{
            echo "<h1>fail to update db</h1>";
            header("Location: edit_profile.php?error=1");
        }
        echo "</div>";


        //function
        function updateToDB(){
            //echo the value of fname from post
            global $success_db;
            $success_db = true;
            global $fname, $lname, $email, $pwdhashed, $errorMsg, $chg_pwd , $admin;

            $conn = ConnectToDatabase_pdo();
            if (!$conn){
                echo "Connection failed: ". $conn->connect_error;
            }else{

                if ($chg_pwd) {
                    // Prepare the statement
                    $stmt = $conn->prepare("UPDATE Users SET FirstName = ?, LastName = ? , Password = ? WHERE Email = ?");
                    // Bind and Execute the query statement:
                    try{
                        $stmt->execute([$fname, $lname,$pwdhashed ,$email]);
                    } catch (Exception $e) {
                        $success_db = false;
                    } finally {
                        $stmt = null;
                    }
                }else{
                    // Prepare the statement
                    $stmt = $conn->prepare("UPDATE Users SET FirstName = ?, LastName = ? WHERE Email = ?");
                    // Bind and Execute the query statement:
                    try{
                        $stmt->execute([$fname, $lname,$email]);
                    } catch (Exception $e) {
                        $success_db = false;
                    } finally {
                        $stmt = null;
                    }
                }
                $conn = null; 
            }
            
            //set the session name 
            LoginSession($fname, $lname,$email,$admin);

        }


        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        ?>

    </main>

</body>