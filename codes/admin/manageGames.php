

<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $games,$gameID;
include_once "../inc/databaseFunctions.php";
$games = getAllGames();
// Check for delete button
if(isset($_POST['deleteGame'])) {

    // Get game ID
    $gameID = $_POST['GameID'];
  
    // Call delete function
    removeGames($gameID);
  
  }

?>
<div class="table-responsive">
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>GameID</th>
      <th>Name</th>
      <th>Image</th>
      <th>Edit Game</th>
      <th>Remove Game</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($games as $game): ?>
    <tr>
      <td><?php echo $game['GameID']; ?></td>
      <td><?php echo $game['Name']; ?></td>
      <td><img src="<?php echo $game['ImagePath']; ?>" width="100" alt =" <?php $game['Name'] ?> "></td>
      <td>
        <?php
            echo '<form name="editGame" action="editGames.php" method="get">';
            echo '<input type="hidden" name="GameID" value="'.$game['GameID'].'">';
            echo '<button class="btn btn-warning btn-sm" type="submit">Edit Game</button>'; 
            echo '</form>'
        ?>
      </td>
      <td>
        <?php
            echo '<form action="admin.php" method="post">';
            echo '<input type="hidden" name="GameID" value="'.$game['GameID'].'">';
            echo '<button class="btn btn-danger btn-sm" type="submit">Delete Game</button>';
            echo '</form>'
        ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php

?>