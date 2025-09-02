<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Review: Search Results</title>
  <link rel='icon' type='image/x-icon' href='/images/favicon.png'>

  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
  crossorigin="anonymous">
  
  <!--Bootstrap JS-->
  <script defer
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous">
  </script>

  <!-- JS -->
  <script defer src="js/new_releases.js"></script>

  <!-- Poppins Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/poppins.css">

  <!--CSS-->
  <link rel="stylesheet" href="css/new_releases.css">

  <!-- Slick JS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<?php
    include "php/navbar.php";
?>

<?php
    include_once "inc/databaseFunctions.php";
    
    // Initialize search term variable
    $searchTerm = '';

    // Check if the query parameter is set and not empty
    if (isset($_GET['query']) && trim($_GET['query']) !== '') {
        // Sanitize the search term
        $searchTerm = htmlspecialchars($_GET['query']);
    }
?>

<main class='container'>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item poppins-extralight"><a href="../#">Home</a></li>
            <li class="breadcrumb-item active poppins-light" aria-current="page">Search Results</li>
        </ol>
    </nav>

    <h2 class='poppins-bold p-3'>SEARCH RESULTS: "<?php echo $searchTerm; ?>"</h2>

<?php
include_once "inc/databaseFunctions.php";

// Connect to the database
$conn = ConnectToDatabase_pdo();

// Check if the query parameter is set
if(isset($_GET['query']) && $_GET['query'] !== ''){
    $searchTerm = htmlspecialchars($_GET['query']);

    // Prepare the SQL statement to search the Name column in the Games table
    $sql = "SELECT GameID, Name, ImagePath FROM Games WHERE Name LIKE :term";
    $stmt = $conn->prepare($sql);
    
    // Bind the search term with a wildcard for partial matches
    $stmt->bindValue(':term', '%' . $searchTerm . '%');
    
    // Execute and fetch the results
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<div class='row'>";
    if ($results) {
        foreach ($results as $results) {
        echo "<div class='col-2 p-2'>";
            echo "<figure class='col-auto hidden-side card-tbd p-1'>";
                $sanitizedName = htmlspecialchars($results['Name'], ENT_QUOTES, 'UTF-8');
                echo "<img id='".$results['GameID']."' class='card-img clickable' draggable='false' src='" .$results['ImagePath']. "' alt='".$sanitizedName."' title='".$sanitizedName."'>";
            echo "</figure>";
        
            echo "<div class='caption row img-wrap'>";
                echo "<a class='col-auto game-name text-truncate poppins-regular clickable' href='game_details.php?id=".$results['GameID']."'>".$results['Name']."</a>";
            echo "</div>";
        echo "</div>";
        }
        echo "</div>";
        echo "<p class='text-center p-5'>~End of Search Results~</p>";
    } else {
        echo "<h2 class='poppins-bold p-3' style='color: darkred;'>No Results Found</h2>";
    }
} else {
    echo "<h2 class='poppins-bold p-3' style='color: darkred;'>Please Enter a Search Term</h2>";
}
?>
</main>

<?php
    include "php/footer.php";
?>
</html>