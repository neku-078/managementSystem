<?php
	session_start();
	require_once("../inc/db_connect.inc");
	$account = "";
	$password = "";
	$_SESSION["username"] = "";
	$_SESSION["uid"] = "";
	$_SESSION["identity"] = "";
	
	if(!isset($_POST["login_identity"])){
		echo "<script>
			answer = confirm(\"請選擇登入身分\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	} else if($_POST["login_identity"] == "0"){
		$_SESSION["identity"] = "club";
		$query = mysqli_query($conn,"select Account, Password, Name, Club_ID from `club`");
	}else if($_POST["login_identity"] == "1"){
		$_SESSION["identity"] = "admin";
		$query = mysqli_query($conn,"select Stu_ID, Password, Name, Department_ID from `admin`");
	}else{
		echo "<script>
				answer = confirm(\"請選擇登入身分\");
				if (answer)
					javascript:history.go(-1);
				</script>";
		exit();
	}

	if (isset($_POST["account"])){
		if($_SESSION["identity"] == "admin"){
			$account = strtoupper($_POST["account"]);
		} 
		else {
			$account = $_POST["account"];
		}
	}

	if (isset($_POST["password"])){
	   $password = hash('sha256', $_POST["password"]);
	}

	if ($account != "" && $password != "") {
		$total_records = 0;
		
	  	$temp = mysqli_num_rows($query);
	  	for($i = 0; $i<$temp; $i++){
		    $data = mysqli_fetch_row($query);
		   
		    if($account==$data[0]&&$password==$data[1]){
			  $_SESSION["account"] = $data[0];
			  $_SESSION["username"] = $data[2];
			  $_SESSION["uid"] = $data[3];
			  $_SESSION["login"] = true;
			  $total_records = 1;
			  break;
		    }
	    }

		if ($total_records > 0) {
			/*
			if($_SESSION["Level"] == 3){
				header("Location: ../Back.php");
				 $_SESSION["login"] = true;
	   		}else{ 
		  		header("Location: ../Index.php");
		  		 $_SESSION["login"] = true;
		  	}
		  	*/
		  	header("Location: ../dashboard_".$_SESSION["identity"].".php");
		  	$_SESSION["login"] = true;
	   } else {
		  echo "<script>
					alert(\"帳號或密碼錯誤\");
					javascript:history.go(-1);
				</script>";
	   }

	} else {
		echo "<script>
					alert(\"帳號或密碼不得為空\");
					javascript:history.go(-1);
				</script>";
	}
?>