<?php
	session_start();
	require_once("../inc/db_connect.inc");
 	
    $sql = "select COUNT(`Equipment_ID`) from equipment_list";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_row($query);
	$eq_id = "EQ0".$data[0]+1;

	if(isset($_POST["classification_number"]) && $_POST["classification_number"] != ""){
		$classification_number = $_POST["classification_number"];
	} else {
		$classification_number = NULL;
	}
	if(isset($_POST["serial_number"]) && $_POST["serial_number"] != ""){
		$serial_number = $_POST["serial_number"];
	} else {
		$serial_number = NULL;
	}
	if(isset($_POST["name"]) && $_POST["name"] != ""){
		$name = $_POST["name"];
	} else {
		echo "<script>
			answer = confirm(\"器材名稱不得為空\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}
	if(isset($_POST["amount"]) && $_POST["amount"] != ""){
		$amount = $_POST["amount"];
	} else {
		echo "<script>
			answer = confirm(\"數量不得為空\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}
	if(isset($_POST["price"]) && $_POST["price"] != ""){
		$price = $_POST["price"];
	} else {
		$price = NULL;
	}
	if(isset($_POST["wh"]) && $_POST["wh"] != ""){
		$wh = $_POST["wh"];
	} else {
		echo "<script>
			answer = confirm(\"存放地點不得為空\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}
	if(isset($_POST["pr"]) && $_POST["pr"] != ""){
		$pr = $_POST["pr"];
	} else {
		echo "<script>
			answer = confirm(\"保管者不得為空\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}
	if(isset($_POST["borrow_state"]) && $_POST["borrow_state"] == "Yes"){
		$borrow_state = 1;
	}else{
	  	$borrow_state = 0;
	}
	if(isset($_POST["broken_state"]) && $_POST["broken_state"] == "Yes"){
		$broken_state = 1;
	}else{
	  	$broken_state = 0;
	}
	if(isset($_POST["remark"]) && $_POST["remark"] != ""){
		$remark = $_POST["remark"];
	} else {
		$remark = NULL;
	}

	$sql = "INSERT INTO `equipment_list`(`Equipment_ID`, `Classification_number`, `Serial_number`, `Name`, `Amount`, `Warehouse_ID`, `Price`, `Principal_ID`, `Remark`, `Borrowable`, `Broken`) VALUES ('".$eq_id."','".$classification_number."','".$serial_number."','".$name."','".$amount."','".$wh."','".$price."','".$pr."','".$remark."','".$borrow_state."','".$broken_state."')";
	$query = mysqli_query($conn, $sql);

	if($query){
		echo "<script>
				alert(\"成功新增器材\");
				location.href=\"../equipment_manage_admin.php\";
			</script>";
		exit();
	}
	mysqli_close($conn);
?>