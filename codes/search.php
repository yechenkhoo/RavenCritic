<?php
include_once "inc/databaseFunctions.php";

$searchFormMarkup = '<form action="search_results.php" method="get">';
$searchFormMarkup .= '<input type="text" name="query" placeholder="Search for a game...">';
$searchFormMarkup .= '<input type="submit" value="Search">';
$searchFormMarkup .= '</form>';

echo $searchFormMarkup;

?>
