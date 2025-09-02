
<?php

global $genre, $console;
include_once "../inc/databaseFunctions.php";

//run function to get all the users 
$genre  = getAllGenre();
$console = getAllConsole();
if (isset($_GET['error'])){
    if ($_GET['error'] == 1){
        echo "<div class='alert alert-danger' role='alert'>Error: Game not added<br>Please ensure all required fields are entered.</div>";
    }
}
?>



<form action="backend/processNewGame.php" method="post" enctype="multipart/form-data" onsubmit="return validateAddGame()">
    <div class="form-group">
        <label for="gameName">Game Name:</label>
        <input required type="text" class="form-control" id="gameName" placeholder="Name of game" name="gameName">
    </div>
    <div class="form-group">
        <label for="gameScore">Game Score:</label>
        <input required type="number" step="0.1" min="0" max="10" class="form-control" id="gameScore" placeholder="Score of game" name="gameScore">
    </div>
    <div class="form-group">
        <label>Consoles:</label>
        <?php foreach ($console as $c): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="gameConsoles[]" id="<?php echo $c['Console']; ?>" value="<?php echo $c['Console']; ?>">
                <label class="form-check-label" for="<?php echo $c['Console']; ?>" >
                <?php echo $c['Console']; ?>  
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <label >Genres:</label>
        <?php foreach ($genre as $g): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="gameGenres[]" id="<?php echo str_replace(' ', '', $g['Genre']); ?>" value="<?php echo str_replace(' ', '', $g['Genre']); ?>">
                <label class="form-check-label" for="<?php echo str_replace(' ', '', $g['Genre']); ?>">
                <?php echo $g['Genre']; ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <label for="gameReleaseDate">Release Date:</label>
        <input required type="date" class="form-control" id="gameReleaseDate" name="gameReleaseDate">
    </div>
    <div class="form-group">
        <label for="gameDescription">Description of the Game:</label>
        <textarea required class="form-control" id="gameDescription" rows="3" name="gameDescription"></textarea>
    </div>
    <div class="form-group">
        <label for="gameImageFile">Image File Upload:</label>
        <input required type="file" class="form-control-file" id="gameImageFile" name="fileToUpload">
    </div>
    <input type="submit" value="Submit" class="btn btn-primary" name="submit">
</form>


<script>
function validateAddGame(){
    var gameName = document.getElementById("gameName").value;
    var gameScore = document.getElementById("gameScore").value;
    var gameDescription = document.getElementById("gameDescription").value;
    var gameReleaseDate = document.getElementById("gameReleaseDate").value;
    var gameImageFile = document.getElementById("gameImageFile").value;

    var Consolescheckboxes = document.querySelectorAll('input[type="checkbox"][name="gameConsoles[]"]');
    var ConsolescheckedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);

    var Genrescheckboxes = document.querySelectorAll('input[type="checkbox"][name="gameGenres[]"]');
    var GenrescheckedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);

    if (gameName == "" || gameScore == "" || gameDescription == "" || gameReleaseDate == "" || gameImageFile == "" || ConsolescheckedOne == false || GenrescheckedOne == false){
        alert("Please ensure all fields are filled out.");
        return false;
    }
    return true;
}
</script>