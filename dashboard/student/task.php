<?php 

  session_start();

  if( empty( $_SESSION['student_own_id']) ){


    header("location: ../../index.php");
  }
  
  require_once "../../inc/classes.php";
  $project = new Project;
  $stuId = $_SESSION['student_own_id'];

   $result = $project -> projectDetailsForTaskUpload($stuId);
   $errNotice = [];

  if(isset($_POST['fileSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
     $fileName = $_FILES['taskFile']['name'];
     $fileTmpName = $_FILES['taskFile']['tmp_name'];
     $fileSize = $_FILES['taskFile']['size'];
     $fileType = array('txt','zip','ppt','pdf','docx');

     $fileExplode = explode('.', $fileName);
     $fileExtension = strtolower(end($fileExplode));
     $fileUniqueName = md5($fileName.time()).'.'.$fileExtension;


     if(empty($fileName)){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a file.</span>";
     }
     elseif($stuId != $result['leader']){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Only leader can upload file.</span>";
     }
     elseif(!in_array($fileExtension,$fileType )){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>File type not valid.</span>";
     }
     
     elseif ($fileSize > 8000000) {
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>File size should not be more than 1kb.</span>";
      
     }
     else{
      
      $superId = $result['supervisor'];
      $project ->taskUpload($fileUniqueName,$stuId,$superId);
      move_uploaded_file($fileTmpName, "../../upload/taskfile/".$fileUniqueName);
      $errNotice[] = "<span class='alert alert-success' role='alert'>File upload successfull!</span>";
     }
  }

?>

<?php require_once "navbar.php";?>
    <!-- Side Navbar -->
<?php
  
  
  $studentName = $project -> studentRegDetails1($stuId);
  $studentDetails = $project -> studentRegDetails2($stuId);
  $studentLeader = $project -> projectDetailsForTaskUpload($stuId);
  
 ?>
 <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="../../upload/studentphoto/<?php echo $studentDetails['photo'];?>" alt="No image found" class="img-fluid rounded-circle">
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
    <div class="page">
      <!-- navbar-->
      <?php require_once "header.php";?>

      <!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Upload Task</li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>

      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Upload Task</h1>
          </header>
          <div class="row">
            
           
          
           
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Upload Any Task For Your Teacher</h4>
                </div>
                <div class="card-body">
                 
                    
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Upload Task</label>
                      <div class="col-sm-10">
                       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
                        <input type="file" class="form-control" name="taskFile"><span class="text-small text-gray help-block-none">Please choose pdf, ppt, docs or zip file for upload.</span>
                      </div>
                    </div>
                   
                   
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <button type="submit" name="fileSubmit" class="btn btn-primary">Upload</button>
                      

                     
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
     <?php require_once "footer.php";?>