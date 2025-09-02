<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Review: All Games</title>
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
<body>
  <?php
    include_once "inc/databaseFunctions.php";
    $conn = ConnectToDatabase_pdo();
    include_once "inc/sessionFunctions.php";
    include "php/navbar.php";
  ?>

  <!-- Return to top button -->
  <button onclick="returnToTop()" id="return-to-top" title="Return to Top">
    <img src="images/icons/return-top.svg" alt="Return to top button">
  </button>

  <main class='container'>


    
    <?php 
      $page = $_GET['all'] ?? '';

      if ($page == "browse-all") {
        echo "<nav aria-label='breadcrumb'>";
        echo "<ol class='breadcrumb p-3'>";
          echo "<li class='breadcrumb-item poppins-extralight'><a href='../#'>Home</a></li>";
          echo "<li class='breadcrumb-item active poppins-light' aria-current='page'>Browse All</li>";
        echo "</ol>";
        echo "</nav>";

        echo "<h2 class='poppins-bold p-3'>BROWSE ALL</h2>";
        $games = getAllGames();

        echo "<div class='container'>";
          echo "<div class='row'>";
          // Loop through all the games and display them.
          foreach ($games as $game) {
            echo "<div class='col-auto'>";
              echo "<figure class='hidden-side card-tbd p-1'>";
                $sanitizedName = htmlspecialchars($game['Name'], ENT_QUOTES, 'UTF-8');
                echo "<img id='".$game['GameID']."' class='card-img clickable' draggable='false' src='" .$game['ImagePath']. "' alt='".$sanitizedName."' title='".$sanitizedName."'>";
              echo "</figure>";
              echo "<div class='caption row img-wrap'>";
                echo "<a class='text-truncate game-name poppins-regular clickable' href='itempage.php?id=".$game['GameID']."'>".$game['Name']."</a>";
              echo "</div>";
            echo "</div>";
          }
          echo "</div>";
        echo "</div>";

        echo "<p class='text-center p-5'>-End Of All Games-</p>";
      }

      else if ($page == "new-releases") {
        echo "<nav aria-label='breadcrumb'>";
        echo "<ol class='breadcrumb p-3'>";
          echo "<li class='breadcrumb-item poppins-extralight'><a href='../#'>Home</a></li>";
          echo "<li class='breadcrumb-item active poppins-light' aria-current='page'>New Releases</li>";
        echo "</ol>";
        echo "</nav>";
        echo "<h2 class='poppins-bold p-3'>ALL NEW RELEASES</h2>";
        $games = getNewRelease();

        echo "<div class='container'>";
          echo "<div class='row'>";
          // Loop through all the games and display them.
          foreach ($games as $game) {
            echo "<div class='col-auto'>";
              echo "<figure class='hidden-side card-tbd p-1'>";
                $sanitizedName = htmlspecialchars($game['Name'], ENT_QUOTES, 'UTF-8');
                echo "<img id='".$game['GameID']."' class='card-img clickable' draggable='false' src='" .$game['ImagePath']. "' alt='".$sanitizedName."' title='".$sanitizedName."'>";
              echo "</figure>";
              echo "<div class='caption row img-wrap'>";
                echo "<a class='text-truncate game-name poppins-regular clickable' href='itempage.php?id=".$game['GameID']."'>".$game['Name']."</a>";
              echo "</div>";
            echo "</div>";
          }
          echo "</div>";
        echo "</div>";

        echo "<p class='text-center'>-End Of New Releases-</p>";
      }

      else {

        // Add exception for battle royale.
        if ($page == "battle-royale") {
          $page = "Battle Royale";
        }

        $games = getGamesByGenre($page);

        if ($games != NULL) {
          
          echo "<nav aria-label='breadcrumb'>";
          echo "<ol class='breadcrumb p-3'>";
            echo "<li class='breadcrumb-item poppins-extralight'><a href='../#'>Home</a></li>";
            echo "<li class='breadcrumb-item active poppins-light text-capitalize' aria-current='page'>$page</li>";
          echo "</ol>";
          echo "</nav>";
          echo "<h2 class='poppins-bold p-3 text-uppercase'>$page</h2>";
  
  
          echo "<div class='container'>";
            echo "<div class='row'>";
            // Loop through all the games and display them.
            foreach ($games as $game) {
              echo "<div class='col-auto'>";
                echo "<figure class='hidden-side card-tbd p-1'>";
                  $sanitizedName = htmlspecialchars($game['Name'], ENT_QUOTES, 'UTF-8');
                  echo "<img id='".$game['GameID']."' class='card-img clickable' draggable='false' src='" .$game['ImagePath']. "' alt='".$sanitizedName."' title='".$sanitizedName."'>";
                echo "</figure>";
                echo "<div class='caption row img-wrap'>";
                  echo "<a class='text-truncate game-name poppins-regular clickable' href='itempage.php?id=".$game['GameID']."'>".$game['Name']."</a>";
                echo "</div>";
              echo "</div>";
            }
            echo "</div>";
          echo "</div>";
  
          echo "<p class='text-center text-capitalize'>-End Of $page Games-</p>";
        }

        else {
          echo "<nav aria-label='breadcrumb'>";
          echo "<ol class='breadcrumb p-3'>";
            echo "<li class='breadcrumb-item poppins-extralight'><a href='../#'>Home</a></li>";
            echo "<li class='breadcrumb-item active poppins-light text-capitalize' aria-current='page'>$page</li>";
          echo "</ol>";
          echo "</nav>";
          echo "<p class='p-3 poppins-regular'>No Results.</p>";
        }

      }
    ?>
  </main>
  
  <?php
    include "php/footer.php";
  ?>
</body>
</html>