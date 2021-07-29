
<!DOCTYPE html>

<html dir="ltr" lang="en-US">

<head>



    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <meta name="author" content="SemiColonWeb" />



    <!-- Stylesheets

    ============================================= -->

    <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700|Roboto:300,400,500,700&display=swap" rel="stylesheet" type="text/css" />-->

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />

    <link rel="stylesheet" href="assets/style.css" type="text/css" />



    <!-- One Page Module Specific Stylesheet -->

    <link rel="stylesheet" href="assets/one-page/onepage.css" type="text/css" />

    <!-- / -->



    <link rel="stylesheet" href="assets/css/dark.css" type="text/css" />

    <link rel="stylesheet" href="assets/css/font-icons.css" type="text/css" />

    <link rel="stylesheet" href="assets/one-page/css/et-line.css" type="text/css" />

    <link rel="stylesheet" href="assets/css/animate.css" type="text/css" />

    <link rel="stylesheet" href="assets/css/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="assets/one-page/css/fonts.css" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/custom.css" type="text/css" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="OrgChartJS/orgchart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://kit.fontawesome.com/7b30bafaf6.js" crossorigin="anonymous"></script>

     <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>  


  <title><?php echo $title;?></title>



</head>



<body class="stretched" data-loader="11" data-loader-color="#543456">



  <!-- Document Wrapper

  ============================================= -->

  <div id="wrapper" class="clearfix">



    <!-- Header

    ============================================= -->

    <header id="header" class="full-header transparent-header border-full-header header-size-custom " style="width: 100%">

      <div id="header-wrap">

        <div class="container">

          <div class="header-row">



            <!-- Logo

            ============================================= -->

          
                        <div id="logo"> 

                            <a href="#" class="standard-logo" data-dark-logo="assets/one-page/images/The Eden Project.jpg"><img src="assets/one-page/images/tree_logo.jpg" alt="Logo"></a>

                            <a href="#" class="retina-logo" data-dark-logo="assets/one-page/images/The Eden Project.jpg"><img src="assets/one-page/images/tree_logo.jpg" alt="Canvas Logo" style="z-index: 999 "></a>

                        </div><!-- #logo end -->



            <div id="primary-menu-trigger">

              <svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>

            </div>


    <!-- =======    Primary Navigation   =========== -->

            <nav class="primary-menu">
              <ul class="one-page-menu menu-container" data-easing="easeInOutExpo" data-speed="1250" data-offset="65">
            
                <li class="menu-item">
                  <!-- <a href="index.html" id="Nav_menu4" class=" login  button button-mini button-circle">MEMBER LOGOUT</a> -->
                  <?php 
                    if(isset($_SESSION['tlf_id'])){
                  ?>
                  <a id="Nav_menu4" href="logout.php" class="button login button-border button-rounded button-fill fill-from-bottom button-black">
                    <span >MEMBER LOGOUT</span></a>
                  <?php } ?> 
                </li>

              </ul>



            </nav><!-- #primary-menu end -->



          </div>

        </div>

      </div>

      <div class="header-wrap-clone"></div>

    </header><!-- #header end -->


    <!-- Page Sub Menu

    ============================================= -->

    <div id="page-menu">

      <div id="page-menu-wrap">

        <div class="container">

          <div class="page-menu-row">



            <div class="page-menu-title"> <span><?php $userName = ""; if(isset($_SESSION['first_name'])){ echo 'Hello ' .$userName =  $_SESSION['first_name'] ; } else { $userName ;}?></span></div>

            <?php if (logged_in()) {
    
                if($_SESSION['admin'] == 0) {

           echo '<nav class="page-menu-nav">

              <ul class="page-menu-container">

                <li class="page-menu-item current"><a href="seeds.php">Seeds</a></li>

                <li class="page-menu-item active"><a href="myTrees.php">Trees</a></li>

                <li class="page-menu-item"><a href="support.php">Family</a></li>
                                
                <li class="page-menu-item "><a href="water.php">Harvest</a></li>

                
                <li class="page-menu-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">'.$userName.' </a>

                <ul class="dropdown-menu " role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -162px, 0px);">

                <a class="dropdown-item" href="user.php">
                  <i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;&nbsp;My Profile</a>
                                
                <a class="dropdown-item" href="tools.php"><i class="fa fa-file-text"></i>&nbsp;&nbsp;Document</a>
                
                <a class="dropdown-item" href="academy.php"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;Videos</a>
              
                </ul>
                </li>
                <li class="page-menu-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Admin</a>

                <ul class="dropdown-menu " role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -162px, 0px);">

                <a class="dropdown-item" href="admin_portal.php">
                  <i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;&nbsp;Admin Portal</a>
                                
                <a class="dropdown-item" href="admin.php"><i class="fa fa-file-text"></i>&nbsp;&nbsp;Flip Message</a>
                
                
              
                </ul>
                </li>
              </ul>
            </nav>';

             } else {
                        echo '<nav class="page-menu-nav">

              <ul class="page-menu-container">

                <li class="page-menu-item current"><a href="seeds.php"><div>Seeds</div></a></li>

                <li class="page-menu-item "><a href="myTrees.php"><div>Trees</div></a></li>

                <li class="page-menu-item"><a href="support.php"><div>Family</div></a></li>
                                
                <li class="page-menu-item "><a href="water.php"><div>Harvest</div></a></li>

                
                <li class="page-menu-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">' .$userName .'</a>

                <ul class="dropdown-menu " role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -162px, 0px);">

                <a class="dropdown-item" href="user.php">
                  <i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;&nbsp;My Profile</a>
                                
                <a class="dropdown-item" href="tools.php"><i class="fa fa-file-text"></i>&nbsp;&nbsp;Document</a>
                
                <a class="dropdown-item" href="academy.php"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;Videos</a>
              
                </ul>
                </li>
                <li class="page-menu-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Admin</a>

                <ul class="dropdown-menu " role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -162px, 0px);">

                <a class="dropdown-item" href="admin_portal.php">
                  <i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;&nbsp;Admin Portal</a>
                                
                <a class="dropdown-item" href="admin.php"><i class="fa fa-file-text"></i>&nbsp;&nbsp;Flip Message</a>
                
                
              
                </ul>
                </li>
               
              </ul>
            </nav>';

                }
                } 
            
            
              if (!isset($_SESSION['fireDate'])) {
                  if(!isset($_SESSION['id'])) {
                      if(array_pop(explode("/", $_SERVER['REQUEST_URI'])) != 'redhat.php') {
                          include "login.php";
                      }
                  } 
              }


            
            
            ?>
            <div id="page-menu-trigger"><i class="icon-reorder"></i></div>
          </div>
        </div>
      </div>
    </div><!-- #page-menu end -->
