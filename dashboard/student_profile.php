<?php 
	session_start();
	
	require_once "../inc/classes.php";
	$project = new Project;
	$projectResult = $project -> projectList();
	$teacherNameList = $project -> teacherList();
	$stuId = $_SESSION['student_own_id'];
	$stuProject = $project -> studentSpecificProject($stuId);
	
	
	if(isset($_POST['projectSuggestSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

		$title = $_POST['title'];
		$suggestedBy = "Student";
		$status = "Not completed";
		
		if(empty($title)){
			echo "Project suggestion can't be empty";
		}
		else{
			echo "Project title uploaded successfully";
			$project->projectSuggestedByStudent($title,$suggestedBy,$status);
		}
	}


	if(isset($_POST['projectSelectSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
		$proTitle = $_POST['projectName'];
		$proSupervisor = $_POST['projectSupervisor'];
		$proSupervisorNameEmail = explode(",", $proSupervisor);
		$proSupervisorName = $proSupervisorNameEmail[0];
		$proSupervisorEmail = $proSupervisorNameEmail[1];

		$projectMemberNumber = $project -> projectMemberLimit($proTitle);
		
		if(empty($proTitle)){
			echo "Project title can't be empty";
		}
		elseif (empty($proSupervisor)) {
			echo "Supervisor can't be empty";
		}
		
		elseif($projectMemberNumber == 4){
			echo "Can't select this project, all 4 member for this project is all ready fullfilled!";
		}
		
		else {
	
			echo "Project selection successfull";
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
			
			
			
		}
	}

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
		 	move_uploaded_file($fileTmpName, "../upload/taskfile/".$fileUniqueName);
		 	echo "File uploaded successfully";
		 }
	}

	
	if(isset($_POST['projectSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			
		 $proFileName = $_FILES['projectFile']['name'];
		 $proTmpName = $_FILES['projectFile']['tmp_name'];
		 $projectFileSize = $_FILES['projectFile']['size'];
		 $proFileType = array('txt','zip','ppt','pdf','docx');

		 $proFileExplode = explode('.', $proFileName);
		 $proFileExtension = strtolower(end($proFileExplode));
		 $proFileUniqueName = md5($proFileName.time()).'.'.$proFileExtension;
		
		 $phase = $_POST['phase'];

		 if(empty($proFileName)){
		 	echo "file upload can't be empty";
		 }
		 if(empty($phase)){
		 	echo "phase can't be empty";
		 }
		 elseif ($projectFileSize > 8000000) {
		 	echo "File size should not be more than 1kb";
		 }

		 elseif(!in_array($proFileExtension,$proFileType )){
		 	echo "File type not valid";
		 }
		 else {
		 	$supervisorId = $project -> projectDetailsForTaskUpload($stuId);
		 	$superId = $supervisorId['supervisor'];
		 	$project -> projectUpload($proFileUniqueName,$stuId,$superId,$phase);
		 	move_uploaded_file($proTmpName, "../upload/projectfile/".$proFileUniqueName);	
		 	echo "File uploaded successfully";
		 }
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Student Profile</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
	<h1>Hello: <?php echo $_SESSION['student_own_id'];?></h1>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
		<label for="title">Suggest Your Own Project:</label>
		<textarea id="title" name="title" rows="4" cols="50"></textarea>
		<input type="submit" name="projectSuggestSubmit" value="Submit">
	</form>
	

	<h1>Select project from the list</h1>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
		<input type="radio" name="projectName" checked="checked" value="">No project selected
		<br>
	<?php if($stuProject['title']):?>


		<input type="radio" id="<?php echo $stuProject['title'];?>" name="projectName" value="<?php echo $stuProject['title'];?>" checked>
		<label for="<?php echo $stuProject['title'];?>"><?php echo $stuProject['title'];?> </label><br>
	<?php else:?>

	
		<?php foreach($projectResult as $pro):?>
		<input type="radio" id="<?php echo $pro['title'];?>" name="projectName" value="<?php echo $pro['title'];?>">	
		<label for="<?php echo $pro['title'];?>"> <?php echo $pro['title'];?></label><br>
		<?php endforeach;?>
	<?php endif;?>

	<!-- <div class="alert alert-warning" role="alert">
	  <h4 class="alert-heading">Notice!</h4>
	  <hr>
	  <p class="mb-0"> Project suggested by particular teacher's are by deault project manager of that particular project. So you can't choose any other superviosor for those particular project by your own!</p>
	</div> -->
	
	<p>Select project supervisor for your own suggested project</p>
	<input type="radio" name="projectSupervisor" value="" checked="checked"> No supervisor selected
	<br>
	<?php foreach($teacherNameList as $teacherName):?>
	<input type="radio" id="<?php echo $teacherName['name'];?>" name="projectSupervisor" value="<?php echo $teacherName['name'];?>,<?php echo $teacherName['email'];?>">
	<label for="<?php echo $teacherName['name'];?>"> <?php echo $teacherName['name'];?> (<?php echo $teacherName['email'];?>)</label><br>
	<?php endforeach;?>
	<input type="submit" name="projectSelectSubmit" value="Submit">
	</form>
	<br>

	


	<span>Upload task: </span> 
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
		<input type="file" name="taskFile">
		<input type="submit" name="fileSubmit" value="Upload">
	</form>
	<br><br>
	<span>Upload Full Project: </span> 
	
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
		<input type="file" name="projectFile">

		<input type="radio" name="phase" value="" checked="checked"> None
		<input type="radio" id="1" name="phase" value="1">
		<label for="1">Phase 1</label>

		<input type="radio" id="2" name="phase" value="2">
		<label for="2">Phase 2</label>

		<input type="radio" id="3" name="phase" value="3">
		<label for="3">Phase 3</label>

		<input type="submit" name="projectSubmit" value="Upload">
	</form>


	<hr>
	<hr>
	<br>
	<h1>Setup profile</h1>
	<?php 
		if(isset($_POST['profileSubmit']) && $_SERVER['REQUEST_METHOD'] == "POST"){
			 $batch = $_POST['batch'];
			 $phone = $_POST['phone'];

			 
			 $photoName = $_FILES['photo']['name'];
			 $photoTmpName = $_FILES['photo']['tmp_name'];
			 $photoSize = $_FILES['photo']['size'];
			 $photoFileType = array('jpg','jpeg','png');

			 $photoFileExplode = explode('.', $photoName);
			 $photoFileExtension = strtolower(end($photoFileExplode));
			 $photoFileUniqueName = md5($photoName.time()).'.'.$photoFileExtension;
			if(empty($batch)){
				echo "Batch can't be empty";
			}
			elseif(empty($phone)){
				echo "Phone no can't be empty";
			}
			elseif(empty($photoName)){
				echo "Photo can't be empty";
			}
			elseif ($photoSize > 8000000) {
		 		echo "File size should not be more than 1kb";
			 }

			 elseif(!in_array($photoFileExtension,$photoFileType )){
			 	echo "File type not valid";
			 }
			else{
				$project -> studentProfileSetup($batch,$phone,$photoFileUniqueName,$stuId);
				move_uploaded_file($photoTmpName, "../upload/studentphoto/".$photoFileUniqueName);
				echo "Profile updated successfully";
			}

		}
	?>	
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
		<label>Batch</label>
		<input type="number" name="batch" placeholder="Batch">
		<label>Phone</label>
		<input type="text" name="phone" placeholder="Phone No">
		<label>Upload Photo</label>
		<input type="file" name="photo">
		<input type="submit" name="profileSubmit">
	</form>
</body>
</html>