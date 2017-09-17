<?php
/* file with functions to open connection to mysql using 'mysql.php' containing
*  username and passwords. also contains the 'showerror' function.
*/

//file where the login details are kept.
require '/var/www/html/includes/mysql.php';


// showerror function will show MySQL error when called and displays a User-friendly 
//description of the error.
function showerror() {
  die("Error " . mysql_error());
  echo "Error with Database or connection please check settings and Internet connection.";
}

// mysql_open function will open MySQL connection and select database
function mysql_open() {
  $connection = mysql_connect(HOST, USER, PASSWORD) or die("Could not connect");
  mysql_select_db(DATABASE, $connection) or showerror();
  return $connection;
}

?>