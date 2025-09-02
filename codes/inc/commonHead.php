<?php
    $relative_directory = dirname($_SERVER['SCRIPT_NAME']);

    echo <<<EOT
    <link rel='icon' type='image/x-icon' href='/images/favicon.png'>

    <!--Bootstrap-->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css'
    rel='stylesheet'
    integrity='sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9'
    crossorigin='anonymous'>

    <!--Bootstrap JS-->
    <script async
    src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm'
        crossorigin='anonymous'>
    </script>
    
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/poppins.css">

    <!--Main JS-->
    <script defer src="/js/main.js"></script>

    <!--Main CSS-->
    <link rel="stylesheet" href="/css/main.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

    
EOT;
?>