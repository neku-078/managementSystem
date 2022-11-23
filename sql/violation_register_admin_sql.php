<?php
	session_start();
	require_once("../inc/db_connect.inc");

	$club = $_POST['club_select'];

	if(isset($_POST['borrowing_list_select'])){
		$borrowing_list = $_POST['borrowing_list_select'];
	} else {
		echo "<script>
			answer = confirm(\"請選擇違規借用單號\");
			if (answer)
				location.href=\"../violation_register_admin.php\";
			</script>";
		exit();
	}

	if(isset($_POST['rov_select'])){
		$rov = $_POST['rov_select'];
	} else {
		echo "<script>
			answer = confirm(\"請選擇違規事由\");
			if (answer)
				location.href=\"../violation_register_admin.php\";
			</script>";
		exit();
	}

    $sql="INSERT INTO violation_list (Rov_ID, Borrowing_list_ID) VALUES ('".$rov."', '".$borrowing_list."');";

    if(mysqli_query($conn,$sql)){
        echo "<script>
			answer = confirm(\"成功登記違規點數\");
			if (answer)
				location.href=\"../violation_records_admin.php\";
			</script>";
		exit();
    } else {
        echo "<script>
			answer = confirm(\"登記失敗\");
			if (answer)
				location.href=\"../violation_register_admin.php\";
			</script>";
		exit();
    }
?>