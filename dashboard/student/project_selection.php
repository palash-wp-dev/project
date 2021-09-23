<?php 
  session_start();
  require_once "../../inc/classes.php";
  $project = new Project;
  $projectResult = $project -> projectList();
  $teacherNameList = $project -> teacherList();
  $stuId = $_SESSION['student_own_id'];
  $stuProject = $project -> studentSpecificProject($stuId);
  $afterProjectSelection = $project -> afterProjectSelection($stuId);

  $errNotice = [];

  if(isset($_POST['projectSelectSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $proTitle = $_POST['projectName'];
    

    $projectMemberNumber = $project -> projectMemberLimit($proTitle);
    
    if(empty($proTitle)){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Project title selection is required.</span>";
    }
    elseif (empty($proSupervisor)) {
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Supervisor selection is required.</span>";
    }
    
    elseif($projectMemberNumber == 4){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Can't select this project, all 4 member for this project is all ready fullfilled.</span>";
     
    }
    
    else {
      $proSupervisor = $_POST['projectSupervisor'];
      $proSupervisorNameEmail = explode(",", $proSupervisor);
      $proSupervisorName = $proSupervisorNameEmail[0];
      $proSupervisorEmail = $proSupervisorNameEmail[1];  


      
      $teacherProject = $project -> proSupervisorId($proSupervisorName,$proSupervisorEmail);
      $proSupervisorId = $teacherProject['id'];
      
      $project -> selectProject($stuId,$proTitle,$proSupervisorId);
      if($projectMemberNumber == 0){
        $project -> projectDetails($proTitle,$proSupervisorId,$stuId);
      }
      if($projectMemberNumber == 1){
        $project -> projectDetailsTwo($stuId,$proSupervisorId);
      }
      if($projectMemberNumber == 2){
        $project -> projectDetailsThree($stuId,$proSupervisorId);
      }
      if($projectMemberNumber == 3){
        $project -> projectDetailsFour($stuId,$proSupervisorId);
      }
      
      $errNotice[] = "<span class='alert alert-success' role='alert'>Project selection successfull!</span>";
      
    }
  }
  ?>

<?php require_once "navbar.php";?>
    <!-- Side Navbar -->
    <?php require_once "sidebar.php";?>
    <div class="page">
      <!-- navbar-->
    <?php require_once "header.php";?>
      <!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Project Selection       </li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>
      
 <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">

      <section>
        <div class="container-fluid">
          <!-- Page Header-->
          <?php if($afterProjectSelection == 1):?>
            <header> 
            <h1 class="h3 display">Project has been already selected!</h1>
          </header>
          <?php else:?>
           
          <header> 
            <h1 class="h3 display">Project Selection Details</h1>
          </header>
          <div class="row">
            
             

            
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h4>Select Project</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Title</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        
                          
                        <?php if($stuProject['title']):?>
                        <tr>
                         <th scope="row"><input type="radio" id="<?php echo $stuProject['title'];?>" name="projectName" value="<?php echo $stuProject['title'];?>" checked></th>
                          <td><label for="<?php echo $stuProject['title'];?>"><?php echo $stuProject['title'];?></label></td>
                          
                        </tr>
                        <?php else:?>
                          <tr>
                          <th scope="row"><input type="radio" name="projectName" checked="checked" value=""></th>
                          <td>No project selected</td>
                        </tr>
                          <?php foreach($projectResult as $pro):?>
                          <tr>
                          <th scope="row"><input type="radio" id="<?php echo $pro['title'];?>" name="projectName" value="<?php echo $pro['title'];?>"></th>
                          <td><label for="<?php echo $pro['title'];?>"> <?php echo $pro['title'];?></label></td>
                        </tr>
                        <?php endforeach;?>
                       <?php endif;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h4>Select Supervisor</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>email</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                         <tr>
                          <th scope="row"><input type="radio" name="projectSupervisor" value="" checked="checked"></th>
                          <td>Nothing selected</td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <?php foreach($teacherNameList as $teacherName):?>
                          <th scope="row"><input type="radio" id="<?php echo $teacherName['name'];?>" name="projectSupervisor" value="<?php echo $teacherName['name'];?>,<?php echo $teacherName['email'];?>"></th>
                          <td><label for="<?php echo $teacherName['name'];?>"> <?php echo $teacherName['name'];?></label></td>
                          <td><label for="<?php echo $teacherName['name'];?>"> <?php echo $teacherName['email'];?></label></td>
                          
                        </tr>
                        <?php endforeach;?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
               
            </div>

            <div class="col-lg-12"><input type="submit" name="projectSelectSubmit" value="Submit" class="btn btn-primary col-lg-12"><br><br></div>
          </div>
        <?php endif;?>
        </div>

      </section>
      
      
          </form>
          
      <?php require_once "footer.php";?>