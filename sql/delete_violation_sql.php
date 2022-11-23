<?php
	session_start();
	require_once("../inc/db_connect.inc");

	$vid = $_GET["vid"];
	$sql = "DELETE FROM `violation_list` WHERE `Violation_ID`=".$vid;
	$query = mysqli_query($conn, $sql);
	if($query){
		echo "<script>
				alert(\"刪除成功\");
				location.href=\"../violation_records_admin.php\";
			</script>";
		exit();
	}	
?>