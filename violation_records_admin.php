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

    <title>器材管理</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/main.min.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">違規扣點紀錄</h1>
                    </div>

                    <!-- Equipment Table -->
                    <div class="row">
                            <div class="col-lg-12">
                                <!-- 個人資料 -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">紀錄清單</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>編號</th>
                                                        <th>扣點點數</th>
                                                        <th>原因</th>
                                                        <th>違規借用單</th>
                                                        <th>刪除</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        //我找不到他哪裡是壞的 交給你ㄌ
                                                        $sql = "SELECT `Violation_ID`, violation_list.`Rov_ID`, `Point`, `Reason`, `Borrowing_list_ID` from violation_list LEFT JOIN reason_of_violation ON reason_of_violation.`Rov_ID` = violation_list.`Rov_ID`;";
                                                        //[0]violation_id; [1]rov_id; [2]point; [3]reson; [4]borrowing_list_id
                                                        $result = mysqli_query($conn, $sql);
                                                        while($violation_list = mysqli_fetch_row($result)) {
                                                            echo "<tr>
                                                                    <td>".$violation_list[0]."</td>
                                                                    <td>".$violation_list[2]."</td>
                                                                    <td>".$violation_list[3]."</td>
                                                                    <td><a href='borrowing_".$_SESSION['identity'].".php?borrow_id=".$violation_list[4]."' class='btn btn-info btn-circle btn-sm'><i class='fas fa-info'></i></a></td>
                                                                    <td><a href='sql/delete_violation_sql.php?vid=".$violation_list[0]."' class='btn btn-sm btn-danger btn-icon-split'><span class='icon'><i class='fas fa-trash'></i></span></a></td>
                                                                </tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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