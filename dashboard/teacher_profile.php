<?php 
	session_start();
	require_once "../inc/classes.php";
	$project = new Project;
	if(isset($_POST['pSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
		$title = $_POST['title'];
		$suggestedBy = "Teacher";
		$status = "Not completed";
		$project->projectSuggestedByTeacher($title,$suggestedBy,$status,$teacherUnId);
	}

	 $teacherUnId = $_SESSION['teacher_unique_id'];
  	 $projectMemberId = $project -> teamLeader($teacherUnId);

	if(isset($_POST['nSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
		$taskNotice = $_POST['taskNotice'];
		$teachName = $project -> teacherName($teacherUnId);
		$teaName = $teachName['name'];
		$projectName = $project -> projectTitle($teacherUnId);
		$proName = $projectName['title'];
		$teacherUnId = $_SESSION['teacher_unique_id'];
		if(empty($taskNotice)){
			echo "Field can't be empty";
		}
		else{
			echo "task notice published";
			$taskNoticeSubmit = $project -> teacherTaskNotice($taskNotice,$proName,$teacherUnId,$teaName);
		}

	}

		$taskLeader = $project -> taskLeader($teacherUnId);
		$newLeader  = $taskLeader['leader'];
		$taskResult = $project -> viewTask($newLeader);


	if(isset($_POST['proSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

		
		
		if(empty($phase)){
			echo "Phase field can't be empty";
		}
		else{
			$phase = $_POST['phase'];
			$viewProject = $project -> viewProject($newLeader,$phase);
		}
		
	
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Teacher Profile</title>
</head>
<body>
	<h1>Hello: <?php echo $_SESSION['teacher_unique_id'];?></h1>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
		<label for="title">Suggest Project Name:</label>
		<textarea id="title" name="title" rows="4" cols="50"></textarea>
		<input type="submit" name="pSubmit" value="Submit">
	</form>
	<!-- <h1>Project supervision request</h1>
	<span>1. Project One</span> <input type="radio" name="projectRequest" value="accept">Accept<input type="radio" name="projectRequest" value="delete">Delete <br>
	<span>2. Project Two</span><input type="radio" name="projectRequest" value="accept">Accept<input type="radio" name="projectRequest" value="delete">Delete <br>
	<span>3. Project Three</span><input type="radio" name="projectRequest" value="accept">Accept<input type="radio" name="projectRequest" value="delete">Delete <br> -->

	<h1>Select team leader for your project</h1>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
		<?php foreach($projectMemberId as $proMemberId):?>
			<input type="radio" id="<?php echo $proMemberId['studentid'];?>" name="leader" value="<?php echo $proMemberId['studentid'];?>">	
			<label for="<?php echo $proMemberId['studentid'];?>"> <?php echo $proMemberId['studentid']; 
			$projectMemberName = $project -> teamMemberName($proMemberId['studentid']);
			foreach($projectMemberName as $proMemberName){echo ' ('.$proMemberName['name'].')';}?></label><br>
		<?php endforeach;?>
			<input type="submit" name="lSubmit" value="Select">
	</form>
	<br><br><br>

	<h1>Manage project</h1>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
		<label for="projectTask">Give Task:</label>
		<textarea id="projectTask" name="taskNotice" rows="4" cols="50"></textarea>
		<input type="submit" name="nSubmit" value="Post">
	</form>


	

	<h2>View Task: </h2>
	<?php foreach($taskResult as $newTaskResult):?>

	<ul style="list-style-type:circle">
		<li><a href=" ../upload/taskfile/<?php echo $newTaskResult['taskfile'];?>" download>Download Task</a></li>
	</ul>
	<?php endforeach;?>
	
	

	<h2>View Project</h2>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
	  <label for="phase">Choose a phase:</label>
	  <select name="phase" id="phase">
	  	<option value="" checked="checked">None</option>
	    <option value="1">Phase 1</option>
	    <option value="2">Phase 2</option>
	    <option value="3">Phase 3</option>
	  </select>
	  <br><br>
	  <input type="submit" name="proSubmit" value="Search">
	</form>

	
	<?php if(isset($phase)):?>
	<?php foreach($viewProject as $newProject):?>
		<ul style="list-style-type:circle">
			<li><a href="../upload/projectfile/<?php echo $newProject['file']?>">Download Project</a></li>
		</ul>
		
	<?php endforeach;?>	
	<?php endif;?>
	<hr>
	<hr>
	<br>
	<h1>Setup profile</h1>
	<?php 
		if(isset($_POST['profileSubmit']) && $_SERVER['REQUEST_METHOD'] == "POST"){
			 $designation = $_POST['designation'];
			 $phone = $_POST['phone'];

			 
			 $photoName = $_FILES['photo']['name'];
			 $photoTmpName = $_FILES['photo']['tmp_name'];
			 $photoSize = $_FILES['photo']['size'];
			 $photoFileType = array('jpg','jpeg','png');

			 $photoFileExplode = explode('.', $photoName);
			 $photoFileExtension = strtolower(end($photoFileExplode));
			 $photoFileUniqueName = md5($photoName.time()).'.'.$photoFileExtension;
			if(empty($designation)){
				echo "Designaton can't be empty";
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
				$project -> teacherProfileSetup($designation,$phone,$photoFileUniqueName,$teacherUnId);
				move_uploaded_file($photoTmpName, "../upload/teacherphoto/".$photoFileUniqueName);
				echo "Profile updated successfully";
			}

		}
	?>	
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST" enctype="multipart/form-data">
		<label>Designaton</label>
		<input type="text" name="designation" placeholder="Designation">
		<label>Phone</label>
		<input type="text" name="phone" placeholder="Phone No">
		<label>Upload Photo</label>
		<input type="file" name="photo">
		<input type="submit" name="profileSubmit">
	</form>

</body>
</html>