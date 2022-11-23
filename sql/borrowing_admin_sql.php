<?php
	session_start();
	require_once("../inc/db_connect.inc");

	//club
	if(isset($_POST["club_select"])){
		$borrow_club = $_POST["club_select"];
	} else {
		echo "<script>
			answer = confirm(\"請選擇借用單位\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}

	//borrow date
	if(isset($_POST["borrow_date"]) && $_POST["borrow_date"]!="")
		$borrow_date = $_POST["borrow_date"];
	else {
		echo "<script>
			answer = confirm(\"請選擇領取日期\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}

	//return date
	if(isset($_POST["return_date"]) && $_POST["return_date"]!=""){
		if($borrow_date > $_POST["return_date"]){
			echo "<script>
				answer = confirm(\"領取日期不得在歸還日期之後\");
				if (answer)
					javascript:history.go(-1);
				</script>";
			exit();
		} else if($borrow_date == $_POST["return_date"]){
			echo "<script>
				answer = confirm(\"領取日期不得與歸還日期相同\");
				if (answer)
					javascript:history.go(-1);
				</script>";
			exit();
		} else
			$return_date = $_POST["return_date"];
	} else {
		echo "<script>
			answer = confirm(\"請選擇歸還日期\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}

	//event space
	if(isset($_POST["event_space"]))
		$sp = $_POST["event_space"];
	else {
		echo "<script>
			answer = confirm(\"請選擇活動地點\");
			if (answer)
				javascript:history.go(-1);
			</script>";
		exit();
	}
	$borrow_id = $_GET["borrow_id"];

	if (!$borrow_id) {
        $sql="INSERT INTO borrowing_list (Club_ID, Borrow_date, Return_date, Space_ID) VALUES ('".$borrow_club."', '".$borrow_date."', '".$return_date."', '".$sp."');";
        //insert into borrowing_list  (Club_ID, Borrow_date, Return_date, Filler_ID, Inventory_ID, Space_ID) VALUES ('CL002', '2021-12-12 12:00:00', '2021-12-15 12:00:00', 'S10859029', 'S10859029', 'SP004')
    }
    else {
        //更新資料
        $sql = "UPDATE borrowing_list SET Club_ID = '".$borrow_club."', Borrow_date = '".$borrow_date."', Return_date = '".$return_date."', Space_ID = '".$sp."'";
        if(isset($_POST['lender'])) {
            $lender_id = $_POST['lender'];
            $sql = $sql.", Lender_ID = '".$lender_id."'";
        }
        if(isset($_POST['inventory'])) {
            $inventory_id = $_POST['inventory'];
            $sql = $sql.", Inventory_ID = '".$inventory_id."'";
        }
        $sql = $sql."WHERE borrowing_list_ID = ".$borrow_id.";";
    }

    if (mysqli_query($conn, $sql)) {
        //debug
        if(!$borrow_id) {
            $borrowing_list_id = mysqli_insert_id($conn);
            echo $borrowing_list_id."\n";
        } else {
            $borrowing_list_id = $borrow_id;
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $equipment_array = json_decode($_POST['equipment_array']);
    $sql = "";
    $equipment_id = "";
    $equipment_amount = "";
    //Array ( [0] => stdClass Object ( [id] => EQ0086 [amount] => 2 ) [1] => stdClass Object ( [id] => EQ0054 [amount] => 2 ) )
    if ($borrow_id) {
        //有紀錄, 先刪除
        $sql = "DELETE FROM equipment_borrowed WHERE Borrowing_list_ID = ".$borrowing_list_id.";";
        if (mysqli_query($conn, $sql)) {
            echo "Delect successfully!\n";
        }else {
            echo "Delect error!\n";
        }
    }

    foreach ($equipment_array as $sub_array) {
        foreach($sub_array as $key => $value) {
            if ($key == "id") {  //id
                $equipment_id = $value;
            } else {  //amount
                $equipment_amount = $value;
            }
        }
        $sql_equipment = "INSERT INTO equipment_borrowed (Borrowing_list_ID, Equipment_list_ID, Equipment_amount) VALUES ('".$borrowing_list_id."', '".$equipment_id."', '".$equipment_amount."');";
        if (mysqli_query($conn, $sql_equipment)) {
            echo "<script>
			    answer = confirm(\"借用表單填寫成功\");
			    if (answer)
			    location.href=\"../dashboard_".$_SESSION["identity"].".php\";
			    </script>";
        } else {
            echo "<script>
			    answer = confirm(\"輸入資料有誤\");
			    if (answer)
			    javascript:history.go(-1);
			    </script>";
			   exit();
        }
    }
    
    mysqli_close($conn);
?>