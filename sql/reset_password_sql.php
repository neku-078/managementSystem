<?php 

	session_start();
	require_once("../inc/db_connect.inc");

	$account = $_SESSION['account'];
	$identity = $_SESSION['identity'];
	$old_password = "";
	$new_password = "";
	$confirm = "";
	$database_pass = "";
	
	if($identity == "club"){
		$sql = "select Password from club where Account = '".$account."'";
	} else if($identity == "admin"){
		$sql = "select Password from admin where Stu_ID = '".$account."'";
	}
	$query = mysqli_query($conn,$sql);
	$data = mysqli_fetch_row($query);

	$database_password = $data[0];

	if (isset($_POST["old_password"])){
		check_empty($_POST["old_password"]);
		$old_password = hash('sha256', $_POST["old_password"]);
	}

	if (isset($_POST["new_password"])){
		check_empty($_POST["new_password"]);
		$new_password = hash('sha256', $_POST["new_password"]);
	}

	if (isset($_POST["confirm_new_password"])){
		check_empty($_POST["confirm_new_password"]);
		 $confirm_new_password = hash('sha256', $_POST["confirm_new_password"]);
	}
	
	if($old_password != $database_password){
		echo "<script>
				alert(\"舊密碼錯誤\");
				javascript:history.go(-1);
			</script>";
		exit();
	} else if(!checkStr($_POST["new_password"])){
		exit();
	} else if($old_password == $new_password){
		echo "<script>
				alert(\"新密碼與舊密碼相同\");
				javascript:history.go(-1);
			</script>";
		exit();
	} else if($confirm_new_password != $new_password){
		echo "<script>
				alert(\"新密碼與確認密碼不符\");
				javascript:history.go(-1);
			</script>";
		exit();
	}

	if($identity == "club"){
		$sql = "UPDATE club SET Password = '$new_password' WHERE Account = '$account'";
	} else if($identity == "admin"){
		$sql = "UPDATE admin SET Password = '$new_password' WHERE Stu_ID = '$account'";
	}
	
	$query = mysqli_query($conn,$sql);
	if($query){
		echo "<script>
				alert(\"修改成功\");
				location.href=\"../reset_password.php\";
			</script>";
		exit();
	}
	mysqli_close($conn);

	function check_empty($str){
		if(empty($str)){
			echo "<script>
    				alert('欄位不得為空');
    				javascript:history.go(-1);
    			</script>";
			exit();
		}
	}

	function checkStr($str){
    	$output = true; 
    	if(!preg_match('/^[0-9a-zA-Z]{8,16}$/', $str)){
    		echo "<script>
    				alert('新密碼長度不合');
    				javascript:history.go(-1);
    			</script>";
    		$output = false; 
    	} else if (!preg_match('/(?=.*[a-z])/', $str)){
    		echo "<script>
    				alert('新密碼需有小寫字母');
    				javascript:history.go(-1);
    			</script>";
    		$output = false;
    	} else if (!preg_match('/(?=.*[A-Z])/', $str)){
    		echo "<script>
    				alert('新密碼需有大寫字母');
    				javascript:history.go(-1);
    			</script>";
    		$output = false;
    	} else if (!preg_match('/(?=.*[0-9])/', $str)){
    		echo "<script>
    				alert('新密碼需有阿拉伯數字');
    				javascript:history.go(-1);
    			</script>";
    		$output = false;
    	}
    	return $output;
	}
?>