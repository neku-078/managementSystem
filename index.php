<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    require_once("inc/db_connect.inc");
    $_SESSION["login"] = false;
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>器材借用系統登入</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/main.min.css" rel="stylesheet">

</head>

<body class="bg-gray-800">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">系統登入</h1>
                                    </div>
                                    <form class="user" action="sql/login_sql.php" method="post">
                                        <div class="form-group">
                                            <select class="custom-select custom-select-sm" id="login_identity" name="login_identity">
                                                <option disabled selected value> -- 選擇登入身分 -- </option>
                                                <option value="0">社團/系學會</option>
                                                <option value="1">學生會管理員</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="login_ID" aria-describedby="emailHelp" name="account" placeholder="Enter Account">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="login_password" name = "password" placeholder="Password">
                                        </div>
                                        <!--
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        -->
                                        <div class="text-center">
                                            <p class="small text-gray-500">
                                                社團帳號及密碼已交給各社團器材長，<br />
                                                請社團同學自行找器材長確認。
                                            </p>
                                        </div>
                                        <div >
                                            <input type="submit" class="btn btn-primary btn-user btn-block" value="登入" />
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot_password.php">忘記密碼</a>
                                        <p class="small text-gray-500">
                                            遺失社團帳號請洽
                                            <a href="mailto:nutnsa@gm2.nutn.edu.tw?subject=[請輸入社團名稱]器材借用系統遺失帳號">學生會Email</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/main.min.js"></script>

</body>

</html>