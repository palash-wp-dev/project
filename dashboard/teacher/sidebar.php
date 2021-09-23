<?php session_start()?>
<?php 
  require_once "../../inc/classes.php";
  $teacherId = $_SESSION['teacher_unique_id'];

  if( empty( $_SESSION['teacher_unique_id']) ){


    header("location: ../../index.php");
  }
  $project = new Project;
  $data =  $project -> teacherProfileDetails($teacherId);
  $data2 =  $project -> teacherProfileDetails2($teacherId);

?>
<nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="../../upload/teacherphoto/<?php echo $data['photo'];?>" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5"><?php echo $data2['name'];?></h2><span><?php echo $data['designation']?></span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="index.php"> <i class="icon-home"></i>Home                             </a></li>
            <li><a href="project_suggestion.php"> <i class="icon-home"></i>Project Suggestion                             </a></li>
            <li><a href="leader_selection.php"> <i class="icon-home"></i>Leader Selection </a></li>
            <li><a href="profile.php"> <i class="icon-home"></i>Profile </a></li>
           
            <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Manage Project </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="give_task.php">Give Task</a></li>
                <li><a href="view_task.php">View Task</a></li>
                <li><a href="view_project.php">View Project</a></li>
              </ul>
            </li>
            <li><a href="login.html"> <i class="icon-interface-windows"></i>Login page                             </a></li>
            
          </ul>
        </div>
        
      </div>
    </nav>