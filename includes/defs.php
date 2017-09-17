<?php
/*
 * Function definitions for MyAuction actions.
 */
 
require '/var/www/html/includes/db_defs.php'; 
 
//**************************** mySQL functions ************************// 

/* Adds a new image to the db excluding the .txt file  */
function add_temps($db, $date_time, $amb_temp, $liq_temp) {
	
	// open the connection to the database.
	$connection = mysql_open();
					
	//all the values can be loaded into the Item data.			
	$query = "insert into ".$db."(date_time, temp_amb, temp_liq)
				values ('$date_time', '$amb_temp', '$liq_temp')";
	
	//use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
    
    //echo 'opened';
    //close the database connection and return the id so that the Item details can be 
    //displayed.
    mysql_close($connection) or showerror();
    
    //commit and rollback to prevent clashing queries
    if ($results){
    	$result = mysql_query("commit", $connection); 
    }else{
      	$result = mysql_query("rollback", $connection);
	}
}

function add_brew_info($date_time, $type, $hop, $profile, $specG, $desc){

    // open the connection to the database.
	$connection = mysql_open();
	
	//first, change the old current brew and change the flag to 0
	$query = "update current_brew set is_current = 0 where is_current = 1";
	
	//use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
					
	//all the values can be loaded into the Item data.			
	$query = "insert into current_brew(date_time, is_current, type, hops, profile, specG, description)
				values ('$date_time', '1', '$type', '$hop', '$profile', '$specG', '$desc')";
	
	//use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
    
    //echo 'opened';
    //close the database connection and return the id so that the Item details can be 
    //displayed.
    mysql_close($connection) or showerror();
    
    //commit and rollback to prevent clashing queries
    if ($results){
    	$result = mysql_query("commit", $connection); 
    }else{
      	$result = mysql_query("rollback", $connection);
	}
}


function create_new_temps_db($db_name){
    
    // open the connection to the database.
	$connection = mysql_open();
		
	//all the values can be loaded into the Item data.			
	$query = "CREATE TABLE ".$db_name." (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                    date_time TIMESTAMP,
                                    temp_amb FLOAT,
                                    temp_liq FLOAT,
                                    compressor_value INT(6)
                                    )";
	
	//use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
    
    //echo 'opened';
    //close the database connection and return the id so that the Item details can be 
    //displayed.
    mysql_close($connection) or showerror();
    
    //commit and rollback to prevent clashing queries
    if ($results){
    	$result = mysql_query("commit", $connection); 
    }else{
      	$result = mysql_query("rollback", $connection);
	}

}


function get_brew_info(){

    // open the connection to the database.
	$connection = mysql_open();
		
	//all the values can be loaded into the Item data.			
	$query = "select * from current_brew where is_current = 1";
	
	//use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
    
//     echo 'opened';
    //close the database connection
    mysql_close($connection) or showerror();
	return mysql_fetch_row($results);
}


function get_json_data($db){

    // open the connection to the database.
	$connection = mysql_open();

	//all the values can be loaded into the Item data.			
	$query = "select * from ".$db." where 1";
    
    //use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
	    
	$data_points = array();
        
    while($row = mysql_fetch_array($results))
    {        
        $point = array("label" => $row['date_time'] , "y" => $row['temp_liq']);
        
        array_push($data_points, $point);        
    }
    mysql_close($connection) or showerror();
    
    return json_encode($data_points, JSON_NUMERIC_CHECK);
}









/*
##################################OLD METHODS####################################
*/

/* checks if the image already exists  */
function image_exits($image_file) {
	
	// open the connection to the database.
	$connection = mysql_open();
					
	//all the values can be loaded into the Item data.			
	$query = "select image_id from leaf_images where image_name = '$image_file'";
	
	//use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
    mysql_close($connection) or showerror();
    $row = mysql_fetch_array($results);
    return is_numeric($row[0]);
}

/* gets an array of images  */
function get_images() {

	// open the connection to the database.
	$connection = mysql_open();
					
	//all the values can be loaded into the Item data.			
	$query = "select image_name, image from leaf_images where image_name like 'images/leaf100/t6/t%.jpg' order by image_id";
	
	//use the msql command to search using query and connection
	$results = mysql_query($query,$connection) or showerror();
	
	//Create an array and and put the items in it.
    $images = array();
    while ($image = mysql_fetch_assoc($results)) {
        $images[] = $image;
        //echo $image['image'];
   	}
	
	//print out the JSON values
	/*echo "[";
    foreach($images as $image_name){
    	print(json_encode($image_name));
    	echo ",";
    }
    echo "]";*/
    
    //echo sizeof($images);
    
	mysql_close($connection) or showerror();
	
	foreach($images as $key=>$value){
    	$newArrData[$key] =  $images[$key];
    	$newArrData[$key]['image'] = base64_encode($images[$key]['image']);
	}
	header('Content-type: application/json');
	echo json_encode($newArrData);
}

/* gets an image  */
function get_image($image) {

	// open the connection to the database.
	$connection = mysql_open();
					
	//all the values can be loaded into the Item data.			
	$query = "select image_name, image from leaf_images where image_name = '$image'";
	
	//use the msql command to search using query and connection
	$result = mysql_query($query,$connection) or showerror();
	
	$image = mysql_fetch_assoc($result);
	
	mysql_close($connection) or showerror();
	
    $newArrData['image_name'] = $image['image_name'];
    $newArrData['image'] = base64_encode($image['image']);
	return json_encode($newArrData);
}

//******************************* Functions **************************************//

/*gets the image attributes to add to the db*/
function get_image_attributes($image_file){
	
	$file_maxsize = 1000000; //~1MB
	
	//check the image size and get its attributes
    if($_FILES['$image_file']['size'] < $file_maxsize){
        //image type
    	$image_type = addslashes($_FILES['$image_file']['type']);
        // image blob
        $image =addslashes(file_get_contents($image_file));//($_FILES['$image_file']['tmp_name']));
        // image size
        $image_size = getimagesize($image_file);
        //image catagory
        $image_ctgy = 'leaf';
        //image name
        $image_name = $image_file;
         
        //take out the image file name and change the "/" to "_" 
        //so that it can be matched to the text file
        $string = $image_file;
        $startpoint = strrpos($string, "t");
        $endpoint = strlen($string);
		$newString = substr($string, $startpoint, ($endpoint - $startpoint));
		echo $newString;
		echo ' --> ';
				
		$intString = str_replace('/', '_', $newString);
		$finalString = str_replace('jpg', 'txt', $intString);
		echo $finalString;
				
        //check if the .txt file matches the image file and add it to the txt field in the db
        foreach($image_text_files as $image_text_file){
          	$txt_string = $image_text_file;
          	$txt_startpoint = (strrpos($txt_string, "_")+1);
          	$txt_endpoint = strlen($txt_string);
			$txt_newString = substr($txt_string, $txt_startpoint, ($txt_endpoint - $txt_startpoint));
					
			//if they match read the txt file
          	if(strcmp($txt_newString, $finalString) == 0){
 				$fp = fopen($image_text_file, 'r');
 				//image text - the .txt file containing the base64 string.
  				$image_text = fread($fp, filesize($image_text_file));
  				fclose($fp);
  			}
  		}
          		
        //add the full details for each entry
        add_image($image_type,$image,$image_size,$image_ctgy,$image_name, $image_text);
        echo 'Entered!';
		echo "<br>";
	}
}

function get_classnames($folder){
	//get the classnames to match to the images
	//match the string to the folder number
	$str = $folder;
	$spoint = strrpos($str, "t") +1;
	$epoint = strlen($str);
	$nString = substr($str, $spoint, ($epoint - $spoint));
	
	//open the classnames file and find the classname matching image folder
 	$file_lines = file("match/leaf100database/classnames");
 	foreach($file_lines as $file_line){
 		//echo $file_line;
 		list($folder_number, $scientific_name, $common_name) = explode(";", $file_line);
 		if(strcmp($folder_number,$nString) == 0){
 			//echo "Scientific name: ".$scientific_name."<br>";
 			//echo "Common name: ".$common_name;
 			return array($scientific_name, $common_name);
 		}
 	}	
}