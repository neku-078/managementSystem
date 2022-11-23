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

    <title>Admin Dashboard</title>

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

                    <!-- 今日 -->

                    <div class="row">

                        <!-- 借用 -->
                        <div class="col-xl-6 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">今日借用</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <td>借用單號</td>
                                                    <td>借用單位</td>
                                                    <td>借用器材總數</td>
                                                    <td>動作</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- 用SQL寫進來 -->
                                                <?php
                                                    $today = date("Y-m-d");
                                                    $sql = "SELECT borrowing_list.Borrowing_list_ID, Name, COUNT(*), Lender_ID FROM borrowing_list LEFT JOIN club ON club.Club_ID = borrowing_list.Club_ID LEFT JOIN equipment_borrowed ON equipment_borrowed.Borrowing_list_ID = borrowing_list.Borrowing_list_ID where Borrow_date = '".$today."' AND Lender_ID IS NULL GROUP BY Borrowing_list_ID;";
                                                    $result = mysqli_query($conn, $sql);
                                                    $borrowing_data = mysqli_fetch_array($result);
                                                    while ($borrowing_data) {
                                                        echo "<tr>
                                                                <td>".$borrowing_data[0]."</td>
                                                                <td>".$borrowing_data[1]."</td>
                                                                <td>".$borrowing_data[2]."</td>
                                                                <td>
                                                                    <a href='borrowing_admin.php?borrow_id=".$borrowing_data[0]."' class='btn btn-info btn-circle btn-sm'>
                                                                        <i class='fas fa-info'></i>
                                                                    </a>
                                                                </td>
                                                            </tr>";
                                                        $borrowing_data = mysqli_fetch_row($result);
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 歸還 -->
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">今日歸還</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <td>借用單號</td>
                                                    <td>借用單位</td>
                                                    <td>借用器材總數</td>
                                                    <td>動作</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- 用SQL寫進來 -->
                                                <?php
                                                    $today = date("Y-m-d");
                                                    $sql = "SELECT borrowing_list.Borrowing_list_ID, Name, COUNT(*), Inventory_ID FROM borrowing_list LEFT JOIN club ON club.Club_ID = borrowing_list.Club_ID LEFT JOIN equipment_borrowed ON equipment_borrowed.Borrowing_list_ID = borrowing_list.Borrowing_list_ID where Return_date = '".$today."' AND Inventory_ID IS NULL GROUP BY Borrowing_list_ID;";
                                                    $result = mysqli_query($conn, $sql);
                                                    $borrowing_data = mysqli_fetch_array($result);
                                                    while ($borrowing_data) {
                                                        echo "<tr>
                                                                <td>".$borrowing_data[0]."</td>
                                                                <td>".$borrowing_data[1]."</td>
                                                                <td>".$borrowing_data[2]."</td>
                                                                <td>
                                                                    <a href='borrowing_admin.php?borrow_id=".$borrowing_data[0]."' class='btn btn-info btn-circle btn-sm'>
                                                                        <i class='fas fa-info'></i>
                                                                    </a>
                                                                </td>
                                                            </tr>";
                                                        $borrowing_data = mysqli_fetch_row($result);
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 今日 End -->

                    
                    <!-- 未完成借用單 -->

                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">目前未完成的借用單</h6>
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
                                                    <td>編輯</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- 超連結問題求救，還有不知道為啥ID抓不到 -->
                                                
                                                    <?php
                                                        $sql = "SELECT borrowing_list.Borrowing_list_ID, Borrow_date, Return_date, COUNT(*), Inventory_ID From borrowing_list LEFT JOIN equipment_borrowed ON borrowing_list.Borrowing_list_ID = equipment_borrowed.Borrowing_list_ID WHERE Inventory_ID IS NULL GROUP BY Borrowing_list_ID;";
                                                        if($result = mysqli_query($conn, $sql)) {
                                                            while($borrowing_data = mysqli_fetch_row($result)) {
                                                                echo "<tr><td>".$borrowing_data[0]."</td>";
                                                                echo "<td>".date("Y-m-d", strtotime($borrowing_data[1]))."</td>";
                                                                echo "<td>".date("Y-m-d", strtotime($borrowing_data[2]))."</td>";
                                                                echo "<td>".$borrowing_data[3]."</td>";
                                                                echo "<td><a href='borrowing_admin.php?borrow_id=".$borrowing_data[0]."' class='btn btn-secondary btn-circle btn-sm'>
                                                                <i class='fas fa-pencil-alt'></i>
                                                            </a></td></tr>"; 
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