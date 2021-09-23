<?php 
  require_once "../../inc/classes.php";
	session_start();

  $project = new Project;

  $stuId = $_SESSION['student_own_id'];

  $result = $project -> projectSupervisor($stuId);

  $teacherId = $result['supervisor'];

  $result2 = $project -> noticeView($teacherId);


  
  foreach ($result2 as $notice) {
    echo "<li><a real='nofollow' href='#' class='dropdown-item'> <div class='notification d-flex justify-content-between'><div class='notification-content ajax'><i class='fa fa-upload'></i>Task Notice: ".$notice['notice']."</div><div class='notification-time'><small>4 minutes ago</small></div></div></a></li>";


    
   
    
  }
  
    


  
  
  

?>