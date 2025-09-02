<?php
  // Include the PHP file containing the function to retrieve upcoming games
  include "inc/databaseFunctions.php";

  // Call the function to retrieve upcoming games
  $bestSwitch = getBest_Console("Switch");

  // Output the data as JSON
  header('Content-Type: application/json');
  echo json_encode($bestSwitch);
?>