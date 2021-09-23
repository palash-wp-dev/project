 <?php 
	
	
	require_once "config.php";

	class DatabaseConnection{
		

		public $conn;		
		// private $host = "localhost";
		// private $db = "project";
		// private $user = "root";
		// private $user_password = "";

		private $host = HOST;
		private $db = DATABASE;
		private $user = USER;
		private $user_password = PASSWORD;
		
		public function __construct(){
			// try{
			// 	// $pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user, $this->user_password);
			// 	// $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			// 	// echo "Database connection is successful <br>";
			// }
			// catch(PDOException $e){
			// 	echo "Conccetion failed <br>".$e->getMessage();
			// }


			$this->conn = new mysqli($this->host, $this->user, $this->user_password, $this->db);
		}


		public function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}

		public function regCodeValidation($id,$category){
			$sql = "SELECT code FROM codevalidation WHERE id='$id' AND category='$category'";
			$data = $this->conn -> query($sql);
			$result = $data->fetch_assoc();
		    return $result['code'];
		}

		public function teacherRegistration($id,$email,$password,$code,$name){
			$sql = "INSERT INTO teacherreg (id,email,password,code,name) VALUES ('$id','$email','$password','$code','$name')";
			$data = $this->conn -> query($sql);
		}

		public function teacherIdValidation($id,$code){
			$sql = "SELECT id FROM teacherreg WHERE code = '$code'";
			$data = $this->conn -> query($sql);
			$result = $data-> fetch_assoc();
			return $result['id'];
		}

		public function studentRegistration($id,$email,$password,$code,$name){
			$sql = "INSERT INTO studentreg (id,email,password,code,name) VALUES ('$id','$email','$password','$code','$name')";
			$data = $this->conn -> query($sql);
		}

		public function studentIdValidation($id,$code){
			$sql = "SELECT id FROM studentreg WHERE code = '$code'";
			$data = $this->conn -> query($sql);
			$result = $data-> fetch_assoc();
			return $result['id'];
		}

		public function adminLogin($a_id,$a_email,$a_password){
			$sql = "SELECT * FROM admin WHERE id='$a_id' AND email='$a_email' AND password='$a_password'";
			$data = $this->conn -> query($sql);
			return $result = $data->fetch_assoc();
		}

		public function teacherLogin($t_id,$t_email,$t_password){
			$sql = "SELECT * FROM teacherreg WHERE id='$t_id' AND email='$t_email' AND password='$t_password'";
			$data = $this->conn -> query($sql);
			return $result = $data->fetch_assoc();
		}
		public function studentLogin($s_id,$s_email,$s_encrypted_password){
			$sql = "SELECT * FROM studentreg WHERE id='$s_id' AND email='$s_email' AND password='$s_encrypted_password'";
			$data = $this->conn -> query($sql);
			return $result = $data->fetch_assoc();
		}

		public function authenticationCode($id,$random_code,$category){
			$sql = "INSERT INTO codevalidation (id,code,category) VALUES ('$id','$random_code','$category')";
			$data = $this->conn -> query($sql);
		}

		public function authenticationCodeUpdate($updateId,$updateCode,$updateCategory){
			$sql = "UPDATE codevalidation SET id = '$updateId', code = '$updateCode', category = '$updateCategory' WHERE id = '$updateId'";
			$data = $this->conn -> query($sql);
		}

		
	}


	class Project extends DatabaseConnection{
		public function projectSuggestedByTeacher($title,$suggestedBy,$status,$teacherUnId){
			$sql = "INSERT INTO projectlist (title,suggestedby,status,suggestedid) VALUES('$title','$suggestedBy','$status','$teacherUnId')";
			$data = $this->conn -> query($sql);
		}


		public function projectSuggestedByStudent($title,$suggestedBy,$status,$stuId){
			$sql = "INSERT INTO projectlist (title,suggestedby,status,suggestedid) VALUES('$title','$suggestedBy','$status','$stuId')";
			$data = $this->conn -> query($sql);
		}

		public function projectList(){
			$sql = "SELECT * FROM projectlist";
			return $data = $this->conn -> query($sql);
		}
		public function studentSpecificProject($stuId){
			$sql = "SELECT * FROM projectlist WHERE suggestedid ='$stuId' ";
			$data = $this->conn -> query($sql);
			return $result = $data -> fetch_assoc();
		}

		public function teacherList(){
			$sql = "SELECT * FROM teacherreg";
			return $data = $this->conn -> query($sql);
		}

		public function proSupervisorId($proSupervisorName,$proSupervisorEmail){
			$sql = "SELECT id FROM teacherreg WHERE name ='$proSupervisorName' AND email ='$proSupervisorEmail' ";
			$data = $this->conn -> query($sql);
			return $result = $data -> fetch_assoc();
		}

		public function selectProject($stuId,$proTitle,$proSupervisorId){
			$sql = "INSERT INTO studentproject (studentid,projecttitle,teacherid) VALUES('$stuId','$proTitle','$proSupervisorId')";
			$data = $this->conn -> query($sql);
		}

		public function projectDetails($proTitle,$proSupervisorId,$stuId){
			$sql = "INSERT INTO projectdetails (title,supervisor,member1) VALUES('$proTitle','$proSupervisorId','$stuId')";
			$data = $this->conn -> query($sql);
		}


		public function projectMemberLimit($proTitle){
			$sql = "SELECT studentid FROM studentproject WHERE projecttitle ='$proTitle' ";
			$data = $this->conn -> query($sql);
			return $row_count = $data -> num_rows;
		}

		public function teamLeader($teacherUnId){
			$sql = "SELECT * FROM studentproject WHERE teacherid ='$teacherUnId' ";
			return $data = $this->conn -> query($sql);
			
		}
		public function teamMemberName($studentId){
			$sql = "SELECT * FROM studentreg WHERE id ='$studentId' ";
			return $data = $this->conn -> query($sql);
			
		}

		public function projectDetailsTwo($stuId,$proSupervisorId){
			$sql = "UPDATE projectdetails SET member2 = '$stuId' WHERE supervisor = '$proSupervisorId'";
			$data = $this->conn -> query($sql);
		}
		public function projectDetailsThree($stuId,$proSupervisorId){
			$sql = "UPDATE projectdetails SET member3 = '$stuId' WHERE supervisor = '$proSupervisorId'";
			$data = $this->conn -> query($sql);
		}
		public function projectDetailsFour($stuId,$proSupervisorId){
			$sql = "UPDATE projectdetails SET member4 = '$stuId' WHERE supervisor = '$proSupervisorId'";
			$data = $this->conn -> query($sql);
		}
		public function selectLeader($leader,$teacherUnId){
			$sql = "UPDATE projectdetails SET leader = '$leader' WHERE supervisor = '$teacherUnId'";
			$data = $this->conn -> query($sql);
		}
		public function teacherName($teacherUnId){
			$sql = "SELECT name,email FROM teacherreg WHERE id = '$teacherUnId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}
		public function projectTitle($teacherUnId){
			$sql = "SELECT title FROM projectdetails WHERE supervisor = '$teacherUnId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}

		public function teacherTaskNotice($taskNotice,$proName,$teacherUnId,$teaName){
			$sql ="INSERT INTO tasknotice (notice,projecttitle,teacherid,teachername) VALUES ('$taskNotice','$proName','$teacherUnId','$teaName')";
			$data = $this->conn -> query($sql);
		}

		public function projectDetailsForTaskUpload($stuId){
			$sql = "SELECT * FROM projectdetails WHERE leader = '$stuId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}

		public function taskUpload($fileUniqueName,$stuId,$superId){
			$sql ="INSERT INTO taskuploader (taskfile,studentid,teacherid) VALUES ('$fileUniqueName','$stuId','$superId')";
			$data = $this->conn -> query($sql);
		}

		public function projectUpload($proFileUniqueName,$stuId,$superId,$phase){
			$sql ="INSERT INTO projectfile (file,studentid,teacherid,phase) VALUES ('$proFileUniqueName','$stuId','$superId','$phase')";
			$data = $this->conn -> query($sql);
		}

		public function taskLeader($teacherUnId){
			$sql = "SELECT leader FROM projectdetails WHERE supervisor ='$teacherUnId' ";
		    $data = $this->conn -> query($sql);
		    return $data -> fetch_assoc();
			
		}
		public function viewTask($newLeader){
			$sql = "SELECT * FROM taskuploader WHERE studentid = '$newLeader'";
			return $data = $this ->conn->query($sql);


		}

		public function viewProject($teacherUnId,$phase){
			$sql = "SELECT * FROM projectfile WHERE teacherid = '$teacherUnId' AND phase = '$phase'";
			return $data = $this ->conn->query($sql);

		}
		public function adminProfileSetup($name,$email,$adminId,$photoFileUniqueName,$position,$phone){
			$sql ="INSERT INTO adminprofile (name,email,id,photo,position,phone) VALUES ('$name','$email','$adminId','$photoFileUniqueName','$position','$phone')";
			$data = $this->conn -> query($sql);	
		}
		public function teacherProfileSetup($designation,$phone,$photoFileUniqueName,$teacherUnId){
			$sql ="INSERT INTO teacherprofile (designation,phone,photo,teacherid) VALUES ('$designation','$phone','$photoFileUniqueName','$teacherUnId')";
			$data = $this->conn -> query($sql);	
		}

		public function studentProfileSetup($batch,$phone,$photoFileUniqueName,$stuId){
			$sql ="INSERT INTO studentprofile (batch,phone,photo,studentid) VALUES ('$batch','$phone','$photoFileUniqueName','$stuId')";
			$data = $this->conn -> query($sql);	
		}

		public function adminProfileDetails($adminId){
			$sql = "SELECT * FROM adminprofile WHERE id = '$adminId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}

		public function teacherProfileDetails($teacherId){
			$sql = "SELECT * FROM teacherprofile WHERE teacherid = '$teacherId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}

			public function teacherProfileDetails2($teacherId){
			$sql = "SELECT * FROM teacherreg WHERE id = '$teacherId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}
		public function studentRegDetails1($stuId){
			$sql = "SELECT name FROM studentreg WHERE id = '$stuId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}

		public function studentRegDetails2($stuId){
			$sql = "SELECT * FROM studentprofile WHERE studentid = '$stuId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> fetch_assoc();
		}

		public function afterProjectSelection($stuId){
			$sql = "SELECT title FROM projectdetails WHERE member1 = '$stuId' || member2 = '$stuId' || member3 = '$stuId' || member4 = '$stuId'";
			$data = $this ->conn->query($sql);
			return $result = $data -> num_rows;
		}

		// public function teacherOnlySupervisor(){
		// 	$sql = "SELECT * FROM projectlist WHERE title = '$stuId'";
		// 	$data = $this ->conn->query($sql);
		// 	return $result = $data -> fetch_assoc();
		// }

		public function titleDuplicate($title){
			$sql = "SELECT * FROM projectlist WHERE title = '$title'";
			$data = $this->conn -> query($sql);
			return $result = $data -> num_rows;
		}

		public function adminEmail($adminId){
			$sql = "SELECT email FROM admin WHERE id='$adminId'";
			$data = $this->conn -> query($sql);
			return $result = $data->fetch_assoc();
		}

		public function validationDuplicate($id){
			$sql = "SELECT code FROM codevalidation WHERE id='$id'";
			$data = $this->conn -> query($sql);
			return $result = $data-> num_rows;
		}

		public function projectSupervisor($stuId){
			$sql = "SELECT supervisor FROM projectdetails WHERE leader='$stuId'";
			$data = $this->conn -> query($sql);
			return $result = $data-> fetch_assoc();
		}
		public function noticeView($teacherId){
			$sql = "SELECT notice FROM tasknotice WHERE teacherid='$teacherId' ORDER BY sl DESC LIMIT 5";
			return $data = $this->conn -> query($sql);
			
		}



	}




