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

    $eq_id = $_GET['eq_id'];
    if($eq_id == "EQ0000")
        $eq= array("","","","","","","","","","","");
    else {
        $sql = 'select IFNULL(`Equipment_ID`, "")Equipment_ID, IFNULL(`Classification_number`, "")Classification_number, IFNULL(`Serial_number`, "")Serial_number, IFNULL(`Name`, "")Eq_name, IFNULL(`Amount`, "")Amount, IFNULL(`Warehouse_ID`, "")Warehouse_ID, IFNULL(`Price`, "")Price, IFNULL(`Principal_ID`, "")Principal_ID, IFNULL(`Remark`, "")Remark, IFNULL(`Borrowable`, "")Borrowable, IFNULL(`Broken`, "")Broken from equipment_list where `Equipment_ID`="'.$eq_id.'"';
        $query = mysqli_query($conn, $sql);        
        $eq = mysqli_fetch_row($query);
    }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>器材編輯</title>

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
                        <h1 class="h3 mb-0 text-gray-800">器材編輯</h1>
                    </div>

                    <!-- Equipment Table -->
                    <div class="row">
                            <div class="col-lg-12">
                                <!-- 個人資料 -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">器材資料</h6>
                                    </div>
                                    <div class="card-body">
                                        <form
                                        <?php
                                            if($eq_id == "EQ0000")
                                                echo 'action="sql/equipment_insert_sql.php"';
                                            else
                                                echo 'action="sql/equipment_edit_sql.php?eq_id='.$eq_id.'"';
                                        ?>
                                        method="post">
                                            <div class="form-inline" style="display: inline-block;">
                                                <p>
                                                    器材編號：<?php echo $eq[0]; ?>
                                                    &nbsp;
                                                </p>
                                            </div>
                                            <div class="form-inline">
                                                <p>財產編號：<input type="text" class="form-control form-control-sm bg-light col-md-10" value="<?php echo $eq[1]; ?>" name="classification_number"></p>
                                            </div>
                                            <div class="form-inline">
                                                <p>序列編號：<input type="text" class="form-control form-control-sm bg-light col-md-10" value="<?php echo $eq[2]; ?>" name="serial_number"></p>
                                            </div>
                                            <div class="form-inline">
                                                <p>器材名稱：<input type="text" class="form-control form-control-sm bg-light" style="width:500px" value="<?php echo $eq[3]; ?>" name="name"></p>
                                            </div>
                                            <div class="form-inline">
                                                <p>數量：<input type="text" class="form-control form-control-sm bg-light col-md-5" value="<?php echo $eq[4]; ?>" name="amount"></p>
                                            </div>
                                            <div class="form-inline">
                                                <p>價格：<input type="text" class="form-control form-control-sm bg-light col-md-5"/ value="<?php echo $eq[6]; ?>" name="price"></p>
                                            </div>
                                            <div class="form-inline">
                                                <p>存放地點：
                                                    <select id="wr" name="wh" class="custom-select custom-select-sm">
                                                        <?php
                                                        if($eq_id == "EQ0000" || $eq[5] == NULL)
                                                            echo '<option readonly selected value = "-1"> -- 選擇地點 -- </option>';
                                                        $sql = "select `Warehouse_ID`, `Name` from warehouse";
                                                        $query = mysqli_query($conn, $sql);
                                                        $wh = mysqli_fetch_array($query);
                                                            while($wh){
                                                                echo "<option value=". $wh[0];
                                                                if($wh[0] == $eq[5])
                                                                    echo " selected";
                                                                echo ">". $wh[1] ."</option>"; 
                                                                    $wh = mysqli_fetch_row($query);
                                                            }
                                                        ?>  
                                                    </select>
                                                </p>
                                            </div>
                                            <div class="form-inline">
                                                <p>保管者：
                                                    <select id="pr" name="pr" class="custom-select custom-select-sm">
                                                        <?php
                                                        if($eq_id == "EQ0000" || $eq[7] == NULL)
                                                            echo '<option readonly selected value = "-1"> -- 選擇保管人 -- </option>';
                                                        $sql = "select `Principal_ID`, `Name` from principal";
                                                        $query = mysqli_query($conn, $sql);
                                                        $pr = mysqli_fetch_array($query);
                                                            while($pr){
                                                                echo "<option value=". $pr[0];
                                                                if($pr[0] == $eq[7])
                                                                    echo " selected";
                                                                echo ">". $pr[1] ."</option>"; 
                                                                    $pr = mysqli_fetch_row($query);
                                                            }
                                                        ?>
                                                    </select>
                                                </p>
                                            </div>
                                            <div class="input-group" style="height: 25px; margin-bottom: 15px; display: flex;">
                                                <p style="align-self: center;">借用狀態：</p>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="borrow_state"
                                                    <?php if($eq[9] == 1){echo "checked";}?> name="borrow_state" value="Yes">
                                                    <label class="custom-control-label" for="borrow_state">可借用</label>
                                                </div>
                                            </div>
                                            <div class="input-group" style="height: 25px; margin-bottom: 15px; display: flex;">
                                                <p style="align-self: center;">損壞狀態：</p>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="broken_state"
                                                    <?php if($eq[10] == 1){echo "checked";}?> name="broken_state" value="Yes">
                                                    <label class="custom-control-label" for="broken_state">已損壞</label>
                                                </div>
                                            </div>
                                            <div class="form-inline">
                                                <p>備註：<input type="text" class="form-control form-control-sm bg-light col-md-10" value="<?php echo $eq[8]; ?>" name="remark"></p>
                                            </div>
                                            <!--//確定修改-->
                                            <a href="equipment_manage_admin.php" class="btn btn-danger btn-icon-split float-right">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <span class="text">取消修改</span>
                                            </a>
                                            <button type="submit" class="btn btn-success btn-icon-split float-right" name="confirm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">確認修改</span>
                                            </button>
                                        </form>
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