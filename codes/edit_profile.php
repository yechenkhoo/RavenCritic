<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RavenCritic</title>

  <?php include "inc/commonHead.php";?>

  <!-- JS -->
  <script defer src="js/main.js"></script>

  <!-- Poppins Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/poppins.css">

  <!--CSS-->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/edit_profile.css">

  <!-- Slick JS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>

  <?php

    include_once "./inc/databaseFunctions.php";
    $conn = ConnectToDatabase_pdo();
    include_once "./inc/sessionFunctions.php";

    if ($_SESSION['logged_in'] == false) {
      header("Location: login.php");
    }

    $name = $_SESSION['name'];
    //echo name to test
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
    include "php/navbar.php";

    if (isset($_GET['error'])){
        if ($_GET['error'] == 1){
            echo "<div class='alert alert-danger' role='alert'>
            <strong>Error!</strong> Please ensure all mandatory field are populated with valid data.
            </div>";
        }
    }
  ?> 
  <main class="container_edit">
    <div class="container rounded  mt-5">
        <form action="process_edit_profile.php" method="post">
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <?php echo "<span class='font-weight-bold'>" . $name . "</span>"; ?>
                        <?php echo "<span class='font-weight-bold'>" . $email . "</span>"; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-right">Edit Profile</h6>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" value="" maxlength="45">
                            </div>
                            <div class="col-md-6">
                                <input required type="text" id="lname" name="lname" class="form-control" value="" placeholder="Last Name" maxlength="45">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <input type="password" id="pwd" name="pwd" class="form-control" value="" placeholder="Enter new password , if not leave it empty">
                            </div>
                            <div class="col-md-6">
                                <input type="password" id="pwd_cfm" name="pwd_cfm" class="form-control" placeholder="Confirm Password" value="">
                            </div>
                        </div>
                        <div class="mt-5 text-right">
                            <button class="btn btn-primary btn-success" type="submit">Save Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.1/jquery-migrate.min.js" integrity="sha512-KgffulL3mxrOsDicgQWA11O6q6oKeWcV00VxgfJw4TcM8XRQT8Df9EsrYxDf7tpVpfl3qcYD96BpyPvA4d1FDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
 
  <?php
    include "php/footer.php";
  ?>

</body>






</html>