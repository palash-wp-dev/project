<?php session_start();?>
<?php require_once "../../inc/classes.php";?>
<?php 
  $project = new Project;
  $teacherUnId = $_SESSION['teacher_unique_id'];
  $projectMemberId = $project -> teamLeader($teacherUnId);

  $errNotice = [];

  if(isset($_POST['lSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
      $leader = $_POST['leader'];
    if(empty($leader)){
       $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a student for leadership.</span>";
    }
    else{
      
      $leaderSelection = $project -> selectLeader($leader,$teacherUnId);
       $errNotice[] = "<span class='alert alert-success' role='alert'>Leader selection successfull!</span>";
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
            <li class="breadcrumb-item active">Leader Selection</li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 15%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>

      <section>
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Select Leader</h1>
          </header>
          <div class="row">
            
           
    
       
     <br>
    


    
            
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Student List</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          
                          <th>Id No</th>
                          <th>Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                           <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                          <th scope="row"><input type="radio" name="leader" value="" id="none" checked="checked"></th>
                          <td><label for="none">None</label></td>
                          <td><label for="none">None</label></td>
                         </tr>
                         <tr> 
                          <?php foreach($projectMemberId as $proMemberId):?>
                          <th scope="row"><input type="radio" id="<?php echo $proMemberId['studentid'];?>" name="leader" value="<?php echo $proMemberId['studentid'];?>"></th>
                         
                          <td> <label for="<?php echo $proMemberId['studentid'];?>"> <?php echo $proMemberId['studentid'];?></label></td>



                          <td><label for="<?php echo $proMemberId['studentid'];?>"> 
                            <?php $proMemberId['studentid'];  $projectMemberName = $project -> teamMemberName($proMemberId['studentid']);  foreach($projectMemberName as $proMemberName){ echo $proMemberName['name'];}?></label></td>
                        </tr>
                       <?php endforeach;?>
                       
                      </tbody>
                    </table>
                      <input type="submit" name="lSubmit" value="Select" class="btn btn-primary">
                   </form>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </section>
      <?php require_once "footer.php";?>