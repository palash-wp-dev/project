<?php 
  session_start();
  require_once "../../inc/classes.php";
  $project = new Project;
  $adminId  =  $_SESSION['admin_own_id'];
  
  $errNotice = [];

  if(isset($_POST['profileSubmit']) && $_SERVER['REQUEST_METHOD'] == "POST"){
       $name = $_POST['name'];
       $phone = $_POST['phone'];
       $position = $_POST['position'];     
       $emailData = $project -> adminEmail($adminId);
       $email = $emailData['email'];
       
       $photoName = $_FILES['photo']['name'];
       $photoTmpName = $_FILES['photo']['tmp_name'];
       $photoSize = $_FILES['photo']['size'];
       $photoFileType = array('jpg','jpeg','png');

       $photoFileExplode = explode('.', $photoName);
       $photoFileExtension = strtolower(end($photoFileExplode));
       $photoFileUniqueName = md5($photoName.time()).'.'.$photoFileExtension;
      if(empty($name)){
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Name can't be empty.</span>";
      }
      elseif(empty($phone)){
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Phone can't be empty.</span>";
      }
      elseif(empty($position)){
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Position can't be empty.</span>";
      }
      elseif(empty($photoName)){
       $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a photo.</span>";
      }
      elseif ($photoSize > 8000000) {
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>File size should not be more than 1kb.</span>";
       }

       elseif(!in_array($photoFileExtension,$photoFileType )){
        $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Invalid image format.</span>";
       }
      else{
        $project -> adminProfileSetup($name,$email,$adminId,$photoFileUniqueName,$position,$phone);
        move_uploaded_file($photoTmpName, "../../upload/adminphoto/".$photoFileUniqueName);
        $errNotice[] = "<span class='alert alert-success' role='alert'>Profile updated successfull!</span>";
      }

    }
 
  
?>

  <?php require_once "header.php";?>

    <!-- Side Navbar -->
    <?php require_once "sidebar.php"?>
    <div class="page">
      <!-- navbar-->
      <?php require_once "navbar.php";?>
      
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
                      <label class="col-sm-2 form-control-label">Name</label>
                      <div class="col-sm-10">
                        
                        <input type="text" name="name" class="form-control" placeholder="Enter Name">
                        
                        
                      </div>
                      <label class="col-sm-2 form-control-label">Phone</label>
                      <div class="col-sm-10">
                        
                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone No">
                        
                        
                      </div>
                      <label class="col-sm-2 form-control-label">Position</label>
                      <div class="col-sm-10">
                        
                      
                        <input type="text" name="position" class="form-control" placeholder="Enter Position">
                       
                      </div>
                      
                       
                      <label class="col-sm-2 form-control-label">Upload Photo</label>
                      <div class="col-sm-10">
                        
                      
                        <input type="file" name="photo" class="form-control">
                       
                      </div>

                      
                    </div>
                   
                   
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <input type="submit" name="profileSubmit" class="btn btn-primary" value="Update">
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