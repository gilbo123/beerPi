<!-- ******PHP****** -->  
<?php 
#!/usr/bin/php
//
//-->Get the temps from db to display in graph
//
// E
?>



<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head>
    <title>BeerPi Information</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML5 Website landing Page for Developers">
    <meta name="author" content="3rd Wave Media">  
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">  
    <link rel="shortcut icon" href="favicon.ico">  
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'> 
    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">   
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.css">
    <!-- github acitivity css -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/octicons/2.0.2/octicons.min.css">
    <link rel="stylesheet" href="http://caseyscarborough.github.io/github-activity/github-activity-0.1.0.min.css">
    
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
                <section class="about section">
                    <div class="section-inner">
                        <h2 class="heading">Beer Information</h2>
                        <div class="content"> 
                            <form action="action.php" method="post">
                                <p>Brew Type: <input type="text" name="type" /></p>
                                <p>Hop Flavour: <input type="text" name="hop" /></p>
                                <p>Specific Gravity: <input type="number" step="any" name="specG" /></p>
                                <p>Temperature Profile: <input type="text" name="profile" /></p>
                                <p>Description: <textarea id="txtArea" rows="10" cols="70" name="desc"> </textarea></p>
                                <p><input type="submit" /></p>
                            </form>
                        </div><!--//content-->
                    </div><!--//section-inner-->                 
                </section><!--//section-->
            </div><!--//primary-->
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
    <script type="text/javascript" src="http://caseyscarborough.github.io/github-activity/github-activity-0.1.0.min.js"></script>
    <!-- custom js -->
    <script type="text/javascript" src="assets/js/main.js"></script>            
</body>
</html> 

