<?php 
// header.php - called by the TLF website 
// to display header on each page - including nav bar
//
// (c) 2020, TLF
// Written by James Misa 
 //confirm_logged_in("userTime");
?>
    <div class="col-lg-12">
        <header class="clearfix">
            <div id="branding">
             
            </div><!--branding-->
            
            <?php if (logged_in()) {
    
                if($_SESSION['admin'] == 0) {
                  
                        echo '<nav class="navbar navbar-expand-md navbar-light bg-light">

                              <button type="button" 
                                    class="navbar-toggler"
                                    data-toggle="collapse"
                                    data-target="#collapsemenu"
                                    aria-controls="collapsemenu"
                                    aria-expanded="false"
                                    aria-label="Toggle Navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button><!--hamburgerbutton-->

                              <div class="collapse navbar-collapse" id="collapsemenu">
                                <ul class="navbar-nav nav-pills nav-justified">
                                    <li class="nav-item"><a href="seeds.php" class="nav-link"><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Seeds</a></li>
                                    <li class="nav-item"><a href="myTrees.php" class="nav-link"><img src="images/rsz_tree_of_life.png" style="width:3vw; height:3vw;"> Trees</a></li>
                                    <li class="nav-item"><a href="support.php" class="nav-link"><img src="images/family.png" style="width:3vw; height:3vw;"> Family</a></li>
                                    <li class="nav-item"><a href="water.php" class="nav-link"><img src="images/harvest.png" style="width:3vw; height:3vw;"> Harvest</a></li>
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/user2.png" style="width:3.5vw; height:3.5vw;"> ' . $_SESSION['first_name'] . '
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a href="user.php" class="nav-link"><i class="fas fa-info"></i> My Info</a>

                                    <a href="tools.php" class="nav-link"><i class="fas fa-lightbulb"></i> Documents</a>

                                    <a href="academy.php" class="nav-link""><i class="fas fa-graduation-cap"></i> Videos</a>

                                    </div>
                                    </li>
                                </ul><!--nav-->
                              </div><!--collapse-->

                        </nav>';

                    
                } else {
                        echo '<nav class="navbar navbar-expand-md navbar-light bg-light">

                              <button type="button" 
                                    class="navbar-toggler"
                                    data-toggle="collapse"
                                    data-target="#collapsemenu"
                                    aria-controls="collapsemenu"
                                    aria-expanded="false"
                                    aria-label="Toggle Navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button><!--hamburgerbutton-->

                              <div class="collapse navbar-collapse" id="collapsemenu">
                                <ul class="navbar-nav nav-pills nav-justified">
                                    <li class="nav-item"><a href="seeds.php" class="nav-link"><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Seeds</a></li>
                                    <li class="nav-item"><a href="myTrees.php" class="nav-link"><img src="images/rsz_tree_of_life.png" style="width:3vw; height:3vw;"> Trees</a></li>
                                    <li class="nav-item"><a href="support.php" class="nav-link"><img src="images/family.png" style="width:3vw; height:3vw;"> Family</a></li>
                                    <li class="nav-item"><a href="water.php" class="nav-link"><img src="images/harvest.png" style="width:3vw; height:3vw;"> Harvest</a></li>
                                    
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/user2.png" style="width:3.5vw; height:3.5vw;"> ' . $_SESSION['first_name'] . '
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a href="user.php" class="nav-link"><i class="fas fa-info"></i> My Info</a>

                                    <a href="tools.php" class="nav-link"><i class="fas fa-lightbulb"></i> Documents</a>

                                    <a href="academy.php" class="nav-link""><i class="fas fa-graduation-cap"></i> Videos</a>

                                    </div>
                                    </li>
                                    
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/admin.png" style="width:3vw; height:3vw;">
                                      Admin
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                      <a class="dropdown-item" href="admin_portal.php"><i class="fas fa-users-cog"></i> Portal</a>
                                    </div>
                                    </li>
                                </ul><!--nav-->
                              </div><!--collapse-->

                        </nav>';

                }
    /*
                if($_SESSION['admin'] == 1) {
                    echo '<nav class="navbar navbar-expand-md navbar-light bg-light">

                              <button type="button" 
                                    class="navbar-toggler"
                                    data-toggle="collapse"
                                    data-target="#collapsemenu"
                                    aria-controls="collapsemenu"
                                    aria-expanded="false"
                                    aria-label="Toggle Navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button><!--hamburgerbutton-->

                              <div class="collapse navbar-collapse" id="collapsemenu">
                                <ul class="navbar-nav nav-pills nav-justified">
                                    <li class="nav-item"><a href="seeds.php" class="nav-link"><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Seeds</a></li>
                                    <li class="nav-item"><a href="myflowers.php" class="nav-link"><img src="images/Tree of Life.png" style="width:3vw; height:3vw;"> Trees</a></li>
                                    <li class="nav-item"><a href="support.php" class="nav-link"><img src="images/family.png" style="width:3vw; height:3vw;"> Family</a></li>
                                    <li class="nav-item"><a href="water.php" class="nav-link"><img src="images/harvest.png" style="width:3vw; height:3vw;"> Harvest</a></li>
                                    
                                    <li class="nav-item"><a href="user.php" class="nav-link"><img src="images/user.png" style="width:3vw; height:3vw;"> ' . $_SESSION['first_name'] . '</a></li>
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/admin.png" style="width:3vw; height:3vw;">
                                      Admin
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                      <a class="dropdown-item" href="helpFlowers.php"><i class="fa fa-exclamation-triangle"></i> S.O.S</a>
                                      <a class="dropdown-item" href="admin_portal.php"><i class="fas fa-users-cog"></i> Portal</a>
                                      <a class="dropdown-item" href="status.php"><i class="fas fa-thermometer-half"></i> Status</a>
                                    </div>
                                    </li>
                                </ul><!--nav-->
                              </div><!--collapse-->

                        </nav>';
                } else {
                    if($_SESSION['seed'] == 1) {
                         echo '<nav class="navbar navbar-expand-md navbar-light bg-light">

                              <button type="button" 
                                    class="navbar-toggler"
                                    data-toggle="collapse"
                                    data-target="#collapsemenu"
                                    aria-controls="collapsemenu"
                                    aria-expanded="false"
                                    aria-label="Toggle Navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button><!--hamburgerbutton-->

                              <div class="collapse navbar-collapse" id="collapsemenu">
                                <ul class="navbar-nav nav-pills nav-justified">
                                    <li class="nav-item"><a href="seeds.php" class="nav-link"><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Seeds</a></li>
                                    <li class="nav-item"><a href="user.php" class="nav-link"><img src="images/user.png" style="width:3vw; height:3vw;"> ' . $_SESSION['first_name'] . '</a></li>
                                </ul><!--nav-->
                              </div><!--collapse-->

                        </nav>';
                    } else {
                        if($_SESSION['view'] == 1) {
                            echo '<nav class="navbar navbar-expand-md navbar-light bg-light">

                              <button type="button" 
                                    class="navbar-toggler"
                                    data-toggle="collapse"
                                    data-target="#collapsemenu"
                                    aria-controls="collapsemenu"
                                    aria-expanded="false"
                                    aria-label="Toggle Navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button><!--hamburgerbutton-->

                              <div class="collapse navbar-collapse" id="collapsemenu">
                                <ul class="navbar-nav nav-pills nav-justified">
                                    <li class="nav-item"><a href="seeds.php" class="nav-link"><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Seeds</a></li>
                                    <li class="nav-item"><a href="teneight.php" class="nav-link"><i class="fas fa-chess-board"></i> Boards</a></li>
                                    <li class="nav-item"><a href="user.php" class="nav-link"><img src="images/user.png" style="width:3vw; height:3vw;"> ' . $_SESSION['first_name'] . '</a></li>
                                </ul><!--nav-->
                              </div><!--collapse-->

                        </nav>';
                        } else {
                            echo '<nav class="navbar navbar-expand-md navbar-light bg-light">

                              <button type="button" 
                                    class="navbar-toggler"
                                    data-toggle="collapse"
                                    data-target="#collapsemenu"
                                    aria-controls="collapsemenu"
                                    aria-expanded="false"
                                    aria-label="Toggle Navigation">
                              <span class="navbar-toggler-icon"></span>
                              </button><!--hamburgerbutton-->

                              <div class="collapse navbar-collapse" id="collapsemenu">
                                <ul class="navbar-nav nav-pills nav-justified">
                                    <li class="nav-item"><a href="seeds.php" class="nav-link"><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Seeds</a></li>
                                    <li class="nav-item"><a href="myflowers.php" class="nav-link"><img src="images/Tree of Life.png" style="width:3vw; height:3vw;"></i> Trees</a></li>
                                    <li class="nav-item"><a href="support.php" class="nav-link"><img src="images/family.png" style="width:3vw; height:3vw;"> Family</a></li>
                                    <li class="nav-item"><a href="water.php" class="nav-link"><img src="images/harvest.png" style="width:3vw; height:3vw;"> Harvest</a></li>
                                    <li class="nav-item"><a href="user.php" class="nav-link"><img src="images/user.png" style="width:3vw; height:3vw;"> ' . $_SESSION['first_name'] . '</a></li>
                                </ul><!--nav-->
                              </div><!--collapse-->

                        </nav>';
                        }
                        
                    }
                }
                */
            } 
            
            
              if (!isset($_SESSION['fireDate'])) {
                  if(!isset($_SESSION['id'])) {
                      if(array_pop(explode("/", $_SERVER['REQUEST_URI'])) != 'redhat.php') {
                          include "login.php";
                      }
                  } 
              }


            //include "_/components/php/checkConnectivity.php"; 
            
            ?>
        </header><!--header-->
    </div><!--column-->
<script>
if(window.location.host != 'localhost') {
    if (window.location.protocol == 'http:') { 
      
    console.log("you are accessing us via "
        +  "an insecure protocol (HTTP). "
        + "Redirecting you to HTTPS."); 
          
    window.location.href =  
        window.location.href.replace( 
                   'http:', 'https:'); 
}  else if (window.location.protocol == "https:") { 
        console.log("you are accessing us via"
            + " our secure HTTPS protocol."); 
    } 
}


    
</script>