<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Review</title>

  <?php include "inc/commonHead.php";?>
  <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 


</head>
<body>
    <?php
        require_once "inc/databaseFunctions.php";
        $conn = ConnectToDatabase_pdo();
        require_once "inc/sessionFunctions.php";
        include "php/navbar.php";
        global $NoOfUsers, $NoOfReviews, $NoOfGames;
        $NoOfUsers = getNumberOfUsers();
        $NoOfReviews = getNumberOfComments();
        $NoOfGames = getNumberOfGames();
    ?>
    <main>

<div class="wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
            <div class="container_aboutus">
                <div class="row">
                    <!-- counter -->
                    <div class="col-md-4 col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;">
                        <i class="fa fa-user medium-icon"></i>
                        <span class="timer counter alt-font appear" data-to="<?php echo $NoOfUsers; ?>" data-speed="7000"><?php echo $NoOfUsers; ?></span>
                        <span class="counter-title">Number of users</span>
                    </div>
                    <!-- end counter -->
                    <!-- counter -->
                    <div class="col-md-4 col-sm-6 bottom-margin text-center counter-section wow fadeInUp sm-margin-bottom-ten animated" data-wow-duration="600ms" style="visibility: visible; animation-duration: 600ms; animation-name: fadeInUp;">
                        <i class="fa fa-comments medium-icon"></i>
                        <span class="timer counter alt-font appear" data-to="<?php echo $NoOfReviews; ?>" data-speed="7000"><?php echo $NoOfReviews; ?></span>
                        <span class="counter-title">Number of reviews</span>
                    </div>
                    <!-- end counter -->
                    <!-- counter -->
                    <div class="col-md-4 col-sm-6 bottom-margin-small text-center counter-section wow fadeInUp xs-margin-bottom-ten animated" data-wow-duration="900ms" style="visibility: visible; animation-duration: 900ms; animation-name: fadeInUp;">
                        <i class="fa fa-gamepad medium-icon"></i>
                        <span class="timer counter alt-font appear" data-to="<?php echo $NoOfGames; ?>" data-speed="7000"><?php echo $NoOfGames; ?></span>
                        <span class="counter-title">Number of games</span>
                    </div>
                    <!-- end counter -->
                </div>
            </div>

</div>


<div class="py-3 py-md-5">
    <div class="container">
        <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
            <div class="col-12 col-lg-6 col-xl-5">
                <img class="img-fluid rounded" loading="lazy" src="images/logo.png" alt="Logo Image">
            </div>
            <div class="col-12 col-lg-6 col-xl-7">
                <div class="row justify-content-xl-center">
                    <div class="col-12 col-xl-11">
                        <h2 class="mb-3">Who are We?</h2>
                        <p class="lead fs-4 text-body mb-3">We are RAVENCRITIC</p>
                        <p class="mb-5">Our platform is devoid of condescension, elitism, assumptions, or deliberate argumentation. We maintain a celebratory tone, highlighting the positive aspects of games and entertainment while fostering unity among our audience. Consider us your trusted friend in the gaming realm, offering intriguing trivia, uncovering hidden gems, and providing behind-the-scenes insights. We're dedicated to steering you towards the most enriching gaming, viewing, and reading experiences through our reviews and recommendations.</p>
                        <div class="row gy-4 gy-md-0 gx-xxl-5X">
                            <div class="col-12 col-md-6">
                                <h2 class="h4 mb-3">Ravenscore</h2>
                                <p class="ttext-body mb-0">The Ravenscore is a single score that represents the overall consensus for games.</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <h2 class="h4 mb-3">Integrity</h2>
                                <p class="text-body mb-0">On RavenCritic we always aim to inform, entertain, and inspire through reviews, helping you spend your free time wisely. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






    </main>

    <?php
        include "php/footer.php";
    ?>



</body>
