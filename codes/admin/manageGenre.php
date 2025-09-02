

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



global $genre;
include_once "../inc/databaseFunctions.php";

//run function to get all the users 
$genre  = getGenre();

echo '<div style="overflow-x:auto;">';
echo '<table class="table table-bordered table-hover">';
echo '<thead>';
echo '<tr>';
echo '<th>idGenre</th>';
echo '<th class="d-none d-md-table-cell">Genre</th>';
echo '<th>Delete</th>';
echo '</tr>';  
echo '</thead>';

echo '<tbody>';
foreach ($genre as $c) {
  echo '<tr>';
  echo '<td>' . $c['idGenre'] . '</td>';
  echo '<td class="d-none d-md-table-cell">' . $c['Genre'] . '</td>';

  echo '<td><form action="admin.php" method="post">';
  echo '<input type="hidden" name="idGenre" value="'. $c['idGenre'] .'">';
  echo '<button class="btn btn-danger btn-sm" type="submit">Delete</button>';
  echo '</form></td>';

  echo '</tr>'; 
}
echo '</tbody>';
echo '</table>';
echo '</div>'






?>