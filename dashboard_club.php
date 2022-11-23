<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    require_once("inc/db_connect.inc");
    if($_SESSION['login'] == false){
        header('Location:index.php');
    }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Dashboard</title>

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
    <script src="js/dhtmlxgantt.js"></script>

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

        <?php
            $user = "";

            if(isset($_SESSION["username"])){
                $user = $_SESSION["username"];
            }
        ?>  

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
                        <h1 class="h3 mb-0 text-gray-800">管理主頁</h1>
                    </div>

                    <!-- 未完成借用單 -->

                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">未完成的借用單</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <td>借用單號</td>
                                                    <td>領取日期</td>
                                                    <td>歸還日期</td>
                                                    <td>借用器材總數</td>
                                                    <td>檢視</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- 超連結問題求救，還有不知道為啥ID抓不到 -->
                                                
                                                    <?php
                                                        $sql = "SELECT borrowing_list.Borrowing_list_ID, Borrow_date, Return_date, COUNT(*), Inventory_ID From borrowing_list LEFT JOIN equipment_borrowed ON borrowing_list.Borrowing_list_ID = equipment_borrowed.Borrowing_list_ID WHERE Club_ID='".$_SESSION['uid']."' AND Inventory_ID IS NULL GROUP BY Borrowing_list_ID;";
                                                        if($result = mysqli_query($conn, $sql)) {
                                                            while($borrowing_data = mysqli_fetch_row($result)) {
                                                                echo "<tr>
                                                                        <td>".$borrowing_data[0]."</td>
                                                                        <td>".date("Y-m-d", strtotime($borrowing_data[1]))."</td>
                                                                        <td>".date("Y-m-d", strtotime($borrowing_data[2]))."</td>
                                                                        <td>".$borrowing_data[3]."</td>
                                                                        <td><a href='borrowing_club.php?borrow_id=".$borrowing_data[0]."' class='btn btn-info btn-circle btn-sm'><i class='fas fa-info'></i></a></td>
                                                                    </tr>"; 
                                                            }    
                                                        }
                                                    ?>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 未完成 End -->


                    <!-- 扣點紀錄 -->

                    <div class="row">

                        <!-- 扣點紀錄 -->

                        <div class="col-xl-9 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">扣點紀錄</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>編號</th>
                                                    <th>扣點點數</th>
                                                    <th>事由</th>
                                                    <th>違規借用單</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                     $sql = "SELECT `Violation_ID`, violation_list.`Rov_ID`, `Point`, `Reason`, violation_list.`Borrowing_list_ID` FROM violation_list LEFT JOIN reason_of_violation ON reason_of_violation.`Rov_ID` = violation_list.`Rov_ID` LEFT JOIN borrowing_list ON borrowing_list.`Borrowing_list_ID` = violation_list.`Borrowing_list_ID` WHERE `Club_ID` = '".$_SESSION['uid']."';";
                                                     //[0]vioaltion_id; [1]rov_id; [2]point; [3]reason; [4]borrowing_list_id
                                                     $result = mysqli_query($conn, $sql);
                                                     while($violation_list = mysqli_fetch_row($result)) {
                                                        echo "<tr>
                                                                <td>".$violation_list[0]."</td>
                                                                <td>".$violation_list[2]."</td>
                                                                <td>".$violation_list[3]."</td>
                                                                <td><a href='borrowing_club.php?borrow_id=".$violation_list[4]."' class='btn btn-info btn-circle btn-sm'><i class='fas fa-info'></i></a></td>
                                                            </tr>";    
                                                        }    
                                                    ?>

                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 扣點紀錄 -->

                        <div class="col-xl-3 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">扣點提醒事項</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <p>
                                            <?php
                                                date_default_timezone_set('PRC');
                                                $sql = "SELECT Club_ID, SUM(`Point`) AS points FROM violation_list LEFT JOIN borrowing_list ON borrowing_list.`Borrowing_list_ID` = violation_list.`Borrowing_list_ID` LEFT JOIN reason_of_violation ON violation_list.Rov_ID = reason_of_violation.Rov_ID WHERE Club_ID='".$_SESSION['uid']."' AND (CAST(Return_date AS DATE) >= CAST('".date("Y-m-d",time())."' AS DATE)) GROUP BY Club_ID";
                                                $result = mysqli_query($conn, $sql);
                                                $violation_points = mysqli_fetch_row($result);

                                                if($violation_points) {
                                                    $violation_points = $violation_points[1];
                                                }
                                                else {
                                                    $violation_points = 0;
                                                }

                                                if($violation_points < 3) {
                                                    $_SESSION['borrowable']=true;
                                                    echo "扣點點數總計：".$violation_points."<br />
                                                        狀態：未停權。<br />";
                                                } else {
                                                    $_SESSION['borrowable']=false;
                                                    echo "狀態：已停權。<br />";
                                                }
                                            ?>
                                        </p>
                                        <p>*違規點數達到3點後將暫停借用權限一年。</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- 扣點 End -->

                    <!-- 借用紀錄 -->

                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">借用紀錄</h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <td>借用單號</td>
                                                    <td>領取日期</td>
                                                    <td>歸還日期</td>
                                                    <td>借用器材總數</td>
                                                    <td>檢視</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- 同上 -->
                                                <?php
                                                    $sql = "SELECT borrowing_list.Borrowing_list_ID, Borrow_date, Return_date, COUNT(*), Inventory_ID From borrowing_list LEFT JOIN equipment_borrowed ON borrowing_list.Borrowing_list_ID = equipment_borrowed.Borrowing_list_ID WHERE Club_ID='".$_SESSION['uid']."' AND Inventory_ID IS NOT NULL GROUP BY Borrowing_list_ID;";

                                                    if($result = mysqli_query($conn, $sql)) {
                                                        while($borrowing_data = mysqli_fetch_row($result)) {
                                                            echo "<tr>
                                                                <td>".$borrowing_data[0]."</td>
                                                                <td>".date("Y-m-d", strtotime($borrowing_data[1]))."</td>
                                                                <td>".date("Y-m-d", strtotime($borrowing_data[2]))."</td>
                                                                <td>".$borrowing_data[3]."</td>
                                                                <td><a href='borrowing_club.php?borrow_id=".$borrowing_data[0]."' class='btn btn-info btn-circle btn-sm'><i class='fas fa-info'></i></a></td>
                                                                </tr>"; 
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 紀錄 End -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
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