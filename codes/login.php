<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <?php include "inc/commonHead.php";?>

  <!-- JS -->
 <script defer src="js/pills_nav_login.js"></script>
</head>
<body>
    <?php 
        include_once "inc/databaseFunctions.php";
        $conn = ConnectToDatabase_pdo();
        include_once "inc/sessionFunctions.php";

        include "php/navbar.php"; 
    ?>

    <main class="container p-5 mb-5"> 

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item poppins-extralight">
            <a class="text-decoration-none" href="../#">Home</a>
        </li>
        <li class="breadcrumb-item active poppins-light" aria-current="page">Login</li>
      </ol>
    </nav>

    <h1 class="poppins-semibold py-2">Member Area</h1>
    
    <?php
        if ($_GET['error'] == 1){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "Email or Password is incorrect. Please try again.";
            echo "</div>";
        }else if ($_GET['error'] == 2){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "Ensure you have entered a valid email address and password.";
            echo "</div>";
        }
    ?>

    <!-- Pills Nav -->
    <ul class="nav nav-tabs" id="loginRegisterNav" role="tablist">
        <li class ="nav-item pills" role="presentation">
            <button class="nav-link poppins-regular active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="true">Login</button>
        </li>
        <li class="nav-item pills" role="presentation">
            <button class="nav-link poppins-regular" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-register" aria-selected="false">Register</button>
        </li>
    </ul>


        
    <div class="tab-content" id="loginRegister">
        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
            <!-- Login form -->
            <form action="process_login.php" method="post" onsubmit="return validateLogin()">
                <div class="my-3 poppins-regular">
                    <label for="email" class="form-label">Email:</label>
                    <input required type="email" id="login_email" name="email" class="form-control" placeholder="Enter email" maxlength="45">
                </div>
                <div class="my-3 poppins-regular">
                    <label for="pwd" class="form-label">Password:</label>
                    <input required type="password" id="login_pwd" name="pwd" class="form-control" placeholder="Enter password">
                </div>
                <div class="my-4 poppins-regular">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        
        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
            <!-- Registration form -->
            <form action="process_register.php" method="post" onsubmit="return validateRegister()">
                <div class="my-3 poppins-regular">
                    <label for="fname" class="form-label">First Name:</label>
                    <input type="text" id="fname" name="fname" class="form-control" placeholder="Enter first name">
                </div>
                <div class="my-3 poppins-regular">
                    <label for="lname" class="form-label">Last Name:</label>
                    <input required type="text" id="lname" name="lname" class="form-control" placeholder="Enter last name" maxlength="45">
                </div>
                <div class="my-3 poppins-regular">
                    <label for="email" class="form-label">Email:</label>
                    <input required type="email" id="email" name="email" class="form-control" placeholder="Enter email" maxlength="45">
                </div>
                <div class="my-3 poppins-regular">
                    <label for="pwd" class="form-label">Password:</label>
                    <input required type="password" id="pwd" name="pwd" class="form-control" placeholder="Enter password">
                </div>
                <div class="my-3 poppins-regular">
                    <label for="pwd_confirm" class="form-label">Confirm Password:</label>
                    <input required type="password" id="pwd_confirm" name="pwd_confirm" class="form-control" placeholder="Confirm password">
                </div>
                <div class="my-3 form-check poppins-regular">
                    <input required type="checkbox" name="agree" id="agree" class="form-check-input">
                    <label class="form-check-label" for="agree">
                        Agree to terms and conditions.
                    </label>
                </div>
                <div class="my-3 poppins-regular">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </main>
    <?php
        include "php/footer.php";
    ?>
    <script>
        function validateLogin(){
            var email = document.getElementById("login_email").value;
            var pwd = document.getElementById("login_pwd").value;
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            
            if (email == "" || pwd == ""){
                alert("Please fill in all fields.");
                return false;
            }else{
                if (!emailRegex.test(email)){
                    alert("Please enter a valid email address.");
                    return false;
                }
                return true;
            }
        }


        function validateRegister(){
            var fname = document.getElementById("lname").value;
            var email = document.getElementById("email").value;
            var pwd = document.getElementById("pwd").value;
            var pwd_cfm = document.getElementById("pwd_confirm").value;
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (fname == "" || email == "" || pwd == "" || pwd_cfm == ""){
                alert("Please fill in all fields.");
                return false;
            }else{
                if (!emailRegex.test(email)){
                    alert("Please enter a valid email address.");
                    return false;
                }else{
                    if (pwd != pwd_cfm){
                        alert("Passwords do not match.");
                        return false;
                    }
                }
                return true;
            }
        }
    </script>
</body>
</html>
