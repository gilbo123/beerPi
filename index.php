<!-- ******PHP****** -->  
<?php 
#!/usr/bin/php
//file where sql db functions are kept.
require "/var/www/html/includes/defs.php";
//get the current brew info
$brew_info = get_brew_info();

// echo $brew_info[7];
//1 indicates current brew
if($brew_info[7] == 1){
    //Construct db name
    $chars = array("-", ":", " ");
    $date_time_nochars = str_replace($chars, "", $brew_info[1]);
    $db = "temps_" . $date_time_nochars;
    
    //
    //-->Get temps
    //
    // Execute the python script to get the temperatures
    $result = exec("sudo python /var/www/html/python/get_temps.py");

    // This will contain: string with temps
//     var_dump($result);
    $temp_amb = substr($result, 1, 4);
    $pos = strpos($result, ", ");
    $pos2 = strpos($result, ", ", $pos+1);
    $temp_liq = substr($result, $pos2+2, 4);

    date_default_timezone_set("Australia/Brisbane");
    $date_time = (new \DateTime())->format("Y-m-d H:i:s");

    //Add to db
    add_temps($db, $date_time, $temp_amb, $temp_liq);

    //
    //-->Turn on/off Compressor
    //
    // Execute the python script check the temps and turn on/off compressor
    $result2 = exec("sudo python /var/www/html/python/check_temps.py $temp_amb $temp_liq");
    
}else{
    //user was not passed, so print a error or just exit(0);
}

//
//-->Get the temps from db to display in graph
//
//

?>



<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head>
    <title>BeerPi</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML5 Website landing Page for Developers">
    <meta name="author" content="3rd Wave Media">  
    <!--<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">  -->
    <link rel="shortcut icon" href="favicon.ico">  
    <link href="https://fonts.googleapis.com/css?family=Barrio|Indie+Flower" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'> 
    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">   
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.css">
    <!-- github acitivity css -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/octicons/2.0.2/octicons.min.css">
<!--     <link rel="stylesheet" href="http://caseyscarborough.github.io/github-activity/github-activity-0.1.0.min.css"> -->
    
    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head> 

<body>
    <!-- ******HEADER****** --> 
    <header class="header">
        <div class="container">                       
            <img class="profile-image img-responsive pull-left" src="assets/images/images.jpeg" alt="Beer" />
            <div class="profile-content pull-left">
                <h1 class="name">BeerPi</h1>
                <h2 class="desc">Beer fermentation controller</h2>
                <h2 class="author">Designed by Gilbert Eaton</h2>     
            </div><!--//profile-->
        </div><!--//container-->
    </header><!--//header-->
    
    <div class="container sections-wrapper">
        <div class="row">
            <div class="primary col-md-8 col-sm-12 col-xs-12">
            
                <!-- ******DETAILS****** -->
                <section class="about section">
                    <div class="section-inner" style="height: 340px;">
                        <h2 class="heading">Current Brew:</h2>
                        <div class="content1">
                            <h3 class="title">Beer Type: </h3>
                            <h3 class="title">Hops: </h3>
                            <h3 class="title">Specific gravity: </h3>
                            <h3 class="title">Temperature profile: </h3>
                        </div><!--//content1-->
                        <div class="content2">
                            <h3 class="result"><?php echo $brew_info[2];?></h3>
                            <h3 class="result"><?php echo $brew_info[3];?></h3>
                            <h3 class="result"><?php echo $brew_info[5];?></h3>
                            <h3 class="result"><?php echo $brew_info[4];?></h3>
                        </div><!--//content2-->
                    </div><!--//section-inner-->                 
                </section><!--//section-->

                  
                <!-- ******STATS****** -->    
                <section class="projects section">
                    <div class="section-inner">
                        <h2 class="heading">Statistics</h2>
                        <div class="content">
                            <div class="item">
                                <h3 class="title"><a href="#">Current Temperatures:</a></h3>
                                <p class="summary"><?php 
                                                        echo "Ambient: " .$temp_amb; 
                                                    ?>
                                </p>
                                <p class="summary"><?php 
                                                        echo "Liquid: " .$temp_liq; 
                                                    ?>
                                </p>
                            </div><!--//item-->
                            
                            <div class="item">
                            </div><!--//item-->
                            <div class="item">
                            </div><!--//item-->
                                                        
                        </div><!--//content-->  
                    </div><!--//section-inner-->                 
                </section><!--//section-->
                
                <!-- ******GRAPHS****** -->
                <section class="about section">
                    <div class="section-inner">
                        <h2 class="heading">Graphs</h2>
                        <div class="content">
                            <!-- Graphs go here-->

                            <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                         
                        </div><!--//content-->
                    </div><!--//section-inner-->                 
                </section><!--//section-->
                
                <!-- ******ABOUT****** -->
                <section class="about section">
                    <div class="section-inner">
                        <h2 class="heading">About</h2>
                        <div class="content">
                            <p>This Raspberry Pi-controlled fermentation controller (BeerPi) was created and developed by Gilbert Eaton. 
                            It uses two temperature sensors, one in the liquid beer and one in ambient refrigerator air. The program uses 
                            these two measurements to control the refrigerator's compressor and, therefore, the internal temperature.</p>
                            
                            <p>In most cases, the best fermentation results are achieved when the temperature is 20 degrees Celcius. 
                            The fermentation will last for 5 days and then the system changes the temperature to be chilled (4-5 degrees Celcius).<p/>
                            
                            <p>A later version may implement other more complex temperature patterns such as Pilsner which requires a change 
                            of temperature part way through the fermentation process.</p>
                         
                        </div><!--//content-->
                    </div><!--//section-inner-->                 
                </section><!--//section-->
                
            </div><!--//primary-->
            
            
            <div class="secondary col-md-4 col-sm-12 col-xs-12">
                 <aside class="info aside section">
                    <div class="section-inner">
                        <h2 class="heading sr-only">Controls</h2>
                        <div class="content">
                            <a class="btn btn-cta-secondary" href="#">View Details <i class="fa fa-chevron-right"></i></a> 
                            <p></p>
                            <a class="btn btn-cta-secondary" href="login.php">Reset Brew <i class="fa fa-chevron-right"></i></a> 
                        </div><!--//content-->  
                    </div><!--//section-inner-->                 
                </aside><!--//aside-->
                
                <aside class="skills aside section">
                    <div class="section-inner">
                        <h2 class="heading">Progress</h2>
                        <div class="content">
                            <p class="intro">
                                Progress Bars to visualise time of brew and efficiencies.</p>
                            
                            <div class="skillset">
                               
                                <div class="item">
                                    <h3 class="level-title">Compressor Efficiancy<span class="level-label" data-toggle="tooltip" data-placement="left" data-animation="true" title="You can use the tooltip to add more info...">Expert</span></h3>
                                    <div class="level-bar">
                                        <div class="level-bar-inner" data-level="96%">
                                        </div>                                      
                                    </div><!--//level-bar-->                                 
                                </div><!--//item-->
                                
                                <div class="item">
                                    <h3 class="level-title">Ferment Time<span class="level-label">Expert</span></h3>
                                    <div class="level-bar">
                                        <div class="level-bar-inner" data-level="96%">
                                        </div>                                      
                                    </div><!--//level-bar-->                                 
                                </div><!--//item-->
                                
                                <div class="item">
                                    <h3 class="level-title">Systems on Line<span class="level-label">Expert</span></h3>
                                    <div class="level-bar">
                                        <div class="level-bar-inner" data-level="96%">
                                        </div>                                      
                                    </div><!--//level-bar-->                                 
                                </div><!--//item-->                                
                            </div><!--//skillset-->           
                        </div><!--//content-->  
                    </div><!--//section-inner-->                 
                </aside><!--//section-->
              
            </div><!--//secondary-->    
        </div><!--//row-->
    </div><!--//masonry-->
    
    <!-- ******FOOTER****** --> 
    <footer class="footer">
        <div class="container text-center">
                <small class="copyright">Designed by <a href="http://gilberteaton.com" target="_blank">Gilbert Eaton</a></small>
        </div><!--//container-->
    </footer><!--//footer-->
 
    <!-- Javascript -->        
    <script type="text/javascript" src="assets/plugins/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>    
    <script type="text/javascript" src="assets/plugins/jquery-rss/dist/jquery.rss.min.js"></script> 
    <!-- github activity plugin -->
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js"></script>
<!--     <script type="text/javascript" src="http://caseyscarborough.github.io/github-activity/github-activity-0.1.0.min.js"></script> -->
    <!-- custom js -->
    <script type="text/javascript" src="assets/js/main.js"></script>  
    <script type="text/javascript" src="assets/js/min/canvasjs.min.js"></script>  
    

    <script type="text/javascript">
        window.onload = function () {
            $.getJSON("data.php", function (result) {
                var chart = new CanvasJS.Chart("chartContainer", {
                    title: {
				        text: "Line Chart"
			        },
			        // axisX: {
// 				        interval: 10
// 			        },
                    data: [{
                                type: "line",
                                dataPoints: result
                            }]
                    });
                chart.render();
            });
        };
    </script>  
      
</body>
</html> 