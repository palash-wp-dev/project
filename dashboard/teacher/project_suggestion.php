<?php 
  session_start();
  require_once "../../inc/classes.php";
  $project = new Project;
  $teacherUnId = $_SESSION['teacher_unique_id'];

  $errNotice = [];

  if(isset($_POST['pSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $suggestedBy = "Teacher";
    $status = "Not completed";
    $titleCount = $project-> titleDuplicate($title);
    if(empty($title)){
     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Project title is required.</span>";
    }
    elseif ($titleCount == 1) {
     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>This project has already been suggested.</span>";
    }
    else {
     
      $project->projectSuggestedByTeacher($title,$suggestedBy,$status,$teacherUnId);

      $errNotice[] = "<span class='alert alert-success alert-dismissible' role='alert'>Project title submitted successfull!</span>";

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
            <li class="breadcrumb-item active">Project Suggestion</li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>


      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Project Suggestion</h1>
          </header>
          <div class="row">
            
           
          
           
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Suggest Any Project</h4>

                </div>
                <div class="card-body">
                  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                    
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Suggest Project</label>
                      <div class="col-sm-10">
                        <textarea id="w3review" name="title" class="form-control" rows="4" cols="50"></textarea>
                        <span class="text-small text-gray help-block-none">Type the title of the project name that you want to suggest for the students.</span>
                      </div>
                    </div>
                   
                   
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <input type="submit" name="pSubmit" class="btn btn-primary" value="Submit">
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


    