<?php 
#!/usr/bin/php
//file where sql db functions are kept.
require "/var/www/html/includes/defs.php";
session_start();

// //Get the variables from the form
$type = htmlspecialchars($_POST['type']); 
$specG = floatval($_POST['specG']);
$hop = htmlspecialchars($_POST['hop']); 
$profile = htmlspecialchars($_POST['profile']); 
$desc = htmlspecialchars($_POST['desc']); 

// echo "Hi";

//get date
date_default_timezone_set("Australia/Brisbane");
$date_time = (new \DateTime())->format("Y-m-d H:i:s");
 
 
// //create new db name
$chars = array("-", ":", " ");
$date_time_nochars = str_replace($chars, "", $date_time);
$db_name = "temps_" . $date_time_nochars; 
 
// //Add them to the info db
add_brew_info($date_time, $type, $hop, $profile, $specG, $desc);

// echo $db_name;
//create new temps db
create_new_temps_db($db_name);

header("Location: index.php");
die();

?>