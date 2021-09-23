<?php 
  session_start();
  require_once "../../inc/classes.php";
  $obj = new DatabaseConnection;
  
  $project =  new Project;
  
  
  $errNotice = [];
  $random_code = "";  
  if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    
  $id = $_POST['id'];
  $category = $_POST['category']; 
  $time = time();
  
  $result = $project -> validationDuplicate($id);

    if (empty($id)) {
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Id is required.</span>";
    } 
    elseif (empty($category)) {
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Radio button is required.</span>";
    } 
    elseif ($result == 1) {
          $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Validation code for this id already exists.</span>";
        }    

    else {
      $random_code = md5($time);
      $obj -> authenticationCode($id,$random_code,$category);
      $errNotice[] = "<span class='alert alert-success alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Verificaton code created for student id (".$id."),  please copy the code.</span>";  
    }
      
    
  }







  

  // random verification code update
  
  $updateRandomCode = ""; 
  if (isset($_POST['newSubmit']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    
  $updateId = $_POST['updateId'];
  $updateCategory = $_POST['updateCategory'];
  $updateTime = time();
  


    if (empty($updateId)) {
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Updatde Id is required.</span>";
    } 
    elseif (empty($updateCategory)) {
     $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Update radio button is required.</span>";
    } 
    

    else {
      $updateRandomCode = md5($updateTime); 
      $obj -> authenticationCodeUpdate($updateId,$updateRandomCode,$updateCategory);
      $errNotice[] = "<span class='alert alert-success alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</aVerificaton code updated for id (".$updateId."), "."for (".$updateCategory."), please copy the code.</span>";  
    }
      
    
  }
?>

<?php require_once "header.php";?>
    <!-- Side Navbar -->
    <?php require_once "sidebar.php";?>
    
     
    
    <div class="page">
      <!-- navbar-->
      <?php require_once "navbar.php"?>
      
      <!-- Breadcrumb-->
      <div class="notice col-sm-6" style=" position: absolute;left: 30%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Validation</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Validation Code</h1>
          </header>
          <div class="row">
           
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Generate Code</h4>
                </div>
                <div class="card-body">
                  <p>Generate validation code for register</p>
                  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                    <div class="form-group row">
                      <div class="col-sm-2"> 
                        <label>Id</label>
                      </div>
                      <div class="col-sm-10">
                        <input name="id" id="inputHorizontalSuccess" type="text" placeholder="Enter Id" class="form-control form-control-success"><small class="form-text">Enter id for creating validation code.</small>
                      </div>
                    </div>
                   
                    
                    <div class="form-group row">
                      <div class="col-sm-2"> 
                        <label>Category</label>
                      </div>
                      <div class="col-sm-10">
                        <label class="checkbox-inline" for="inlineCheckbox1">
                          <input id="inlineCheckbox1" name="category" type="radio" value="" checked="checked"> None
                        </label>
                        <label class="checkbox-inline" for="inlineCheckbox2">
                          <input id="inlineCheckbox2" name="category" type="radio" value="Teacher"> Teacher
                        </label>
                        <label class="checkbox-inline" for="inlineCheckbox3">
                          <input id="inlineCheckbox3" name="category" type="radio" value="Student"> Student
                        </label>
                      </div>
                      </div>
                      
                    <div class="form-group row">       
                      <div class="col-sm-10 offset-sm-2">
                        <input type="submit" value="Generate" name="submit" class="btn btn-primary">
                      </div>
                    </div>
                  </form>
                  <div class="form-group row">
                        <div class="col-sm-2"> 
                         <label>Copy Code</label>
                        </div>

                          <div class="input-group col-sm-10">
                            <input type="text" class="form-control" id="myInput" value="<?php echo $random_code;?>">
                            <div class="input-group-append">
                              <button class="btn btn-primary" onclick="myFunction()">Copy!</button>
                            </div>

                          </div>
                          <div class="notinuse col-sm-2"></div>
                          <small class="form-text col-sm-10">Copy and send this validation code via sms or email.</small>
                        </div>
                </div>
              </div>
            </div>
            <!-- update code -->

             <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Update Code</h4>
                </div>
                <div class="card-body">
                  <p>Update validation code for register</p>
                  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <div class="form-group row">
                      <div class="col-sm-2"> 
                        <label>Id</label>
                      </div>
                      <div class="col-sm-10">
                        <input id="inputHorizontalSuccess" type="text" name="updateId" placeholder="Enter Id" class="form-control form-control-success"><small class="form-text">Enter id for creating validation code.</small>
                      </div>
                    </div>
                   
                    
                    <div class="form-group row">
                      <div class="col-sm-2"> 
                        <label>Category</label>
                      </div>
                      <div class="col-sm-10">
                        <label class="checkbox-inline" for="inlineCheckbox11">
                          <input id="inlineCheckbox11" name="updateCategory" type="radio" value="" checked="checked"> None
                        </label>
                        <label class="checkbox-inline" for="inlineCheckbox22">
                          <input id="inlineCheckbox22" name="updateCategory" type="radio" value="Teacher"> Teacher
                        </label>
                        <label class="checkbox-inline" for="inlineCheckbox33">
                          <input id="inlineCheckbox33" name="updateCategory" type="radio" value="Student"> Student
                        </label>
                      </div>
                      </div>
                      
                    <div class="form-group row">       
                      <div class="col-sm-10 offset-sm-2">
                        <input type="submit" name="newSubmit" value="Generate" class="btn btn-primary">
                      </div>
                    </div>
                  </form>
                  <div class="form-group row">
                        <div class="col-sm-2"> 
                         <label>Copy Code</label>
                        </div>

                          <div class="input-group col-sm-10">
                            <input id="myNewInput" type="text" class="form-control" value="<?php echo $updateRandomCode;?>">
                            <div class="input-group-append">
                              <button onclick="myNewFunction()" class="btn btn-primary">Copy!</button>
                            </div>

                          </div>
                          <div class="notinuse col-sm-2"></div>
                          <small class="form-text col-sm-10">Copy and send this validation code via sms or email.</small>
                        </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </section>

      
    


      <?php require_once "footer.php";?>