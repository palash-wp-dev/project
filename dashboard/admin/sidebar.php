<?php 
  require_once "../../inc/classes.php";

      $project = new Project;
      $adminId  =  $_SESSION['admin_own_id'];
    
      $data = $project -> adminProfileDetails($adminId);
     

  if( empty( $_SESSION['admin_own_id']) ){


    header("location: ../../index.php");
  }

?>
<nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="../../upload/adminphoto/<?php echo $data['photo'];?>" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5"><?php echo $data['name'];?></h2><span><?php echo $data['position'];?></span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="index.php"> <i class="icon-home"></i>Home                             </a></li>
            <li><a href="validation.php"> <i class="icon-form"></i>Validation Code                             </a></li>
           
            <li> <a href="profile.php"> <i class="icon-mail"></i>Profile
                </a></li>
          </ul>
        </div>
        
      </div>
    </nav>