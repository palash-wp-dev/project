<?php 
	session_start();
	require_once "../inc/classes.php";
	$obj = new DatabaseConnection;
	
	$random_code = "";	
	if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {

		
	$id = $_POST['id'];
	$category = $_POST['category'];	
	$time = time();
	$random_code = md5($time);

	  if (empty($id)) {
	    echo "Id is required";
	  } 
	  elseif (empty($category)) {
	    echo "Radio button must be checked.";
	  } 
	  

	  else {
	  	$obj -> authenticationCode($id,$random_code,$category);
		echo "Verificaton code created for id (".$id."), "."for (".$category."), please copy the code.";	
	  }
	    
	  
	}







	

	// random verification code update
	
	$updateRandomCode = "";	
	if (isset($_POST['newSubmit']) && $_SERVER["REQUEST_METHOD"] == "POST") {

		
	$updateId = $_POST['updateId'];
	$updateCategory = $_POST['updateCategory'];
	$updateTime = time();
	$updateRandomCode = md5($updateTime);	


	  if (empty($updateId)) {
	    echo "Id is required";
	  } 
	  elseif (empty($updateCategory)) {
	    echo "Radio button must be checked";
	  } 
	  

	  else {
	  	$obj -> authenticationCodeUpdate($updateId,$updateRandomCode,$updateCategory);
		echo "Verificaton code updated for id (".$updateId."), "."for (".$updateCategory."), please copy the code.";	
	  }
	    
	  
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Admin Section</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
	

	<div class="navbar navbar-dark bg-primary">

  <a href="#home">Home</a>
  <a href="#news">News</a>
  <a href="#contact">Contact</a>
</div>

<div class="sidebar">
  <a href="#home"><i class="fa fa-fw fa-home"></i> Welcome: <?php echo $_SESSION['admin_own_id']?></a>
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
 


	<div class=" container-fluid ">
        <div class="row justify-content-center ">
            <div class="col-12 col-sm-6 col-md-3">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" class="form-container" method="post">
                    <div class="form-group">
                      <input type="text" name="id" class="form-control" placeholder="Enter id">	
                      
                      </div>
                       <div class="form-check-inline">
	                    <input type="radio" class="form-check-input" name="category" value="" id="none" checked="checked">
	                    <label for="none">None</label>
                    </div>
                    <div class="form-check-inline">
	                    <input type="radio" class="form-check-input" name="category" value="Teacher" id="teacher">
	                    <label for="teacher">Teacher</label>
                    </div>
                    <div class="form-check-inline">
						<input type="radio" class="form-check-input" name="category" value="Student" id="student">
						<label for="student">Student</label> 
					</div>
                
                    <button type="submit" class="btn btn-primary" name="submit">Generate Code</button>
                    
                </form>
            </div>
        </div>
        
    </div>




	<br>

	<input type="text" id="myInput" value="<?php echo $random_code; ?>">
	<button onclick="myFunction()">Copy</button>

	<br>
	<br>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div class="form-group">
                      <input type="text" name="updateId" class="form-control" placeholder="Enter id">	
                      
                      </div>
                       <div class="form-check-inline">
	                    <input type="radio" class="form-check-input" name="updateCategory" value="" id="none" checked="checked">
	                    <label for="none">None</label>
                    </div>
                    <div class="form-check-inline">
	                    <input type="radio" class="form-check-input" name="updateCategory" value="Teacher" id="teacher">
	                    <label for="teacher">Teacher</label>
                    </div>
                    <div class="form-check-inline">
						<input type="radio" class="form-check-input" name="updateCategory" value="Student" id="student">
						<label for="student">Student</label> 
					</div>
                
                    <button type="submit" class="btn btn-primary" name="newSubmit">Generate Code</button>
			
	</form>

	<br>

	<input type="text" id="myNewInput" value="<?php echo $updateRandomCode;?>">
	<button onclick="myNewFunction()">Copy</button>

	<br>
</div>
</div>




	

	<script>
		function myFunction() {
		  var copyText = document.getElementById("myInput");
		  copyText.select();
		  copyText.setSelectionRange(0, 99999)
		  document.execCommand("copy");
		  alert("Copied the text: " + copyText.value);
		}


		function myNewFunction() {
		  var copyText = document.getElementById("myNewInput");
		  copyText.select();
		  copyText.setSelectionRange(0, 99999)
		  document.execCommand("copy");
		  alert("Copied the text: " + copyText.value);
		}
	</script>	
	
</body>
</html>






