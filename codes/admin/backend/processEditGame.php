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
    $gameID = $_POST['gameID'];
    $gameName = $_POST['name'];
    $gameScore = $_POST['score'];
    $gameReleaseDate = $_POST['releaseDate'];
    $gameDescription = $_POST['description'];

    if (isset($_POST['gameGenres']) && isset($_POST['gameConsoles'])){
        $numOfGenre = count($_POST['gameGenres']);
        $numOfConsole = count($_POST['gameConsoles']);

        echo $numOfGenre;
        echo $numOfConsole;
    }else{
        // Return to editGames, with error message
        header("Location: ../editGames.php?GameID=".$gameID."&error=1");
        exit();
    }

    if ($numOfGenre == 0 || $numOfConsole == 0 || $gameName == "" || $gameScore == "" || $gameReleaseDate == "" || $gameDescription == "") {
        // Return to editGames, with error message
        header("Location: ../editGames.php?GameID=".$gameID."&error=1");
        exit();
    }


    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0){
        require "uploadImageFile.php";

        
        $oldimagePath = "";
        try{
            $stmt = $conn->prepare("SELECT ImagePath FROM Games WHERE GameID =?");
            $stmt->execute([$gameID]);
            $imagePath = $stmt->fetch();
            $oldimagePath = $imagePath['ImagePath'];
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $Uploadedfile = uploadImage();
        if ($Uploadedfile != false){
            try{
                $stmt = $conn->prepare("UPDATE Games SET ImagePath = ? WHERE GameID = ?");
                $file_name = "/images/game-images/" . $Uploadedfile;
                $stmt->execute([$file_name, $gameID]);

                unlink("/var/www/html".$oldimagePath);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }finally{
                $stmt = null;
            }
        }
    }

    // Delete the Game-to-Genre mapping
    try{
        $stmt = $conn->prepare("DELETE FROM Games_Genre WHERE idGame = ?");
        $stmt->execute([$gameID]);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $stmt = null;
    }

    // Add new Game-to-Genre mapping
    foreach ($_POST['gameGenres'] as $selectedGenres) {
        try{
            $stmt = $conn->prepare("SELECT idGenre FROM Genres WHERE Genre =?");
            $stmt->execute([$selectedGenres]);
            $genreID = $stmt->fetch();

            $stmt = $conn->prepare("INSERT INTO Games_Genre (idGame, idGenre) VALUES (?,?)");
            $stmt->execute([$gameID, $genreID['idGenre']]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt = null;
        }
    }

    // Delete Game-to-Console mapping
    try{
        $stmt = $conn->prepare("DELETE FROM Games_Console WHERE idGame = ?");
        $stmt->execute([$gameID]);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $stmt = null;
    }

    // Add new Game-to-Console mapping
    foreach ($_POST['gameConsoles'] as $selectedConsoles) {
        try{
            $stmt = $conn->prepare("SELECT idConsole FROM Consoles WHERE Console =?");
            $stmt->execute([$selectedConsoles]);
            $consoleID = $stmt->fetch();

            $stmt = $conn->prepare("INSERT INTO Games_Console (idGame, idConsole) VALUES (?,?)");
            $stmt->execute([$gameID, $consoleID['idConsole']]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $stmt = null;
        }
    }

    try{
        $stmt = $conn->prepare("UPDATE Games SET Name = ?, Score = ?, ReleaseDate = ?, Description = ? WHERE GameID = ?");
        $stmt->execute([$gameName, $gameScore, date("Y-m-d H:i:s",strtotime($gameReleaseDate)), $gameDescription, $gameID]);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $stmt = null;
    }


    header("Location: ../admin.php#editGames");

}

?>