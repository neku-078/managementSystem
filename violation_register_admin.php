<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    require_once("inc/db_connect.inc");
    if($_SESSION['login'] == false){
        header('Location:index.php');
    }
    if(isset($_POST['club_select'])) {
        $club_id = $_POST['club_select'];
    }
    else {
        $club_id = 0;
    }
?>
<script type="text/javascript">
    var club_id = '<?php echo $club_id; ?>';
</script>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>借用表單</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/main.min.css" rel="stylesheet">

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
                    <h1 class="h3 mb-4 text-gray-800">扣點登記</h1>
                    <?php
                    if($club_id) {
                        echo "<form method = 'post' action= 'sql/violation_register_admin_sql.php'>";
                    }
                    ?>
                        <div class="row">

                            <div class="col-lg-12">

                                <!-- 借用 -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">扣點資料</h6>
                                    </div>

                                    <form method = "post" action= "">
                                    <div class="card-body">
                                        <!-- 查詢社團ID -->
                                        <?php
                                        if(!$club_id) {
                                            echo "<form method = 'post' action= 'violation_register_admin.php'>";
                                        }
                                        ?>
                                            <div class="form-inline">
                                                <p >違規單位：
                                                    <select id="club_select" name="club_select" class="custom-select custom-select-sm col-md-10">
                                                        <option disabled selected value="-1"> -- 選擇單位 -- </option>
                                                        <?php
                                                            $sql = "SELECT Club_ID, Name FROM club;";
                                                            $result = mysqli_query($conn, $sql);
                                                            while($club_list = mysqli_fetch_row($result)) {
                                                                echo "<option value='".$club_list[0]."''>".$club_list[1]."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <button class="btn btn-primary btn-sm form-control-sm" type="submit" id="search" name="search">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </p>
                                            </div>
                                        <?php
                                            if(!$club_id) {
                                                echo "</form>";
                                            }
                                        ?>
                                        <div class="form-inline">
                                            <p>違規借用單號：
                                                <select id="borrowing_list_select" name="borrowing_list_select" class="custom-select custom-select-sm" disabled>
                                                    <option disabled selected value="-1"> -- 選擇借用單 -- </option>
                                                    <?php
                                                        if($club_id) {
                                                            $sql = "SELECT Borrowing_list_ID, Borrow_date, Return_date FROM borrowing_list WHERE Club_ID ='".$club_id."';";
                                                            $result = mysqli_query($conn, $sql);
                                                            while($borrow_list = mysqli_fetch_row($result)) {
                                                                echo "<option value='".$borrow_list[0]."'>[".$borrow_list[0]."] ".date('Y-m-d', strtotime($borrow_list[1]))." ~ ".date('Y-m-d', strtotime($borrow_list[2]))."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </p>
                                        </div>
                                        <div class="form-inline">
                                            <p>事由：
                                                <select id="rov_select" name="rov_select" class="custom-select custom-select-sm" disabled>
                                                    <option disabled selected value="-1"> -- 選擇事由 -- </option>
                                                    <?php 
                                                        $sql = "select Rov_ID, Reason from reason_of_violation"; 
                                                        $result = mysqli_query($conn,$sql);
                                                        $Rov_data = mysqli_fetch_array($result);
                                                        while($Rov_data){
                                                        echo "<option value=".$Rov_data[0].">".$Rov_data[1]."</option>"; 
                                                        $Rov_data = mysqli_fetch_row($result); 
                                                        }
                                                    ?> 
                                                </select>
                                            </p>
                                        </div>
                                        
                                        <!-- 確認按鈕 -->
                                        <button type="submit" name="submit" id="check_info" class="btn btn-primary btn-icon-split float-right">
                                            <span class="text">送出違規單</span>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-angle-double-right"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" id="equipment_array" name="equipment_array" style="width:500px">
                            </div>
                            <!-- 載入預設值 -->
                            
                            <script type="text/javascript">
                                if(club_id != '0') {
                                    var options = document.getElementById('club_select').getElementsByTagName("option");
                                    for(var i = 0; i < options.length; i++) {
                                        if(options[i].value == club_id) {
                                            options[i].selected = true;
                                            break;
                                        }
                                    }
                                    //document.getElementById('club_select').disabled = true;
                                    document.getElementById('search').disabled = true;
                                    document.getElementById('search').style.display = 'none';
                                    document.getElementById('borrowing_list_select').disabled = false;
                                    document.getElementById('rov_select').disabled = false;
                                }
                            </script>
                            <!-- 載入預設值End -->
                        </div>
                    <?php
                        if($club_id) {
                            echo "</from>";
                        }
                    ?>
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