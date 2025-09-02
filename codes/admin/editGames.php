<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include "../inc/commonHead.php";
    require_once "../inc/databaseFunctions.php";
    $conn = ConnectToDatabase_pdo();
    require_once "../inc/sessionFunctions.php";

    // Prevent unauthenticated/unauthorized user from accessing this page 
    if ($_SESSION['admin'] != true || $_SESSION['logged_in'] != true) {
        header("Location: ../login.php");
        exit();
    }
    ?>
    <title>Edit Game</title>
</head>
<body>

    <?php 
        if (isset($_GET['GameID']) == false || $_GET['GameID'] == null){
            header("Location: admin.php#editGames");
        }

        // Get Game ID and retrieve all the info
        $gameID = $_GET['GameID'];
        // Retrieve Game Info from database
        $gameInfo = getGameDetails($gameID);

        if (empty($gameInfo)){
            header("Location: admin.php#editGames");
        }

        $genrelist = array_column(getGenre(), 'Genre');
        $consoles = array_column(getConsole(), 'Console'); 
        $gameGenres = array_column(getGenresByGame($gameID), 'Genre');
        $gameConsoles = array_column(getConsolesByGame($gameID), "Console");

        
        include "../php/navbar.php";
        echo "<main class='container'>";
        if ($_GET['error'] == 1){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "Please complete all required fields and select at least one genre and one console.";
            echo "</div>";
        }


        echo "<h1>Edit Game Details</h1>";
        // Display retrieved data
        echo "<form method='post' action='backend/processEditGame.php' enctype='multipart/form-data' onsubmit='return validateForm()'>";
        echo "<input type='hidden' name='gameID' value='".$gameID."'>";
        // Display game name
        echo "<div class='form-group'>";
        echo "<label for='name'>Name:</label>";
        echo "<input type='text' class='form-control' id='name' name='name' value='".$gameInfo['Name']."'>";  // Display retrieved name
        echo "</div>";

        // Display game genres
        echo "<div class='form-group'>";
        echo "<label>Genres:</label>";
        foreach ($genrelist as $g){
            echo "<div class='form-check'>";
            if (in_array($g, $gameGenres)) {
                echo "<input class='form-check-input' type='checkbox' name='gameGenres[]' id='".str_replace(' ', '', $g)."' value='$g' checked>";
            }else{
                echo "<input class='form-check-input' type='checkbox' name='gameGenres[]' id='".str_replace(' ', '', $g)."' value='$g'>";
            }
            echo "<label class='form-check-label' for='".str_replace(' ', '', $g)."'>";
            echo "$g</label>";
            echo "</div>";
        }
        echo "</div>";

        // Display game consoles
        echo "<div class='form-group'>";
        echo "<label>Consoles:</label>";
        foreach ($consoles as $c){
            echo "<div class='form-check'>";
            if (in_array($c, $gameConsoles)) {
                echo "<input class='form-check-input' type='checkbox' name='gameConsoles[]' id='".str_replace(' ', '', $c)."' value='$c' checked>";
            }else{
                echo "<input class='form-check-input' type='checkbox' name='gameConsoles[]' id='".str_replace(' ', '', $c)."' value='$c'>";
            }
            echo "<label class='form-check-label' for='".str_replace(' ', '', $c)."'>";
            echo "$c</label>";
            echo "</div>";
        }
        echo "</div>";

        // Display game score
        echo "<div class='form-group'>";
        echo "<label for='score'>Score:</label>";
        echo "<input class='form-control' id='score' type='number' step='0.1' min='0' max='10' name='score' value='".$gameInfo['Score']."'>";
        echo "</div>";

        // Display ImagePath
        echo "<div class='form-group'>";
        echo "<label for='imageFile'>Image File (Leave empty if not replacing!): </label>";
        echo "<input type='file' id='imageFile' class='form-control-file' name='fileToUpload'>";
        echo "</div>";

        // Display Release Date
        echo "<div class='form-group'>";
        echo "<label for='releaseDate'>Release Date:</label>";
        echo "<input class='form-control' id='releaseDate' type='date' name='releaseDate' value='".$gameInfo['ReleaseDate']."'>";
        echo "</div>";

        // Display Description
        echo "<div class='form-group'>";
        echo "<label for='description'>Description:</label>";
        echo "<textarea class='form-control' id='description' name='description'>".$gameInfo['Description']."</textarea>";
        echo "</div>";

        // Display Submit button
        echo "<input type='submit' class='btn btn-primary' value='Update Game' name='submit'></form>";
    ?>
</main>
<?php include "../php/footer.php" ?>
<script>
function validateForm(){
    var gameName = document.getElementById("name").value;
    var gameScore = document.getElementById("score").value;
    var gameDescription = document.getElementById("description").value;
    var gameReleaseDate = document.getElementById("releaseDate").value;

    var Consolescheckboxes = document.querySelectorAll('input[type="checkbox"][name="gameConsoles[]"]');
    var ConsolescheckedOne = Array.prototype.slice.call(Consolescheckboxes).some(x => x.checked);

    var Genrescheckboxes = document.querySelectorAll('input[type="checkbox"][name="gameGenres[]"]');
    var GenrescheckedOne = Array.prototype.slice.call(Genrescheckboxes).some(x => x.checked);

    if (gameName == "" || gameScore == "" || gameDescription == "" || gameReleaseDate == "" || ConsolescheckedOne == false || GenrescheckedOne == false){
        alert("Please ensure all required fields are filled out.");
        return false;
    }
    return true;
}
</script>
</body>
</html>