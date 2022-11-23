<?php
	require_once("../inc/db_connect.inc");

	$eq_id = $_GET["eq_id"];
	$classification_number = $_POST["classification_number"];
	$serial_number = $_POST["serial_number"];
	$name = $_POST["name"];
	$amount = $_POST["amount"];
	$price = $_POST["price"];
	$wh = $_POST["wh"];
	$pr = $_POST["pr"];
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
	$remark = $_POST["remark"];

	$sql = "UPDATE `equipment_list` SET `Classification_number`='".$classification_number."',`Serial_number`='".$serial_number."',`Name`='".$name."',`Amount`='".$amount."',`Warehouse_ID`='".$wh."',`Price`='".$price."',`Principal_ID`='".$pr."',`Remark`='".$remark."',`Borrowable`='".$borrow_state."',`Broken`='".$broken_state."' WHERE `Equipment_ID`='".$eq_id."'";
	$query = mysqli_query($conn,$sql);

	if($query){
		echo "<script>
				alert(\"修改成功\");
				location.href=\"../equipment_manage_admin.php\";
			</script>";
		exit();
	}
	mysqli_close($conn);
?>