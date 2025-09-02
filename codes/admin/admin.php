<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

    <link rel='icon' type='image/x-icon' href='../images/favicon.png'>

    <!--Bootstrap-->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css'
    rel='stylesheet'
    integrity='sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9'
    crossorigin='anonymous'>

    <!--Bootstrap JS-->
    <script defer
    src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm'
        crossorigin='anonymous'>
    </script>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/poppins.css">

    <!--Main CSS-->
    <link rel="stylesheet" href="/css/main.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

    <script defer src="../js/pills_nav_admin.js"></script>
</head>
<?php
global $results;
include_once "../inc/databaseFunctions.php";
$conn = ConnectToDatabase_pdo();
include_once "../inc/sessionFunctions.php";

// Prevent unauthenticated/unauthorized user from accessing this page 
if ($_SESSION['admin'] != true || $_SESSION['logged_in'] != true) {
    header("Location: ../login.php");
    exit();
}

//if post array 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idConsole'])) {
    $idConsole = $_POST['idConsole'];
    // Assuming deleteConsole function exists and is correctly implemented
    $results =  removeConsole($idConsole);
    //echo $results;
    if ($results == "success") {
        //echo as script on web browser popup
        echo "<script>alert('Console $idConsole removed successfully !');</script>";

    } else {
        echo "<script>alert('There are games attached to this console');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idGenre'])) {
    $idGenre = $_POST['idGenre'];

    // Assuming deleteConsole function exists and is correctly implemented
    $results =  removeGenre($idGenre);
    if ($results == "success") {
        //echo as script on web browser popup
        echo "<script>alert('Genre $idGenre removed successfully !');</script>";

    } else {
        echo "<script>alert('There are games attached to this genre');</script>";
    }
}


if (isset($_POST['GameID'])) {

    // Get game ID
    $gameID = $_POST['GameID'];

    $results = removeGames($gameID);
    echo "<script>alert('Game with game id : $gameID deleted successfully');</script>";
}

?>

<body>
    <?php
    // Include Nav bar
    include "../php/navbar.php"; 
    ?>

<main class="container my-3">
    <h1 class="poppins-semibold" >Admin Page</h1>
    <!-- Bootstrap pills navigation to switch between admin menu -->
    <ul class="nav nav-tabs my-3" id="adminMenu" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-dark poppins-regular" id="manageManagers-tab" data-bs-toggle="pill" data-bs-target="#managerUser" type="button" role="tab" aria-controls="managerUser" aria-selected="true">Manage Users</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark poppins-regular" id="manageGames-tab" data-bs-toggle="pill" data-bs-target="#manageGames" type="button" role="tab" aria-controls="manageGames" aria-selected="false">Manage Games</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark poppins-regular" id="manageGenre-tab" data-bs-toggle="pill" data-bs-target="#manageGenre" type="button" role="tab" aria-controls="manageGenre" aria-selected="false">Manage Genre</button>
        </li> 
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark poppins-regular" id="manageConsole-tab" data-bs-toggle="pill" data-bs-target="#manageConsole" type="button" role="tab" aria-controls="manageConsole" aria-selected="false">Manage Console</button>
        </li> 
    </ul>

    <!-- Bootstrap pills content to switch between admin menu -->
    <div class="tab-content my-3" id="adminMenuContent">
        <div class="tab-pane fade show active my-2" id="managerUser" role="tabpanel" aria-labelledby="manageManagers-tab">
            <h2 class="poppins-semibold">Manager Users</h2>
            <p class="poppins-regular">Here you can manage the users of the webiste, deleting them or promoting them to managers</p>
            <p class="poppins-regular">Further at the add manager tab, you can create a manager without him being a user</p>
            <ul class="nav nav-tabs" id="manageManagerNav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark poppins-regular" id="existingUsers-tab" data-bs-toggle="pill" data-bs-target="#existingUsers" type="button" role="tab" aria-controls="editGames" aria-selected="true">Existing Users</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark poppins-regular" id="addManager-tab" data-bs-toggle="pill" data-bs-target="#addManager" type="button" role="tab" aria-controls="addGame" aria-selected="false">Add Manager</button>
                </li>
            </ul>

            <div class="tab-content" id="manageUserContent">
                <div class="tab-pane fade show active my-2" id="existingUsers" role="tabpanel" aria-labelledby="existingUsers-tab">
                    <h3 class="my-4 poppins-semibold">View Existing Users</h3>
                    <p class="poppins-regular">Manage by deleting the user or promoting them to manager</p>
                    <?php include "manageUsers.php";?>
                </div>

                <div class="tab-pane fade my-2" id="addManager" role="tabpanel" aria-labelledby="addManager-tab">
                    <h3 class="my-4 poppins-semibold">Add Manager</h3>
                    <p class="poppins-regular">You can add manager to the website, it will auto create the user. </p>
                    <?php include "addManager.php";?>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="manageGames" role="tabpanel" aria-labelledby="manageGames-tab">
            <h2 class="poppins-semibold">Manage Games</h2>
            <p class="poppins-regular">Here you can manage the games of the website.</p>
            <ul class="nav nav-tabs" id="manageGamesNav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark poppins-regular" id="editGames-tab" data-bs-toggle="pill" data-bs-target="#editGames" type="button" role="tab" aria-controls="editGames" aria-selected="true">Existing Games</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark poppins-regular" id="addGame-tab" data-bs-toggle="pill" data-bs-target="#addGame" type="button" role="tab" aria-controls="addGame" aria-selected="false">Add Game</button>
                </li>
            </ul>

            <div class="tab-content" id="manageGamesContent">
                <div class="tab-pane fade show active" id="editGames" role="tabpanel" aria-labelledby="editGames-tab">
                    <h3 class="my-4 poppins-semibold">Edit Games</h3>
                    <p class="poppins-regular">Here you can edit the games of the website.</p>
                    <?php include "manageGames.php"; ?>
                </div>

                <div class="tab-pane fade" id="addGame" role="tabpanel" aria-labelledby="addGame-tab">
                    <h3 class="my-4 poppins-semibold">Add Game</h3>
                    <p class="poppins-regular">Here you can add a new game to the website.</p>
                    <?php include "addGame.php"; ?>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="manageGenre" role="tabpanel" aria-labelledby="manageGenre-tab">
            <h2 class="poppins-semibold">Manage Genre</h2>
            <p class="poppins-regular">Here you can manage genre of the website</p>
            <ul class="nav nav-tabs" id="manageGenreNav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active poppins-regular text-dark" id="viewGenre-tab" data-bs-toggle="pill" data-bs-target="#editGenre" type="button" role="tab" aria-controls="editGenre" aria-selected="true">Existing Genres</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark poppins-regular " id="addGenre-tab" data-bs-toggle="pill" data-bs-target="#addGenre" type="button" role="tab" aria-controls="addGenre" aria-selected="false">Add Genre</button>
                </li>
            </ul>

            <div class="tab-content" id="manageGenreContent">
                <div class="tab-pane fade show active" id="editGenre" role="tabpanel" aria-labelledby="editGames-tab">
                    <h3 class="my-4 text-custommmm poppins-semibold">View Genre</h3>
                    <p class="poppins-regular">Here you manage all the genre for the website.</p>
                    <?php include "manageGenre.php"; ?>
                </div>

                <div class="tab-pane fade" id="addGenre" role="tabpanel" aria-labelledby="addGenre-tab">
                    <h3 class="my-4 text-custommmm poppins-semibold">Add Genre</h3>
                    <p class="poppins-regular">Here you can add a new genre to the website.</p>
                    <?php include "addGenre.php"; ?>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="manageConsole" role="tabpanel" aria-labelledby="manageConsole-tab">
            <h2 class="poppins-semibold">Manage Console</h2>
            <p class="poppins-regular">Here you can manage console existing in the website</p>
            <ul class="nav nav-tabs" id="manageConsoleNav" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark poppins-regular" id="viewConsole-tab" data-bs-toggle="pill" data-bs-target="#editConsole" type="button" role="tab" aria-controls="editConsole" aria-selected="true">Existing Consoles</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark poppins-regular" id="addConsole-tab" data-bs-toggle="pill" data-bs-target="#addConsole" type="button" role="tab" aria-controls="addConsole" aria-selected="false">Add Console</button>
                </li>
            </ul>

            <div class="tab-content" id="manageConsoleContent">
                <div class="tab-pane fade show active" id="editConsole" role="tabpanel" aria-labelledby="addConsole-tab">
                    <h3 class="my-4 text-custommmm poppins-semibold">View Console</h3>
                    <p class="poppins-regular">Here you manage all the console existing for the website.</p>
                    <?php include "manageConsole.php"; ?>
                </div>

                <div class="tab-pane fade" id="addConsole" role="tabpanel" aria-labelledby="addConsole-tab">
                    <h3 class="my-4 text-custommmm poppins-semibold">Add Genre</h3>
                    <p class="poppins-regular">Here you can add a new console to the website.</p>
                    <?php include "addConsole.php"; ?>
                </div>

            </div>
        </div>

    </div>

</main>

<?php include "../php/footer.php"; ?>

</body>

</html>