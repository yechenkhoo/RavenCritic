<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RavenCritic</title>

  <?php include "inc/commonHead.php";?>

  <!-- JS -->
  <script defer src="js/main.js"></script>

  <!--CSS-->
  <link rel="stylesheet" href="css/main.css">

  <!-- Slick JS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>

  <?php
  
    require_once "inc/databaseFunctions.php";
    $conn = ConnectToDatabase_pdo();
    require_once "inc/sessionFunctions.php";
    include "php/navbar.php";
  ?>


  <main>
    <!-- Return to top button -->
    <button onclick="returnToTop()" id="return-to-top" title="Return to Top">
      <img src="images/icons/return-top.svg" alt="Return to top button">
    </button>

    <?php
      $name = $_SESSION['name'];
      if ($name != NULL) {
        echo "<h1 class='poppins-regular p-3 fade-in-out'>Welcome Back ".$name." !</h1>";
      }
      
    ?>


  <div class="slider-wrap hidden">
    <div class="header-slide">
      <figure>
        <img src="/images/slider/ravencritic-slider-main.jpg" alt="RavenCritic banner">
      </figure>
      <figure>
        <img src="/images/slider/mario_slider.jpg" alt="Mario banner">
      </figure>
      <figure>
        <img src="/images/slider/minecraft_slider.jpg" alt="Minecraft banner">
      </figure>
      <figure>
        <img src="/images/slider/spiderman_slider.jpeg" alt="Spiderman banner">
      </figure>
      <figure>
        <img src="/images/slider/halo_slider.jpg" alt="Halo banner">
      </figure>
      <figure>
        <img src="/images/slider/watch_slider.jpg" alt="Watch banner">
      </figure>
      <figure>
        <img src="/images/slider/rdr2_slider.jpg" alt="Read Dead Redemption banner">
      </figure>
      <figure>
        <img src="/images/slider/resident_slider.jpg" alt="Resident Evil banner">
      </figure>
    </div>

      <div class="d-flex justify-content-between px-5">
        <button class="prev slick-arrow"> 
          <img src="/images/icons/arrow-back.svg" alt="Previous slide">
        </button>
        <button class="next slick-arrow">
          <img src="/images/icons/arrow-front.svg" alt="Next slide">
        </button>
      </div>
    </div>

    <div class="container p-3">
    <!-- New releases -->
    <h1 class="poppins-light text-center p-3">HIGHLIGHTS</h1>
    <section id='new-releases'>
      <div class="row d-flex justify-content-center hidden-top">
        <h2 class="col-auto poppins-semibold text-center section-title">NEW RELEASES</h2>
        <a class="col-auto poppins-light align-self-center" href="browse.php?all=new-releases">SEE ALL</a>        
        <hr>
        <h3 class="poppins-light text-center subtitle">Check out new arrivals</h3>
      </div>

      <?php
        $games = getNewRelease();
        $countNew = 0;

        echo "<div class='slider hidden lower-wrap'>";

        foreach ($games as $game) {
          if ($countNew != 10) {
            echo "<div class='col'>";
              echo "<figure class='hidden-side card p-1'>";
                $sanitizedName = htmlspecialchars($game['Name'], ENT_QUOTES, 'UTF-8');
                echo "<img id='".$game['GameID']."' class='card-img clickable' src='" .$game['ImagePath']. "' alt='".$sanitizedName."' title='".$sanitizedName."'>";
              echo "</figure>";
              
              echo "<div class='caption row img-wrap'>";
                echo "<div class='col-auto score'>";;
                  echo "<p class='poppins-bold number'>".$game['Score']."</p>";
                echo "</div>";

                echo "<a class='game-name col-sm text-truncate poppins-regular clickable' href='itempage.php?id=".$game['GameID']."'>".$game['Name']."</a>";
              echo "</div>";
            echo "</div>";
          }
          $countNew++;
        }
        echo "</div>";
      ?>
    </section>

    <!-- Best games -->
    <section id="bestgames" class="p-3">
      <div class="hidden-top">
        <h2 class="poppins-semibold text-center section-title">BEST OF</h2>
        <hr>
        <h3 class="poppins-light text-center subtitle">Must-Play Gems to try on each console</h3>
      </div>

      <!--Selection buttons-->
      <div class="hidden" role="group" aria-label="Vertical radio toggle button group">
        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio1" checked>
        <label id="xbox" class="btn btn-outline-dark" for="vbtn-radio1">Xbox</label>
        
        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio2">
        <label id="ps" class="btn btn-outline-dark" for="vbtn-radio2">PlayStation</label>
        
        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio3">
        <label id="switch" class="btn btn-outline-dark" for="vbtn-radio3">Switch</label>
        
        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio4">
        <label id="pc" class="btn btn-outline-dark" for="vbtn-radio4">PC</label>
      </div>

      <?php
        $games = getBest_Console("Xbox");
        $count = 0;

        echo "<div id='best' class='slider-bestof hidden lower-wrap'>";

        foreach ($games as $game) {
          if ($count != 5) {
            echo "<div class=' col'>";
              echo "<figure class='hidden-side card p-1'>";
                $sanitizedName = htmlspecialchars($game['Name'], ENT_QUOTES, 'UTF-8');
                echo "<img id='".$game['GameID']."' class='best-of-img card-img clickable' src='" .$game['ImagePath']. "' alt='".$sanitizedName."' title='".$sanitizedName."'>";
              echo "</figure>";
              
              echo "<div class='caption row img-wrap'>";
                echo "<div class='col-auto score'>";;
                  echo "<p class='filter-score poppins-bold number'>".$game['Score']."</p>";
                echo "</div>";

                echo "<a class='filter-name game-name col-sm text-truncate poppins-regular clickable' href='itempage.php?id=".$game['GameID']."'>".$game['Name']."</a>";
              echo "</div>";
            echo "</div>";
            
            $count++;
          }
        }
        echo "</div>";
      ?>
    </section>
    
    <!-- Upcoming games -->
    <section id="upcoming" class="p-3">
      <div class="hidden-top">
        <h2 class="poppins-semibold text-center section-title">UPCOMING</h2>
        <hr>
        <h3 class="poppins-light text-center subtitle">Stay Ahead of the Game</h3>
      </div>
      
      <?php
        $games = getUpcoming();
        $count = 0;

        echo "<div class='upcoming hidden lower-wrap'>";

        foreach ($games as $game) {
          if ($count != 5) {
            echo "<div class=' col'>";
              echo "<figure class='hidden-side card-tbd p-1'>";
                $sanitizedName = htmlspecialchars($game['Name'], ENT_QUOTES, 'UTF-8');
                echo "<img id='".$game['GameID']."' class='card-img' src='" .$game['ImagePath']. "' alt='".$sanitizedName."' title='".$sanitizedName."'>";
              echo "</figure>";
              
              echo "<div class='caption row img-wrap'>";
                echo "<div class='col-auto score'>";;
                  echo "<p class='poppins-bold number'>"."   "."</p>";
                echo "</div>";

                echo "<p class='game-name col-sm text-truncate poppins-regular'>".$game['Name']."</p>";
              echo "</div>";
            echo "</div>";

            $count++;
          }
        }
        echo "</div>";
      ?>
    </section>



    <section id="features">
        <div class="hidden-top p-2">
          <h2 class="poppins-semibold text-center">FEATURES</h2>
          <hr>
        </div>

        <div class="row hidden-side">
          <h2 class="text-end ">Browse Games</h2>
          <p class="col poppins-light">
            Use the search bar or browse through categories to discover reviews of your favorite games.
            Each review provides detailed information about the game's gameplay, graphics, story, and overall experience.
            Check out the rating system to quickly gauge the quality of each game.
          </p>
          <div class="card2">
            <img class="card-img bright" src="images/features/browse-games.PNG" alt="A collection of games.">
          </div>
        </div>

        <div class="row hidden-side">
          <h2 class="">User Reviews & Community Interaction</h2>
          <div class="card2">
            <img class="card-img bright" src="images/features/comments.PNG" alt="Comments on a game page.">
          </div>
          <p class="col poppins-light">
            Share your thoughts by submitting your own comments for games you've played..
            Engage with other members of the gaming community through comments and discussions on reviews.
            Share your gaming experiences, strategies, and recommendations with like-minded individuals.
          </p>
        </div>
    </section>
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