<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>修改密碼</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/main.min.css" rel="stylesheet">

    <script src="js/equipment_table.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            require_once("inc/sidebar.inc");
        ?>

        <div w3-include-html="sidebar.html"></div>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    require_once("inc/topbar.inc");
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">修改密碼</h1>
	                </div>


                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">修改密碼</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <form class="reset" action="sql/reset_password_sql.php" method="post">
                                    	<!--舊密碼-->
                                    	<div class="form-inline">
											<p>舊密碼：<input type="Password" class="form-control form-control-sm bg-light col-md-10" name="old_password" id="old_pass" placeholder="舊密碼" /></p>
										</div>
										<div class="form-inline">
											<p>新密碼：<input type="Password" class="form-control form-control-sm bg-light col-md-10" name="new_password" id="new_pass" placeholder="新密碼" /></p>
										</div>
										<div class="form-inline">
											<p>確認新密碼：<input type="Password" class="form-control form-control-sm bg-light col-md-10" name="confirm_new_password" id="confirm_new_pass" placeholder="確認新密碼" /></p>
										</div>
										<!--//確定修改-->
										<a href="profile_<?php echo $_SESSION['identity'] ?>.php" class="btn btn-danger btn-icon-split float-right">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">取消修改</span>
                                        </a>
										<button type="submit" class="btn btn-success btn-icon-split float-right" name="confirm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">確認修改</span>
                                        </button>

										<!--<input type="button" class="" name="conncel" value="取消" onclick="javascript:history.go(-1);"/>
										<input type="submit" name="confirm" value="確認" />-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/main.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

</body>

</html>