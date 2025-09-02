

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


global $users;
include_once "../inc/databaseFunctions.php";

//run function to get all the users 
$users  = getAllUsers();


if(isset($_POST['email'])) {

    // Get email 
    $email = $_POST['email'];
  
    // Call relevant function
    if($_POST['form'] == 'promote_form') {
        
        //promote user with the email
        promoteUser($email);
        // Re-query
        $users = getAllUsers();
        echo " <img src='../../images/logo.png' width='114' height='67' alt='Logo'>";
        echo "<h4>User with email : $email promoted successfully!</h4>";
        
    } else if ($_POST['form'] == 'remove_admin_form') {
        
        //remove admin with the email
        removeAdmin($email);
        // Re-query
        $users = getAllUsers();
        echo " <img src='../../images/logo.png' width='114' height='67' alt='Logo'>";
        echo "<h4>Removing admin rights from user with email : $email</h4>";
    } else if ($_POST['form'] == 'remove_user_form') {
        
        //remove user with the email
        removeUser($email);
        // Re-query
        $users = getAllUsers();
        echo " <img src='../../images/logo.png' width='114' height='67' alt='Logo'>";
        echo "<h4>Removing user with email : $email</h4>";
    }
    
    unset($_POST);

}

echo '<div style="overflow-x:auto;">';
echo '<table class="table table-bordered table-hover">';
echo ' <tbody>';
echo ' <tr>';
echo ' <th scope="col" >Email</th>';
echo ' <th scope="col" class="d-none d-md-table-cell">First Name</th>';
echo ' <th scope="col" class="d-none d-md-table-cell">Last Name</th>';  
echo ' <th scope="col" class="d-none d-md-table-cell">Admin</th>'; 
echo ' <th scope="col" >Promote to Admin</th>';
echo ' <th scope="col" >Remove Admin</th>';
echo ' <th scope="col">Remove User</th>';
echo ' </tr>';
echo ' </tbody>';

echo '<tbody>';
foreach ($users as $user) {
    echo '<tr>';
    echo '<td >' . $user['email'] . '</td>';
    echo '<td class="d-none d-md-table-cell">' . $user['FirstName'] . '</td>';
    echo '<td class="d-none d-md-table-cell">' . $user['LastName'] . '</td>';
    if($user['admin'] == 1) {
        echo '<td class="d-none d-md-table-cell"><i class="fas fa-crown" style="color: gold;"></i></td>';
      } else {
        echo '<td class="d-none d-md-table-cell"><i class="fas fa-user" style="color: silver;"></i></td>';
    }
  
    // Show promote button if not admin
    if($user['admin'] == 0) {
        echo '<td><form name="promote_form"  method="post">';
        echo '<input type="hidden" name="email" value="'.$user['email'].'">';
        echo '<input type="hidden" name="form" value="promote_form">';
        echo '<button class="btn btn-dark btn-sm" type="submit">Promote</button>'; 
        echo '</form></td>';
    } else {
      echo '<td></td>';
    }
  
    // Show remove admin button if admin
    if($user['admin'] == 1) {
        echo '<td><form name="remove_admin_form"  method="post">';
        echo '<input type="hidden" name="email" value="'.$user['email'].'">';
        echo '<input type="hidden" name="form" value="remove_admin_form">';
        echo '<button class="btn btn-warning btn-sm" type="submit">Remove Admin</button>';
        echo '</form></td>';   
    } else {
      echo '<td></td>';
    }
  
    echo '<td><form name="remove_user_form"  method="post">';
    echo '<input type="hidden" name="email" value="'.$user['email'].'">';
    echo '<input type="hidden" name="form" value="remove_user_form">';
    echo '<button class="btn btn-danger btn-sm" type="submit">Remove</button>';
    echo '</form></td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';

?>
