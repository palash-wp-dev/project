<?php 
  session_start();
  require_once "../../inc/classes.php";
  $project = new Project;
  $stuId = $_SESSION['student_own_id'];

  $errNotice = [];
  if(isset($_POST['projectSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
      
     $proFileName = $_FILES['projectFile']['name'];
     $proTmpName = $_FILES['projectFile']['tmp_name'];
     $projectFileSize = $_FILES['projectFile']['size'];
     $proFileType = array('txt','zip','ppt','pdf','docx');

     $proFileExplode = explode('.', $proFileName);
     $proFileExtension = strtolower(end($proFileExplode));
     $proFileUniqueName = md5($proFileName.time()).'.'.$proFileExtension;
    
     $phase = $_POST['phase'];

     if(empty($proFileName)){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a file.</span>";
     }
     if(empty($phase)){
     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a phase.</span>";
   }
     elseif ($projectFileSize > 8000000) {
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>File size should not be more than 1kb.</span>";
      
     }

     elseif(!in_array($proFileExtension,$proFileType )){
       $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>File type not valid.</span>";
     }
     else {
      $supervisorId = $project -> projectDetailsForTaskUpload($stuId);
      $superId = $supervisorId['supervisor'];
      $project -> projectUpload($proFileUniqueName,$stuId,$superId,$phase);
      move_uploaded_file($proTmpName, "../../upload/projectfile/".$proFileUniqueName); 
       $errNotice[] = "<span class='alert alert-success' role='alert'>File upload successfull!</span>";
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
            <li class="breadcrumb-item active">Project</li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Project            </h1>
          </header>
          <div class="row">
            
           
          
           
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Upload Project File</h4>
                </div>
                <div class="card-body">
                  
                    
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Upload Project</label>
                      <div class="col-sm-10">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
                        <input type="file" class="form-control" name="projectFile"><span class="text-small text-gray help-block-none">Please choose pdf, ppt, docs or zip file for upload.</span>
                      </div>
                    </div>
                   <div class="line"></div>
                   <div class="form-group row">
                      <div class="col-sm-2"> 
                        <label>Phase</label>
                      </div>
                      <div class="col-sm-10">

                        <label class="checkbox-inline" for="inlineCheckbox1">
                          <input name="phase" id="inlineCheckbox1" name="phase" type="radio" value="" checked="checked"> None
                        </label>
                        <label class="checkbox-inline" for="inlineCheckbox2">
                          <input id="inlineCheckbox2" name="phase" type="radio" value="1"> Phase 1
                        </label>
                        <label class="checkbox-inline" for="inlineCheckbox3">
                          <input id="inlineCheckbox3" name="phase" type="radio" value="2"> Phase 2
                        </label>
                        <label class="checkbox-inline" for="inlineCheckbox4">
                          <input id="inlineCheckbox4" name="phase" type="radio" value="3"> Phase 3
                        </label>
                      </div>
                      </div>
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <button type="submit" name="projectSubmit" class="btn btn-primary">Upload</button>
                      </form>
                      </div>
                    </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
     <?php require_once "footer.php";?>