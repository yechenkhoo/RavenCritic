<?php
require_once 'Zebra_Session.php';
require_once "databaseFunctions.php";


$session = new Zebra_Session($conn, 'W49q43zqBsks');
global $session;


function LoginSession($fname = null, $lname , $email, $admin){
    global $session;
    if (!empty($fname)){
        $_SESSION['name'] = $fname . " ". $lname;
        $_SESSION['email'] = $email;
    }else{
        $_SESSION['name'] = $lname;
        $_SESSION['email'] = $email;
    }

    $_SESSION["logged_in"] = 1;
    $_SESSION["admin"] = $admin;
}


function RetrieveMoreInfo(){
    global $session;
    return $_SESSION['name'];
    if (isset($_SESSION['name'])){
        return $_SESSION;
    }else{
        return "TEST";
    }
}

function StopSession(){
    global $session;
    $session->stop();
}
?>

