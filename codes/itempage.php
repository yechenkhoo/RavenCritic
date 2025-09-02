<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Game Review</title>
        <link rel='icon' type='image/x-icon' href='/images/favicon.png'>

        <!--Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
        crossorigin="anonymous">
        
        <!--CSS-->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/item.css">


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
        <?php 
            require_once "inc/databaseFunctions.php";
            $conn = ConnectToDatabase_pdo();
            require_once "inc/sessionFunctions.php";
            include 'comment.php';

            if (!isset($_GET['id']) || strlen(trim($_GET['id'])) == 0){
                header("Location: index.php");
            }

            if (!$conn){
                echo "Connection failed: ". $conn->connect_error;
            }
            else{
                $id = $_GET['id'];
                $sql = "SELECT * FROM Games WHERE GameID = ?"; 
                $stmt = $conn->prepare($sql);

                // Bind the id parameter and execute the statement
                $stmt->execute([$id]);

                // Fetch the data
                $info = $stmt->fetchAll();

                // if info is empty, redirect to index.php
                if (empty($info)){
                    header("Location: index.php");
                }

                foreach($info as $row){
                    $name = $row['Name'];
                    $img = $row['ImagePath'];
                    $des = $row['Description'];
                    $score = $row['Score'];
                    $releasedate = $row['ReleaseDate'];
                }

                $Gamegenres = array_column(getGenresByGame($id), 'Genre');
                $Gameconsoles = array_column(getConsolesByGame($id), 'Console');
            }

            function getName($cid, $conn){
                $sql = "SELECT FirstName, LastName FROM Users WHERE Email in (SELECT Com_Email FROM Comments WHERE Cid = ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$cid]);
                $nameinfo = $stmt->fetchAll();
                foreach($nameinfo as $row){
                    $fnameCom = $row['FirstName'];
                    $lnameCom = $row['LastName'];
                }
                return [$fnameCom, $lnameCom];
            }

            function getComments($id){
                $conn = ConnectToDatabase_pdo();
                if (!$conn){
                    echo "Connection failed: ". $conn->connect_error;
                }
                else{
                    $sql = "SELECT Comment, Cid, Com_Email, Date FROM Comments WHERE Com_GameID = ?"; 
                    $stmt = $conn->prepare($sql);

                    // Bind the id parameter and execute the statement
                    $stmt->execute([$id]);

                    // Fetch the data
                    $info = $stmt->fetchAll();

                    foreach($info as $row){
                        $comment = $row['Comment'];
                        $cid = $row['Cid'];
                        $date = $row['Date'];
                        $uid = $row['Com_Email'];
                        [$fnameCom, $lnameCom] = getName($cid, $conn);

                        echo "<div class = 'col-md-6 comment-box'>
                            <h3>$fnameCom $lnameCom</h3>
                            <p>$comment</p>
                            <p>$date</p>";
                        if (isset($_SESSION['email']) && $_SESSION['email'] == $uid){
                            echo "<div class = 'button-container'><form class = 'delete-form' action = '" . deleteComments($conn) . "' method = 'post'>
                                    <input type = 'hidden' name = 'cid' value = '$cid'>
                                    <button type = 'submit' name = 'comment-delete'>Delete</button> 
                                </form>
                                <form class = 'edit-form' action = '" . editComment($conn) . "' method = 'post'>
                                    <input type = 'hidden' name = 'cid' value = '$cid'>
                                    <input type = 'hidden' name = 'gameid' value = '$id'>
                                    <inut type = 'hidden' name = 'commentedit' value = 'comment-edit-$cid'>
                                    <button class = 'editbtn' type = 'submit' name = 'comment-edit' value = 'comment-edit-$cid' style = 'margin-right: 20px'>Edit</button>  
                                </form></div></div>";
                        }
                        else{
                            echo "</div>";
                        }            
                    }
                }
            }

            function getStars($score){
                $stars = intval($score);
                $halfstar = $score - $stars;
                $emptyStar = 0;
                $output = '';
                $starSize = 40;
                $starCount = 0;
                $starFullFile = 'images/stars/star-blue.png';
                $starHalfFile = 'images/stars/halfstar-blue.png';

                if ($score >= 8.5) {
                    $starFullFile = 'images/stars/star-purple.png';
                    $starHalfFile = 'images/stars/halfstar-purple.png';
                }

                else if ($score >= 0 && $score < 4.5) {
                    $starFullFile = 'images/stars/star-red.png';
                    $starHalfFile = 'images/stars/halfstar-red.png';
                }

                for($i = 0; $i < $stars; $i++){
                    $output .= '<img src = ' . $starFullFile . ' alt = "Star" style="width: ' . $starSize . 'px; height: ' . $starSize . 'px;">';
                    $starCount++;
                }
                if (($halfstar < 0.75 || $halfstar > 0.25) && $halfstar > 0){
                    $output .= '<img src = ' . $starHalfFile . ' alt = "Star" style="width: ' . $starSize . 'px; height: ' . $starSize . 'px;">';
                    $starCount++;
                }
                else if ($halfstar > 0.75){
                    $output .= '<img src = ' . $starFullFile . ' alt="Star" style="width: ' . $starSize . 'px; height: ' . $starSize . 'px;">';
                    $starCount++;
                }
                if ($starCount < 10){
                    if ($score - intval($score) < 0.3){
                        $emptyStar = 10 - intval($score);
                    }
                    else {
                        $emptyStar = 10 - intval($score) - 1;
                    }
                    for($i = 0; $i < $emptyStar; $i++){
                        $output .= '<img src = "images/stars/emptystar.png" alt = "Star" style="width: ' . $starSize . 'px; height: ' . $starSize . 'px;">';
                    }
                }
                
                return $output;
            }

            include 'php/navbar.php'; 
        ?>

        <main class="container">
            <nav aria-label='breadcrumb'>
                <ol class="breadcrumb p-3">
                    <li class="breadcrumb-item poppins-extralight"> <a class="text-decoration-none" href="/index.php">Home</a></li>
                    <li class="breadcrumb-item poppins-extralight"> <a class="text-decoration-none" href="/browse.php?all=browse-all">Browse All</a></li>
                    <li class="breadcrumb-item active poppins-light text-decoration-none"><?php echo $name; ?></li>
                </ol>
            </nav>


            <figure class="top-img-wrapper">
                <img  class="fill-image" src="<?php echo $img; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>">
            </figure>


            
            <section class="row">
                <div class="col-md-6 thumbnail-wrapper m-3 mx-auto">
                    <img class="game-thumbnail" src="<?php echo $img; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>">
                </div>
                <div class="col-md-6 details">
                    <h3 class="poppins-semibold mb-3"><?php echo $name; ?></h3>
                    <div class="my-4">
                        <h2 class="poppins-semibold">Description</h2>
                        <p class="poppins-light"><?php echo $des; ?></p>
                    </div>
                    <div class="my-2">
                        <h2 class="poppins-semibold">Release Date</h2>
                        <p class="poppins-light"><?php echo $releasedate; ?></p>
                    </div>

                    <h2 class="poppins-semibold">Console</h2>
                    <p class="poppins-light"><?php foreach ($Gameconsoles as $c) { echo $c." "; } ?></p>
                    <h2 class="poppins-semibold">Genre</h2>
                    <p class="poppins-light"><?php foreach ($Gamegenres as $g) { echo $g." "; } ?></p>
                    <h2 class="poppins-semibold">Score: </h2>
                    <div class = "score-container">
                        <p><?php echo $score;?></p>
                        <?php echo getStars($score); ?>
                    </div>
                </div>
            </section><br><br>
            <div class='col-md-6 m-3'>
                <h2 id = "comm">Comments</h2>
            <?php
                if(isset($_SESSION['email'])){
                    //getLogin($conn);
                    $sql = "SELECT * FROM Comments WHERE Com_GameID = ? AND Com_Email = ?";
                    $result = $conn->prepare($sql);
                    $result->execute([$id, $_SESSION['email']]);
                    $count = $result->rowCount();

                    if ($count == 0){
                        echo "
                            <div class='col-md-6' id='commenting-box'>
                                <form action='" . submitComment($conn) . "' method='post'>
                                    <label for='commentarea' aria-hidden=true style='display:none;'>write comment here:</label><br><textarea id='commentarea' name='comment' rows='4' cols='50' placeholder='Enter your comment here' style='width: 80%;'></textarea>
                                    <input type='hidden' name='uid' value='" . $_SESSION['email'] . "'>
                                    <input type='hidden' name='GameID' value='$id'>
                                    <input type='hidden' name='date' value='" . date('Y-m-d') . "'>
                                    <br>
                                    <button type='submit' name='commentSubmit' class='btn btn-primary'>Comment</button>
                                </form>
                            </div><br><br>";
                    }
                    else{
                        echo "You have already commented.<br><br>";
                    }
                }
                else{
                    echo "Login to comment on this game.<br><br>";
                }
                
            ?>
            </div>

            <?php
                getComments($id);
            ?>

        </main>
        <?php 
            include 'php/footer.php'; 
        ?>
    </body>
</html>