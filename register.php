<?php
	require_once "inc/classes.php";
	$connection = new DatabaseConnection();	
		
	
	$errNotice = [];

	if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']=='POST'){

		$name = $_POST['name'];
		$id = $_POST['id'];
		$code = $_POST['code'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$pass_length = strlen($password);
		$uniq_password = md5($password);
		$category = $_POST['category'];
		
		
		
		$finalResult = $connection->regCodeValidation($id,$category);
		
		$teacherResultId = $connection->teacherIdValidation($id,$code);

		$studentResultId = $connection->studentIdValidation($id,$code);
		if(empty($name)){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Name is required.</span>";
		}
		elseif(empty($id)){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Id is required.</span>";
		}
		
		elseif(empty($email)){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Email is required.</span>";
		}
		elseif(empty($password)){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Password is required.</span>";
		}
		elseif(empty($code)){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Validation code is required.</span>";
		}
		
		elseif(empty($category)){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Category is required.</span>";
		}
		elseif (!preg_match("/^[0-9]*$/", $id)) {
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Only number is allowed.</span>";
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Invalid email format.</span>";
		}
		elseif($pass_length < 6){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Password lenght must be more than 5 characters.</span>";
		}
		elseif($pass_length > 12){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Password lenght must not be more than 12 characters.</span>";
		}
		elseif ($code!=$finalResult) {
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Validation code doesn't exits.</span>";
		}
		elseif ($id == $teacherResultId || $studentResultId) {
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>This id already exist.</span>";
		}
		
		
		else{
			$connection->test_input($id);
			$connection->test_input($email);
			$connection->test_input($password);
			$connection->test_input($code);
			if($category=="Teacher"){
				$connection -> teacherRegistration($id,$email,$uniq_password,$code,$name);
			}
			elseif($category=="Student"){
				$connection -> studentRegistration($id,$email,$uniq_password,$code,$name);
			}
			header( "refresh:2;url=http://localhost/project/index.php" );
 
			
			$errNotice[] = "<span class='alert alert-success' role='alert'>Registration successfull!</span>";
			
		}
	}


?>



<!DOCTYPE html>
<html>
<head>
	<title>Registration Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="container-fluid">

		<div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 2%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>

        <div class="row justify-content-center register">
            <div class="col-12 col-sm-6 col-md-3">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" class="form-container" method="post">
                    <h3> Register Here</h3>
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                      <input type="text" name="id" class="form-control" placeholder="Enter id">	
                      
                      </div>
                       <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="Enter email">	
                      
                      </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="code" placeholder="Enter validation code">
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
					<br>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <a href="account_reset.php" class="reset">Forgot password?</a>
                </form>
            </div>
        </div>
        
    </div>
	



	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>