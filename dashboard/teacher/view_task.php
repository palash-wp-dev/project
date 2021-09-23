<?php session_start();?>
<?php require_once "../../inc/classes.php";?>
<?php 
  $project = new Project;
 

    $teacherUnId = $_SESSION['teacher_unique_id'];
    $taskLeader = $project -> taskLeader($teacherUnId);
    $newLeader  = $taskLeader['leader'];
    $taskResult = $project -> viewTask($newLeader);

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
            <li class="breadcrumb-item active">View Task</li>
          </ul>
        </div>
      </div>
      <section>
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">View Task</h1>
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
                          
                          <th>Task File</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <?php $count = 1;?>
                         <?php foreach($taskResult as $newTaskResult):?>

                          <th scope="row"><?php  echo $count; ++$count;?></th>
                         
                          



                          <td><a href=" ../../upload/taskfile/<?php echo $newTaskResult['taskfile'];?>" download>Download Task</a></td>
                        </tr>
                        <?php endforeach;?>

                       
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