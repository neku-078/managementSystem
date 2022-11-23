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

    $sql = "select `Equipment_ID`, `Name`, `Amount`, `Borrowable`, `Broken` from equipment_list";
    $query = mysqli_query($conn, $sql);
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

    <!-- 甘特圖 -->
    <link rel="stylesheet" href="css/dhtmlxgantt.css" 
    type="text/css"> 
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/dhtmlxgantt.js"></script>

    <!-- date format -->
    <script src="js/date_format.js"></script>

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
                        <h1 class="h3 mb-0 text-gray-800">器材管理</h1>
                    </div>

                    <!-- 總覽 -->

                    <div class="row">

                        <!-- 器材 -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">器材借用一覽</h6>
                                </div>
                                <!-- 甘特圖 -->
                                <div class="card-body" style="height: 500px;">
                                    <div id="gantt_here" style='width:100%; height:100%;'></div>
                                    <!-- 取sql資料 -->
                                    <?php
                                        //可借用器材清單
                                        $sql = "SELECT Equipment_ID, Name FROM equipment_list WHERE Borrowable = 1 ORDER BY Name;";
                                        if($result = mysqli_query($conn, $sql)) {
                                            $equipment_data = array();
                                            while($equipment_list = mysqli_fetch_row($result)) {
                                                array_push($equipment_data, [$equipment_list[0], $equipment_list[1]]);
                                            }
                                            //echo json_encode($equipment_data, JSON_UNESCAPED_UNICODE);
                                        }
                                        else {
                                            echo "Equipment list error!";
                                        }

                                        //借用列表
                                        $sql = "SELECT borrowing_list.Club_ID, Name, Borrow_date, Return_date, Equipment_list_ID FROM borrowing_list LEFT JOIN club ON borrowing_list.Club_ID = club.Club_ID LEFT JOIN equipment_borrowed ON equipment_borrowed.Borrowing_list_ID = borrowing_list.Borrowing_list_ID ORDER BY Name";
                                        //[0]club_id; [1]club_name; [2]borrow_date; [3]return_date; [4]equipment_list_id
                                        if($result = mysqli_query($conn, $sql)) {
                                            $borrow_data = array();
                                            while($borrow_list = mysqli_fetch_array($result)) {
                                                array_push($borrow_data, $borrow_list);
                                            }
                                        }
                                        else {
                                            echo "Borrow list error!";
                                        }
                                    ?>
                                    <script type="text/javascript">
                                        //js取資料
                                        var equipment_data = <?php echo json_encode($equipment_data, JSON_UNESCAPED_UNICODE); ?>;
                                        var borrow_data = <?php echo json_encode($borrow_data, JSON_UNESCAPED_UNICODE); ?>;
                                    </script>
                                    <script src="js/equipment_loan_overview.js"></script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 總覽 End-->

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