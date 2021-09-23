<?php 
  session_start();
  require_once "../../inc/classes.php";
  $project = new Project;

  $errNotice = [];

  if(isset($_POST['nSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $teacherUnId = $_SESSION['teacher_unique_id'];
    $taskNotice = $_POST['taskNotice'];
    $teachName = $project -> teacherName($teacherUnId);
    $teaName = $teachName['name'];
    $projectName = $project -> projectTitle($teacherUnId);
    $proName = $projectName['title'];
    if(empty($taskNotice)){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Task field is required.</span>";
    }
    else{
      $taskNoticeSubmit = $project -> teacherTaskNotice($taskNotice,$proName,$teacherUnId,$teaName);
      $errNotice[] = "<span class='alert alert-success' role='alert'>Task notice published successfull!</span>";
    }

  }
?>


<?php require_once "navbar.php";?>
    <!-- Side Navbar -->
    <?php require_once "sidebar.php"?>
    <div class="page">
      <!-- navbar-->
      <?php require_once "header.php";?>
      <!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Give Task</li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>

      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Give Task</h1>
          </header>
          <div class="row">
            
           
          
           
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Give Task Of Your Project</h4>


                </div>
                <div class="card-body">
                  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                    
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Task</label>
                      <div class="col-sm-10">
                        <textarea id="w3review" name="taskNotice" class="form-control" rows="4" cols="50"></textarea>
                        <span class="text-small text-gray help-block-none">Give task for the students so that you can track their project progress.</span>
                      </div>
                    </div>
                   
                   
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <input type="submit" name="nSubmit" class="btn btn-primary" value="Submit">
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