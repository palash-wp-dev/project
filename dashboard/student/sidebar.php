<?php session_start();?>
<?php
  $stuId = $_SESSION['student_own_id'];
  if( empty( $_SESSION['student_own_id']) ){


    header("location: ../../index.php");
  }
  require_once "../../inc/classes.php";
  
  $project = new Project;
  $studentName = $project -> studentRegDetails1($stuId);
  $studentDetails = $project -> studentRegDetails2($stuId);
  $studentLeader = $project -> projectDetailsForTaskUpload($stuId);
  
 ?>
 <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="../../upload/studentphoto/<?php echo $studentDetails['photo'];?>" alt="No image set" class="img-fluid rounded-circle">
            <h2 class="h5"><?php echo $studentName['name'];?></h2><span><?php if(isset($studentLeader)){echo "Team Leader";} else{echo "Student";}?></span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="index.php"> <i class="icon-home"></i>Home                             </a></li>
            <li><a href="project_suggestion.php"> <i class="icon-form"></i>Suggest Project                             </a></li>
            
            <li><a href="project_selection.php"> <i class="icon-grid"></i>Project Selection                             </a></li>
            <li><a href="task.php"> <i class="icon-grid"></i>Task                             </a></li>
            <li><a href="project_upload.php"> <i class="icon-grid"></i>Project                             </a></li>
             <li><a href="profile.php"> <i class="icon-grid"></i>Profile                             </a></li>
            <li><a href="login.html"> <i class="icon-interface-windows"></i>Login page                             </a></li>
           
        </div>
        
      </div>
    </nav>