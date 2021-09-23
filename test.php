<!-- <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: "Lato", sans-serif;}
.navbar {
  overflow: hidden;
  background-color: #111;
  position: fixed;
  top: 0;
  left: 250px;
  width: 100%;
}

.navbar a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 16px 16px;
  text-decoration: none;
  font-size: 17px;
}
.navbar a:nth-child(1) {
  margin-left: 60%;
}

.navbar a:hover {
  background: #ddd;
  color: black;
}

.sidebar {
  height: 100%;
  width: 250px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 16px;
}

.sidebar a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
}

.sidebar a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 250px; /* Same as the width of the sidenav */
  padding: 0px 10px;
  margin-top: 60px;
}
.sidenav a, .dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}
.active {
  background-color: green;
  color: white;
}
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 8px;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}
.chain {
  display: none;
}
.show {
  display: block;
}
.hide {
  display: none;
}
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>
</head>
<body>
  <div class="navbar">

  <a href="#home">Home</a>
  <a href="#news">News</a>
  <a href="#contact">Contact</a>
</div>

<div class="sidebar">
  <a href="#home"><i class="fa fa-fw fa-home"></i> Home</a>
  <a href="#services"><i class="fa fa-fw fa-wrench"></i> Code Validation</a>  
   <button class="dropdown-btn"><i class="fa fa-fw fa-user"></i> Admin
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="#">Link 1</a>
    <a href="#">Link 2</a>
    <a href="#">Link 3</a>
  </div>
  <a class="contact" href="#contact"><i class="fa fa-fw fa-envelope"></i> Contact</a>
</div>

<div class="main">
  <div class="brain">
    <h2>Sidebar with Icons</h2>
    <p>This side navigation is of full height (100%) and always shown.</p>
    <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
    <p>Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>
  </div>

  <div class="chain">
  lorem ipsum <br>  ami ipsum <br>  lorem ipsum <br>  lorem ipsum <br>  lorem ipsum <br>
  lorem ipsum <br>  lorem ipsum <br>  lorem ipsum 
  lorem ipsum 
  lorem ipsum 
  lorem ipsum 
  lorem ipsum 
  lorem ipsum 
  lorem ipsum 
  lorem ipsum 
</div>
</div>







<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  this.classList.toggle("active");
  var dropdownContent = this.nextElementSibling;
  if (dropdownContent.style.display === "block") {
  dropdownContent.style.display = "none";
  } else {
  dropdownContent.style.display = "block";
  }
  });
}




  

</script>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
 <script src="jquery.js"></script>  
</body>
</html>  -->





<?php 
  session_start();
  
  require_once "../../inc/classes.php";
  $project = new Project;
  $stuId = $_SESSION['student_own_id'];
  // $result = $project -> projectDetailsForTaskUpload($stuId);
  // $errNotice = [];

  // if(isset($_POST['fileSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
  //    $fileName = $_FILES['taskFile']['name'];
  //    $fileTmpName = $_FILES['taskFile']['tmp_name'];
  //    $fileSize = $_FILES['taskFile']['size'];
  //    $fileType = array('txt','zip','ppt','pdf','docx');

  //    $fileExplode = explode('.', $fileName);
  //    $fileExtension = strtolower(end($fileExplode));
  //    $fileUniqueName = md5($fileName.time()).'.'.$fileExtension;


  //    if(empty($fileName)){
  //     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a file.</span>";
  //    }
  //    elseif($stuId == $result['leader']){
  //     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Only leader can upload file.</span>";
  //    }
  //    elseif(!in_array($fileExtension,$fileType )){
  //     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>File type not valid.</span>";
  //    }
     
  //    elseif ($fileSize > 8000000) {
  //     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>File size should not be more than 1kb.</span>";
      
  //    }
  //    else{
      
  //     $superId = $result['supervisor'];
  //     $project ->taskUpload($fileUniqueName,$stuId,$superId);
  //     move_uploaded_file($fileTmpName, "../upload/taskfile/".$fileUniqueName);
  //     $errNotice[] = "<span class='alert alert-success' role='alert'>File upload successfull!</span>";
  //    }
  // }

if(isset($_POST['fileSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
     $fileName = $_FILES['taskFile']['name'];
     $fileTmpName = $_FILES['taskFile']['tmp_name'];
     $fileSize = $_FILES['taskFile']['size'];
     $fileType = array('txt','zip','ppt','pdf','docx');

     $fileExplode = explode('.', $fileName);
     $fileExtension = strtolower(end($fileExplode));
     $fileUniqueName = md5($fileName.time()).'.'.$fileExtension;


     if(empty($fileName)){
      echo "File can't be empty";
     }
     elseif(!in_array($fileExtension,$fileType )){
      echo "File type not valid";
     }
     
     elseif ($fileSize > 8000000) {
      echo "File size should not be more than 1kb";
     }
     else{
      $supervisorId = $project -> projectDetailsForTaskUpload($stuId);
      $superId = $supervisorId['supervisor'];
      $project ->taskUpload($fileUniqueName,$stuId,$superId);
      move_uploaded_file($fileTmpName, "../../upload/taskfile/".$fileUniqueName);
      echo "File uploaded successfully";
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
            <li class="breadcrumb-item active">Upload Task</li>
          </ul>
        </div>
      </div>

      <!-- <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div> -->

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
                  <form class="form-horizontal">
                    
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Upload Task</label>
                      <div class="col-sm-10">
                        <!-- <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
                        <input type="file" class="form-control" name="taskFile"><span class="text-small text-gray help-block-none">Please choose pdf, ppt, docs or zip file for upload.</span>
                      </div>
                    </div>
                   
                   
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <button type="submit" name="fileSubmit" class="btn btn-primary">Upload</button>
                      </form> -->

                     
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