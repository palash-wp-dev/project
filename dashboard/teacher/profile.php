<?php 
  session_start();
  require_once "../../inc/classes.php";
   $project = new Project;
   $teacherUnId = $_SESSION['teacher_unique_id'];

   $errNotice = [];

  if(isset($_POST['profileSubmit']) && $_SERVER['REQUEST_METHOD'] == "POST"){
       $designation = $_POST['designation'];
       $phone = $_POST['phone'];

       
       $photoName = $_FILES['photo']['name'];
       $photoTmpName = $_FILES['photo']['tmp_name'];
       $photoSize = $_FILES['photo']['size'];
       $photoFileType = array('jpg','jpeg','png');

       $photoFileExplode = explode('.', $photoName);
       $photoFileExtension = strtolower(end($photoFileExplode));
       $photoFileUniqueName = md5($photoName.time()).'.'.$photoFileExtension;
      if(empty($designation)){
       $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Designation field can't be empty.</span>";
      }
      elseif(empty($phone)){
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Phone can't be empty.</span>";
      }
      elseif(empty($photoName)){
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a photo.</span>";
      }
      elseif ($photoSize > 8000000) {
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Image size should not be more than 1kb.</span>";
        
       }

       elseif(!in_array($photoFileExtension,$photoFileType )){
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Invalid image type.</span>";
       }
      else{
        $project -> teacherProfileSetup($designation,$phone,$photoFileUniqueName,$teacherUnId);
        move_uploaded_file($photoTmpName, "../../upload/teacherphoto/".$photoFileUniqueName);
        $errNotice[] = "<span class='alert alert-success' role='alert'>Profile update successfull!</span>";
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
            <li class="breadcrumb-item active">Profile</li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>

      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Profile Details</h1>
          </header>
          <div class="row">
            
           
          
           
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Setup your profile</h4>


                </div>
                <div class="card-body">
                  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Desgnation</label>
                      <div class="col-sm-10">
                        
                        <input type="text" name="designation" class="form-control" placeholder="Enter Designation">
                        
                        
                      </div>
                      <label class="col-sm-2 form-control-label">Phone</label>
                      <div class="col-sm-10">
                        
                      
                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone No">
                       
                      </div>

                      <label class="col-sm-2 form-control-label">Upload Photo</label>
                      <div class="col-sm-10">
                        
                      
                        <input type="file" name="photo" class="form-control">
                       
                      </div>
                    </div>
                   
                   
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <input type="submit" name="profileSubmit" class="btn btn-primary" value="Submit">
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