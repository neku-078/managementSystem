<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    require_once("inc/db_connect.inc");
    if($_SESSION['login'] == false){
        header('Location:index.php');
    }
    $account = $_SESSION["account"];
    $username = $_SESSION["username"];
    $uid = $_SESSION["uid"];
    $identity = $_SESSION["identity"];
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Profile</title>

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

        <?php
            require_once("inc/sidebar.inc");
        ?>

        <div w3-include-html="sidebar.html"></div>

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
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                    </div>

                    <!-- action寫跳轉 -->
                    <form class="borrow_list" action="" method="post">
                        <div class="row">
                            <div class="col-lg-7">
                                <!-- 個人資料 -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">基本資料</h6>
                                    </div>
                                    <div class="card-body">
                                        <p>帳號/ID：<?php echo $account ?></p>
                                        <p>姓名：<?php echo $username ?></p>
                                        <p>Email：
                                            <?php
                                                $sql = "select `Email` from `admin` where `Stu_ID` = '". $account . "'";
                                                $query = mysqli_query($conn, $sql);
                                                $email = mysqli_fetch_row($query);
                                                echo $email[0];
                                            ?>
                                        </p>
                                        <p>所屬部門：
                                            <?php
                                                $sql = "select `Name` from `department` where `Department_ID` = '". $uid . "'";
                                                $query = mysqli_query($conn, $sql);
                                                $dept = mysqli_fetch_row($query);
                                                echo $dept[0];
                                            ?>
                                        </p>
                                        <p>密碼：********
                                            <a href="reset_password.php" class="btn btn-sm btn-warning btn-icon-split float-right">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <span class="text">更改密碼</span>
                                            </a>
                                        </p>

                                        <button type="submit" class="btn btn-success btn-icon-split float-right">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">保存資料</span>
                                        </button>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <!-- 借用器材 -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">資料變更說明</h6>
                                    </div>
                                    <div class="card-body form-inline">
                                        <p>
                                            欲更改其他資訊請寄信至學生會：nutnsa@gm2.nutn.edu.tw<br />
                                            或直接至學生會會辦進行更改。
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
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