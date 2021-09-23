
<?php
	session_start();
	require_once "../inc/classes.php";
	$studentLogin = new DatabaseConnection;

	$errNotice = [];

	if(isset($_POST['sSubmit']) && $_SERVER['REQUEST_METHOD']=='POST'){
		$s_id = $_POST['sId'];
		$s_email = $_POST['sEmail'];
		$s_password = $_POST['sPassword'];
		$s_encrypted_password = md5($s_password);
		$loginResult = $studentLogin -> studentLogin($s_id,$s_email,$s_encrypted_password);
		if(empty($s_id) ){
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Id is required.</span>";
		}
		elseif (empty($s_email)) {
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Email is required.</span>";
		}
		elseif (empty($s_password)) {
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Password is required.</span>";
		}
		elseif (!filter_var($s_email, FILTER_VALIDATE_EMAIL)) {
		 $errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Invalid email format</span>";
		}
		
		elseif ($s_id != $loginResult['id'] || $s_email != $loginResult['email'] || $s_encrypted_password != $loginResult['password']) {
			$errNotice[] = "<span class='alert alert-danger alert-dismissible' role='alert'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Wrong credentials.</span>";
			
		}
		else{
			$_SESSION['student_own_id'] = $s_id;
			header( "refresh:1;url=http://localhost/project/dashboard/student" );
			$errNotice[] = "<span class='alert alert-success' role='alert'>Login successful!</span>";
			
		}
	}

	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Login Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
	
	

	<div class="notice col-sm-6" style=" position: absolute;left: 41%; top: 12%;"><p><?php if($errNotice){echo $errNotice[0];}?></p></div>


	<div class=" container-fluid ">
        <div class="row justify-content-center ">
            <div class="col-12 col-sm-6 col-md-3">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" class="form-container" method="post">
                    <h3> Login Here</h3>
                    <div class="form-group">
                      <input type="text" name="sId" class="form-control" placeholder="Enter id">	
                      
                      </div>
                       <div class="form-group">
                      <input type="email" name="sEmail" class="form-control" placeholder="Enter email">	
                      
                      </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="sPassword" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="sSubmit" value="Login">Submit</button>
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
