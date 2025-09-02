<?php
  // Include the PHP file containing the function to retrieve upcoming games
  include "inc/databaseFunctions.php";

  // Call the function to retrieve upcoming games
  $bestPC = getBest_Console("PC");

  // Output the data as JSON
  header('Content-Type: application/json');
  echo json_encode($bestPC);
?>