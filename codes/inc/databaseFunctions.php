<?php

function getConfigDetails(){
    $config  = parse_ini_file("/var/www/private/db-config.ini");
    if (!$config){
        echo "Error: Unable to parse config file";
        exit;
    }else{
        return $config;
    }
}

function ConnectToDatabase_mysqli(){
    $config = getConfigDetails();
    $servername = $config['servername'];
    $username = $config['username'];
    $password = $config['password'];
    $dbname = $config['dbname'];

    // Create Connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check Connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function ConnectToDatabase_pdo(){
    $config = getConfigDetails();
    $servername = $config['servername'];
    $username = $config['username'];
    $password = $config['password'];
    $dbname = $config['dbname'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function getAllGames(){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi

    $stmt = $conn->prepare("SELECT Name, ImagePath, Score, GameID FROM Games ORDER BY GameID ASC");
    $stmt->execute();

    $games = $stmt->fetchAll();
    return $games;
}

function getNewRelease(){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi

    $stmt = $conn->prepare("SELECT Name, ImagePath, Score, GameID FROM Games WHERE (ReleaseDate > DATE_SUB(NOW(), INTERVAL 3 MONTH) AND ReleaseDate <= NOW());");
    $stmt->execute();

    $games = $stmt->fetchAll();
    return $games;
}

// Avoid duplicate ids, will only show those not in newly released section.
function getUpcoming(){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi

    $stmt = $conn->prepare("SELECT Name, ImagePath, Score, GameID FROM Games WHERE ReleaseDate > NOW() OR ReleaseDate IS NULL;");
    $stmt->execute();

    $games = $stmt->fetchAll();
    return $games;
}

function getBest_Console($console){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi

    $stmt = $conn->prepare("SELECT idConsole FROM Consoles WHERE Console =?");
    $stmt->execute([$console]);

    $consoleID = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT idGame FROM Games_Console where idConsole =?");
    $stmt->execute([$consoleID['idConsole']]);
    $gameIDs = $stmt->fetchAll();

    $gameIDs = array_column($gameIDs, 'idGame');

    $stmt = $conn->prepare("SELECT Name, ImagePath, Score, GameID FROM Games WHERE GameID IN (". implode(',', $gameIDs). ") AND Score >= 7 AND ReleaseDate <= DATE_SUB(NOW(), INTERVAL 3 MONTH) LIMIT 5");
    $stmt->execute();

    $games = $stmt->fetchAll();
    return $games;
}


function getGameDetails($gameID){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi

    $stmt = $conn->prepare("SELECT Name, ImagePath, Score, GameID, Description, ReleaseDate FROM Games WHERE GameID =?");
    $stmt->execute([$gameID]);

    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    return $game;
}

function getCommentsForGame($gameID){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("SELECT Comment, Com_Email, Date FROM Comments WHERE Com_GameID =?");
    $stmt->execute([$gameID]);

    $comments = $stmt->fetchAll();
    return $comments;
}

function getNumberOfUsers(){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("SELECT COUNT(*) as row_count FROM Users");
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['row_count'];

}

function getNumberOfGames(){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("SELECT COUNT(*) as row_count FROM Games");
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['row_count'];

}

function getNumberOfComments(){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("SELECT COUNT(*) as row_count FROM Comments");
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['row_count'];

}

function getGamesByGenre($genre){
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi

    $stmt = $conn->prepare("SELECT idGenre FROM Genres WHERE Genre =?");
    $stmt->execute([$genre]);
    $genreID = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT idGame FROM Games_Genre where idGenre =?");
    $stmt->execute([$genreID['idGenre']]);
    $gameIDs = $stmt->fetchAll();

    $gameIDs = array_column($gameIDs, 'idGame');

    if (!empty($gameIDs)) {
        $stmt = $conn->prepare("SELECT Name, ImagePath, Score, GameID, Description, ReleaseDate FROM Games WHERE GameID IN (". implode(',', $gameIDs). ")");
        $stmt->execute();
        $games = $stmt->fetchAll();
    } else {
        $games = NULL;
    }

    return $games;
}

function getAllUsers(){

    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("SELECT email, FirstName, LastName, admin FROM Users ORDER BY email ASC" );
    $stmt->execute();
    $users = $stmt->fetchAll();

    return $users;
}


function promoteUser($email) {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  
    $stmt = $conn->prepare("Update Users set admin=? where email=?");
    $stmt->execute([1,$email]);
    $results = $stmt->fetchAll();
    return $results;
}


function removeAdmin($email) {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  
    $stmt = $conn->prepare("Update Users set admin=? where email=?");
    $stmt->execute([0,$email]);
    $results = $stmt->fetchAll();
    return $results;
    
}

function removeUser($email) {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  

    $stmt = $conn->prepare("DELETE from Comments where Com_Email=?");
    $stmt->execute([$email]);
    $stmt = $conn->prepare("DELETE from Users where email=?");
    $stmt->execute([$email]);

   

    $results = $stmt->fetchAll();
    return $results;
    
}

function removeGames($GameID) {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("DELETE from Games_Genre where idGame=?");
    $stmt->execute([$GameID]);
    $stmt = $conn->prepare("DELETE from Games_Console where idGame=?");
    $stmt->execute([$GameID]);

    $stmt = $conn->prepare("SELECT ImagePath FROM Games WHERE GameID =?");
    $stmt->execute([$GameID]);
    $imagePath = $stmt->fetch(PDO::FETCH_ASSOC);
    unlink($imagePath['imagePath']);

    $stmt = $conn->prepare("DELETE from Games WHERE GameID=?");
    $stmt->execute([$GameID]);
    return "Game deleted successfully";
    
}

//used by add game php file
function getAllGenre() {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  
    $stmt = $conn->prepare("Select Genre from Genres ORDER BY Genre ASC");
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results;
    
}
//used by add game php file
function getAllConsole() {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  
    $stmt = $conn->prepare("Select Console from Consoles ORDER BY Console ASC");
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results;
    
}


//used by view console php file
function getConsole() {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("Select * from Consoles ORDER BY idConsole ASC");
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results;
    
}

function getGenre() {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    $stmt = $conn->prepare("Select * from Genres ORDER BY idGenre ASC");
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results;
    
}

function removeConsole($idConsole) {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    //select * from the consoles table 
    //if row count >1 then give error to delete games attach to that console 
    //if row count =0 then delete console
    $stmt = $conn->prepare("SELECT COUNT(*) as row_count FROM Games_Console WHERE idConsole=?");
    $stmt->execute([$idConsole]);
    $count = $stmt->fetch(PDO::FETCH_ASSOC);

    //if row count more than 0 get the game id then get the game name to display what games attached 
    //to the console
    
    if($count['row_count'] > 0){
        $stmt = $conn->prepare("SELECT idGame FROM Games_Console WHERE idConsole=?");
        $stmt->execute([$idConsole]);
        $gameIDs = $stmt->fetchAll();

        //use this gameID to fetch from Games table using the game id
        $stmt = $conn->prepare("SELECT Name FROM Games WHERE GameID IN (". implode(',', array_column($gameIDs, 'idGame')).")");
        $stmt->execute();
        $games = $stmt->fetchAll();
        $games = "Games attached to this console: " . implode(', ', array_column($games, 'Name')) . ". Please remove these games before deleting the console.";
        return $games;
    }
    else{
        $stmt = $conn->prepare("DELETE from Consoles where idConsole=?");
        $stmt->execute([$idConsole]);
        $results = $stmt->fetchAll();
        return 'success';

    }
}


function removeGenre($idGenre) {
    //conn to db 
    $conn = ConnectToDatabase_pdo();  // Change to ConnectToDatabase_mysqli() for MySQLi
    //select * from the consoles table 
    //if row count >1 then give error to delete games attach to that console 
    //if row count =0 then delete console
    $stmt = $conn->prepare("SELECT COUNT(*) as row_count FROM Games_Genre WHERE idGenre=?");
    $stmt->execute([$idGenre]);
    $count = $stmt->fetch(PDO::FETCH_ASSOC);

    //if row count more than 0 get the game id then get the game name to display what games attached 
    //to the console
    
    if($count['row_count'] > 0){
        $stmt = $conn->prepare("SELECT idGame FROM Games_Genre WHERE idGenre=?");
        $stmt->execute([$idGenre]);
        $gameIDs = $stmt->fetchAll();

        //use this gameID to fetch from Games table using the game id
        $stmt = $conn->prepare("SELECT Name FROM Games WHERE GameID IN (". implode(',', array_column($gameIDs, 'idGame')).")");
        $stmt->execute();
        $games = $stmt->fetchAll();
        $games = "Games attached to this genre: " . implode(', ', array_column($games, 'Name')) . ". Please remove these games before deleting the genre.";
        return $games;
    }
    else{
        $stmt = $conn->prepare("DELETE from Genres where idGenre=?");
        $stmt->execute([$idGenre]);
        $results = $stmt->fetchAll();
        return 'success';    

    }
}

function getGenresByGame($gameID){
    //conn to db
    $conn = ConnectToDatabase_pdo();
    $stmt = $conn->prepare("SELECT idGenre FROM Games_Genre WHERE idGame = ?");
    $stmt->execute([$gameID]);

    $results = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT Genre FROM Genres WHERE idGenre IN (".implode(',',array_column($results,'idGenre')).")");
    $stmt->execute();

    $genres = $stmt->fetchAll();
    return $genres;
}

function getConsolesByGame($gameID){
    //conn to db
    $conn = ConnectToDatabase_pdo();
    $stmt = $conn->prepare("SELECT idConsole FROM Games_Console WHERE idGame = ?");
    $stmt->execute([$gameID]);

    $results = $stmt->fetchAll();

    $stmt = $conn->prepare("SELECT Console FROM Consoles WHERE idConsole IN (".implode(',',array_column($results,'idConsole')).")");
    $stmt->execute();

    $consoles = $stmt->fetchAll();
    return $consoles;
}

?>
