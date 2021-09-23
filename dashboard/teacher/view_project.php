<?php session_start();?>
<?php require_once "../../inc/classes.php";?>
<?php 
  $project = new Project;

     $errNotice = [];
 
    $teacherUnId = $_SESSION['teacher_unique_id'];
    // $taskLeader = $project -> taskLeader($teacherUnId);
    // $newLeader  = $taskLeader['leader'];
    

  if(isset($_POST['proSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

    $phase = $_POST['phase'];
    
    if(empty($phase)){
      $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please select a phase to see list.</span>";
    }
    else{
      
      $viewProject = $project -> viewProject($teacherUnId,$phase);
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
            <li class="breadcrumb-item active">View Project</li>
          </ul>
        </div>
      </div>

      <div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>

      <section>

         <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">View Project</h1>
          </header>
          <div class="row">
            
           
          
           
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Select Phase Of The Project</h4>


                </div>
                <div class="card-body">
                  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                    
                    <div class="line"></div>
                     <div class="form-group row">
                      <label class="col-sm-2 form-control-label">Select</label>
                      <div class="col-sm-10 mb-3">
                        <select name="phase" id="phase" class="form-control">
                          <option value="" checked="checked">None</option>
                          <option value="1">Phase 1</option>
                          <option value="2">Phase 2</option>
                          <option value="3">Phase 3</option>
                        </select>
                      </div>
                      
                    </div>
                   
                    
                   
                  
                    <div class="line"></div>
                    <div class="form-group row">
                      <div class="col-sm-4 offset-sm-2">
                        <input type="submit" name="proSubmit" class="btn btn-primary" value="Search">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>



        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">View Project</h1>
          </header>
          <div class="row">
            
           
    
       
     <br>
    



  
    
            
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Download the task file from the list below</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover">
                      <thead>

                        <tr>
                          <th>#</th>
                          
                          <th>Project File</th>
                          <th>Phase</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <?php $count = 1;?>
                        <?php if(isset($viewProject)):?>
                        <?php foreach($viewProject as $newProject):?>
                        

                          <th scope="row"><?php  echo $count; ++$count;?></th>
                         
                          



                          <td><a href="../../upload/projectfile/<?php echo $newProject['file']?>" download>Download Project</a></td>
                          <td><?php echo $newProject['phase']?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php if(empty($newProject)):?>

                          <tr>                                        

                          <th scope="row"></th>                     
               
                          <td>No Data Found</td>
                          <td></td>
                        </tr>
                        <?php endif;?>
                         <?php else:?>
                          <tr>                                        

                          <th scope="row"></th>                     
               
                          <td>None</td>
                          <td>No Phase Selected</td>
                        </tr>
                        <?php endif;?>
                       
                      </tbody>
                    </table>
                     
                   
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </section>
      <?php require_once "footer.php";?>