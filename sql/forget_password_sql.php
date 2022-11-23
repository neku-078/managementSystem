<?php

	session_start();
	require_once("../inc/db_connect.inc");

	/*
	require_once "../mail/PHPMailer.php";
	require_once "../mail/SMTP.php";
	require_once "../mail/Exception.php";
	require_once "../mail/OAuth.php";
	require_once "../mail/POP3.php";

	use PHPMailer\PHPMailer\PHPMailer;

	$mail = new PHPMailer(true);
	*/

	$rand = rand(1000,9999);
	$message = "password" .$rand;
	$email = "";

	if($_POST["forget_password_identity"]=="0"){
		$identity = "club";
	}else if($_POST["forget_password_identity"]=="1"){
		$identity = "admin";
	}else{
		echo "<script>alert('請選擇登入身分')</script>";
		exit;
	}

	if(isset($_POST["email"])){
		$email = $_POST["email"];
	}

	if($identity=="admin"){
		$sql = "select Stu_ID from admin where `Email`='$email'";
	}else if($identity=="club"){
		$sql = "select Account from club where `Email`='$email'";
	}

	$query = mysqli_query($conn,$sql);
	$num = mysqli_num_rows($query);

	if($num==0){//該郵箱尚未註冊！ 
		echo "<script>
				answer = confirm(\"電子郵件輸入錯誤\");
				if (answer)
					javascript:history.go(-1);
			</script>";
	} else { 
		$row = mysqli_fetch_array($query);
		$account = $row[0];

		$new_password = hash('sha256', $message);
		if($identity == "admin"){
			$sql = "UPDATE admin SET Password = '$new_password' WHERE Email = '$email'";
		} else if ($identity == "club"){
			$sql = "UPDATE club SET Password = '$new_password' WHERE Email = '$email'";
		}
		$query = mysqli_query($conn,$sql);

		echo "<script>
						alert('您的登入密碼為'+'$message'+'，登入後請立即更改密碼。');
						location.href=\"../index.php\";
					</script>";
			
		/*
		try{
			$mail->IsSMTP();
			$mail->SMTPAuth = "true";
			$mail->SMTPSecure = "tls";
			$mail->CharSet = "utf-8";
			$mail->Host = "smtp.gmail.com:587";
			$mail->Port = "587";
			$mail->SMTPOptions = array(
    								'ssl' => array(
        							'verify_peer' => false,
        							'verify_peer_name' => false,
        							'allow_self_signed' => true)
									);
			$mail->Username = "ccm20010129@gmail.com";
			$mail->Password = "12345678";
			$mail->setFrom("ccm20010129@gmail.com");
			$mail->Subject = "您的登入密碼";
			$mail->Body = "您的登入密碼為[$message],登入後請更改您的密碼";
			$mail->addAddress($email);
			$mail->send();	

			$new_password = hash('sha256', $message);

			if($mail->send()){
				$sql = "UPDATE admin SET Password = '$new_password' WHERE Email = '$email'";
				$query = mysqli_query($conn,$sql);
				$sql = "UPDATE club SET Password = '$new_password' WHERE Email = '$email'";
				$query = mysqli_query($conn,$sql);

				echo "<script>
						answer = confirm(\"新密碼已經傳送至驗證信箱\");
						if (answer)
							location.href=\"../login.php\";
					</script>";
			} else {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}

			
			//$answer = confirm("<script>alert('新密碼已經傳送至驗證信箱')</script>");
			exit;

			$mail->smtpClose();
		}catch(Exception $e){
			echo "<script>alert('Message could't be sent, Because : {$e->getMessage()}')</script>";
		}
		*/
		//header("Location: Login.php");
	} 

?>