<?php
// pw is the password sent from the form 
$pw=$_POST['pw'];
 
// the stripslashes is included in case you end up sending this to a database. It's to help prevent hackers compromising your system.
$pw = stripslashes($pw);
 
// you can make this much more robust by checking against a database in this file at this point
 
if($pw == 'swordfish'){
//     session_register("pw"); 
    header("location: new_brew_form.php");
} else {
    header("location: index.php");
}
?>
