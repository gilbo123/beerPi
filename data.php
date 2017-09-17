<?php
header('Content-Type: application/json');
//file where sql db functions are kept.
require "/var/www/html/includes/defs.php";


//get the current brew
$info = get_brew_info();

// echo $info[1];

//create new db name
$chars = array("-", ":", " ");
$date_time_nochars = str_replace($chars, "", $info[1]);
$db = "temps_" . $date_time_nochars;


echo get_json_data($db);



?>