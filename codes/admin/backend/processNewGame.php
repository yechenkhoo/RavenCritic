<?php
include_once "../../inc/databaseFunctions.php";
$conn = ConnectToDatabase_pdo();
include_once "../../inc/sessionFunctions.php";

// Prevent unauthenticated/unauthorized user from accessing this page 
if ($_SESSION['admin'] != true || $_SESSION['logged_in'] != true) {
    header("Location: ../../login.php");
    exit();
}


if(isset($_POST['submit'])){
    // Get all the fields 
    $gameName = $_POST['gameName']; // Get gameName
    $gameScore = $_POST['gameScore']; // Get gameScore
    $gameReleaseDate = $_POST['gameReleaseDate']; // Get gameReleaseDate
    $gameDescription = $_POST['gameDescription']; // Get gameDescription
    
    if ($gameName == "" || $gameScore == "" || $gameReleaseDate == "" || $gameDescription == "") {
        // Return to addGame, with error message
        header("Location: ../admin.php?error=1#addGame");
    }

    require "uploadImageFile.php";
    $uploadedFile = uploadImage();

    if ($uploadedFile != false){
        try{
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO Games (Name, Score, ReleaseDate, Description, ImagePath) VALUES (?,?,?,?,?)");

            $file_name = "/images/game-images/" . $uploadedFile;
            $stmt->execute([$gameName, $gameScore, date("Y-m-d H:i:s",strtotime($gameReleaseDate)), $gameDescription, $file_name]);

            $gameID = $conn->lastInsertId();
            
            // Insert Genre selection
            // Loop through $_POST['gameGenres']
            foreach ($_POST['gameGenres'] as $selectedGenres) {
                $stmt = $conn->prepare("SELECT idGenre FROM Genres WHERE Genre =?");
                $stmt->execute([$selectedGenres]);
                $genreID = $stmt->fetch();

                $stmt = $conn->prepare("INSERT INTO Games_Genre (idGame, idGenre) VALUES (?,?)");
                $stmt->execute([$gameID, $genreID['idGenre']]);
            }


            // Insert Console selection
            // Loop through $_POST['gameConsoles']
            foreach ($_POST['gameConsoles'] as $selectedConsoles) {
                $stmt = $conn->prepare("SELECT idConsole FROM Consoles WHERE Console =?");
                $stmt->execute([$selectedConsoles]);
                $consoleID = $stmt->fetch();

                $stmt = $conn->prepare("INSERT INTO Games_Console (idGame, idConsole) VALUES (?,?)");
                $stmt->execute([$gameID, $consoleID['idConsole']]);
            }

            // Redirect to admin page
            header("Location:../admin.php#addGame");

        } catch (Exception $e) {
            echo "Execute failed: (". $e->getMessage(). ") ".
            // Delete file if unsuccessful insert
            unlink($target_file);
        } finally {
            $stmt = null;
        }
    } else {
        echo "Upload failed. Please try again.";
        echo "<a href='../admin.php#addGame'>Back to Add Game</a>";
    }
}



?>