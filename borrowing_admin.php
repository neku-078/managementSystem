<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    require_once("inc/db_connect.inc");
    if($_SESSION['login'] == false){
        header('Location:index.php');
    }
    $check_info = 0;
    if(isset($_GET['borrow_id'])) {
        $borrow_id = $_GET['borrow_id'];
    }
    else {
        $borrow_id = 0;
        //確認借用資訊後跳轉
        if(isset($_POST['check_info'])) {
            //防呆
            //club
            if(isset($_POST["club_select"])){
                $club_id = $_POST["club_select"];
            } else {
                echo "<script>
                    answer = confirm(\"請選擇借用單位\");
                    if (answer)
                        javascript:history.go(-1);
                    </script>";
                exit();
            }

            //borrow date
            if(isset($_POST["borrow_date"]) && $_POST["borrow_date"]!="")
                $borrow_date = $_POST["borrow_date"];
            else {
                echo "<script>
                    answer = confirm(\"請選擇領取日期\");
                    if (answer)
                        javascript:history.go(-1);
                    </script>";
                exit();
            }

            //return date
            if(isset($_POST["return_date"]) && $_POST["return_date"]!=""){
                if($borrow_date > $_POST["return_date"]){
                    echo "<script>
                        answer = confirm(\"領取日期不得在歸還日期之後\");
                        if (answer)
                            javascript:history.go(-1);
                        </script>";
                    exit();
                } else if($borrow_date == $_POST["return_date"]){
                    echo "<script>
                        answer = confirm(\"領取日期不得與歸還日期相同\");
                        if (answer)
                            javascript:history.go(-1);
                        </script>";
                    exit();
                } else if(date("Y-m-d",strtotime($borrow_date."+1 week")) < $_POST["return_date"]){
                    echo "<script>
                        answer = confirm(\"借用時間上限為七天\");
                        if (answer)
                            javascript:history.go(-1);
                        </script>";
                    exit();
                } else
                    $return_date = $_POST["return_date"];
            } else {
                echo "<script>
                    answer = confirm(\"請選擇歸還日期\");
                    if (answer)
                        javascript:history.go(-1);
                    </script>";
                exit();
            }

            //event space
            if(isset($_POST["event_space"]))
                $sp = $_POST["event_space"];
            else {
                echo "<script>
                    answer = confirm(\"請選擇活動地點\");
                    if (answer)
                        javascript:history.go(-1);
                    </script>";
                exit();
            }
            //防呆結束
            $check_info = 1;
            $club_id = $_POST['club_select'];
            $borrow_date = $_POST['borrow_date'];
            $return_date = $_POST['return_date'];
            $place_select = $_POST['event_space'];

        }
        else {
            $check_info = 0;
            $borrow_date = 0;
            $return_date = 0;
            $place_select = 0;
        }
    }
?>
<script type="text/javascript">
    var borrow_id = '<?php echo $borrow_id; ?>';
    var check_info = '<?php echo $check_info; ?>';
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

    <script src="js/equipment_table.js"></script>
    <script src="js/date_format.js"></script>
    <script src="js/date_add_days.js"></script>

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
                    <h1 class="h3 mb-4 text-gray-800">借用表單</h1>
                    <?php
                        if($check_info || $borrow_id) {
                            echo "<form  method='post' action='sql/borrowing_admin_sql.php?borrow_id=".$borrow_id."'>";
                        }
                    ?>
                        <div class="row">

                            <div class="col-lg-6">

                                <!-- 借用 -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">借用資訊</h6>
                                    </div>
                                    <div class="card-body">
                                    <?php
                                        if(!$check_info && !$borrow_id) {
                                            echo "<form action='borrowing_admin.php' method='post'>";
                                        }
                                    ?>
                                        <div class="form-inline">
                                            <p>借用單位：
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
                                            </p>
                                        </div>
                                        <p>領取時間：<input id="borrow_date" name="borrow_date" type="date" class="custom-select custom-select-sm" style="width: 200px;"></p>
                                        <p>歸還時間：<input id="return_date" name="return_date" type="date" class="custom-select custom-select-sm" style="width: 200px;"></p>
                                        <script type="text/javascript">
                                            var today = new Date();
                                            var min = new Date(today.add_days(3)).toISOString().split('T')[0];
                                            var max = new Date(today.add_days(30)).toISOString().split('T')[0];
                                            document.getElementById("borrow_date").setAttribute("min", min);
                                            document.getElementById("borrow_date").setAttribute("max", max);
                                            document.getElementById("return_date").setAttribute("min", min);
                                            document.getElementById("return_date").setAttribute("max", max);
                                        </script>
                                        <div class="form-inline">
                                            <p>活動地點：
                                                <!-- 這邊用sql寫項目進來 -->
                                                <select id="place_select" name="event_space" class="custom-select custom-select-sm">
                                                    <option disabled selected value> -- 選擇地點 -- </option>
                                                    <?php 
                                                    $sql = "select Space_ID, Name from event_space"; 
                                                    $result = mysqli_query($conn,$sql);
                                                    $space_data = mysqli_fetch_array($result);
                                                        while($space_data){
                                                        echo "<option value=".$space_data[0].">".$space_data[1]."</option>"; 
                                                           $space_data = mysqli_fetch_row($result); 
                                                        }
                                                    ?>
                                                </select>
                                            </p>
                                        </div>

                                        <div class="form-inline">
                                            <p>出借人：
                                                <!-- 這邊用sql寫項目進來 -->
                                                <select id="lender_select" name="lender" class="custom-select custom-select-sm" disabled>
                                                    <option disabled selected value> -- 選擇人員 -- </option>
                                                    <?php 
                                                    $sql = "select Stu_ID, Name from admin"; 
                                                    $result = mysqli_query($conn,$sql);
                                                    $admin_data = mysqli_fetch_array($result);
                                                        while($admin_data){
                                                        echo "<option value=".$admin_data[0].">".$admin_data[1]."</option>"; 
                                                            $admin_data = mysqli_fetch_row($result); 
                                                        }
                                                    ?> 
                                                </select>
                                            </p>
                                        </div>

                                        <div class="form-inline">
                                            <p>盤收人：
                                                <!-- 這邊用sql寫項目進來 -->
                                                <select id="inventory_select" name="inventory" class="custom-select custom-select-sm" disabled>
                                                    <option disabled selected value> -- 選擇人員 -- </option>
                                                    <?php 
                                                    $sql = "select Stu_ID, Name from admin"; 
                                                    $result = mysqli_query($conn,$sql);
                                                    $admin_data = mysqli_fetch_array($result);
                                                        while($admin_data){
                                                        echo "<option value=".$admin_data[0].">".$admin_data[1]."</option>"; 
                                                            $admin_data = mysqli_fetch_row($result); 
                                                        }
                                                    ?>
                                                </select>
                                            </p>
                                        </div>
                                        
                                        <!-- 左邊確認按鈕 -->
                                        <button type="check_info" name="check_info" id="check_info" class="btn btn-primary btn-icon-split float-right">
                                            <span class="text">確認借用資訊</span>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-angle-double-right"></i>
                                            </span>
                                        </button>
                                    <?php
                                        if(!$check_info && !$borrow_id) {
                                            echo "</form>";
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">

                                <!-- 借用器材 -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">借用器材</h6>
                                    </div>
                                    <div class="card-body form-inline" style="display: inline-block;">
    									<div>
    										<p>
    											項目：
    											<!-- 這邊用sql寫項目進來 -->
    											<select id="equipment_select" name="dataTable_length" class="custom-select custom-select-sm" disabled text="" onchange="equipment_select_change()">
    												<option disabled selected value> -- 選擇器材 -- </option>
    												<?php 
                                                        if($check_info) {
                                                            //選該時段可借用的器材及數量
                                                            $sql_equipment_list = "(SELECT `Equipment_ID`, `Name`, `Amount` AS Borrowable_amount FROM equipment_list WHERE equipment_id NOT IN(SELECT DISTINCT Equipment_ID FROM equipment_list LEFT JOIN equipment_borrowed on equipment_borrowed.Equipment_list_ID = equipment_list.Equipment_ID LEFT JOIN borrowing_list ON equipment_borrowed.Borrowing_list_ID = borrowing_list.Borrowing_list_ID WHERE (CAST(Borrow_date AS DATE) >= CAST('".$borrow_date."' AS DATE) AND CAST(Borrow_date AS DATE) < CAST('".$return_date."' AS DATE)) OR (CAST(Return_date AS DATE) > CAST('".$borrow_date."' AS DATE) AND CAST(Return_date AS DATE) < CAST('".$return_date."' AS DATE)) OR (CAST(Borrow_date AS DATE) <= CAST('".$borrow_date."' AS DATE) AND CAST(Return_date AS DATE) >= CAST('".$return_date."' AS DATE))) AND Borrowable=1 AND Broken=0) UNION (SELECT `Equipment_ID`,  `Name`, Amount-SUM(`Equipment_amount`) AS Borrowable_amount FROM equipment_borrowed LEFT JOIN equipment_list ON equipment_borrowed.Equipment_list_ID = equipment_list.Equipment_ID LEFT JOIN borrowing_list ON equipment_borrowed.Borrowing_list_ID = borrowing_list.Borrowing_list_ID WHERE   NOT ((CAST(Borrow_date AS DATE) < CAST('".$borrow_date."' AS DATE) AND CAST(Return_date AS DATE) <= CAST('".$borrow_date."' AS DATE)) OR (CAST(Borrow_date AS DATE) >= CAST('".$return_date."' AS DATE) AND CAST(Return_date AS DATE) > CAST('".$return_date."' AS DATE))) AND Borrowable=1 AND Broken=0 GROUP BY Equipment_ID HAVING Borrowable_amount>0) ORDER BY Name"; 
                                                            $result = mysqli_query($conn,$sql_equipment_list);
                                                            $equipment_data = mysqli_fetch_array($result, MYSQLI_NUM);  //[0]ID; [1]Name; [2]Amount
                                                                while($equipment_data){
                                                                echo "<option value=".$equipment_data[0].">".$equipment_data[1]."</option>"; 
                                                                    $equipment_amount[$equipment_data[0]] = $equipment_data[2];
                                                                    $equipment_data = mysqli_fetch_row($result); 
                                                                }
                                                            }
                                                        ?>
    											</select>
    											&nbsp;
    											數量：
                                                <select id="equipment_amount" name="equipment_amount" class="custom-select custom-select-sm col-md-2" disabled>
                                                </select>
    											<button id="add_equipment" class="btn btn-secondary form-control-sm" type="button">
    												<span class="icon">
    													<i class="fas fa-arrow-right"></i>
    												</span>
    											</button>
                                                <p id="borrowable_amount">可借數量：</p>
                                                <script type="text/javascript">
                                                    function equipment_select_change() {
                                                        var equipment_select = document.getElementById("equipment_select");
                                                            var equipment_id = equipment_select.options[equipment_select.selectedIndex].value;
                                                            var equipment_amount = <?php echo json_encode($equipment_amount); ?>;
                                                            equipment_select.text = equipment_select.options[equipment_select.selectedIndex].text;
                                                            document.getElementById("borrowable_amount").innerText = "可借數量：" + equipment_amount[equipment_id];
                                                            var amount_select = document.getElementById('equipment_amount');
                                                            //options歸零
                                                            amount_select.options.length = 0;
                                                            //新增options
                                                            for(var i = 0; i < equipment_amount[equipment_id]; i++) {
                                                                amount_select.add(new Option(i+1, i+1));
                                                            }
                                                    }
                                                </script>
    										</p>
    										<div class="table-responsive table-responsive-sm">
    											<table id="equipment_list" class="table table-bordered" width="100">
    												<thead>
    													<tr>
    														<th width="20">ID</th>
                                                            <th width="65">名稱</th>
                                                            <th width="15">數量</th>
                                                            <th width="5"></th>
    													</tr>
    												</thead>
    												<tbody>
    													<!-- js寫進來 -->
    												</tbody>
    											</table>
    										</div>
    									</div>

                                        <!-- 右邊送出按鈕 -->
                                        <button type="submit" id="submit" class="btn btn-success btn-icon-split float-right" style="display: none;" disabled>
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">送出借用表單</span>
                                        </button>
    								</div>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" id="equipment_array" name="equipment_array" style="width:500px">
                            </div>
                            <!-- 載入預設值 -->
                            <script type="text/javascript">
                                if(check_info != '0') {
                                    var club_id = '<?php echo $club_id; ?>';
                                    var borrow_date = '<?php echo $borrow_date; ?>';
                                    var return_date = '<?php echo $return_date; ?>';
                                    var place_select = '<?php echo $place_select; ?>';
                                    //填入欄位資訊
                                    var options = document.getElementById('club_select').getElementsByTagName("option");
                                    for(var i = 0; i < options.length; i++) {
                                        if(options[i].value == club_id) {
                                            options[i].selected = true;
                                            break;
                                        }
                                    }
                                    document.getElementById('borrow_date').value = new Date(borrow_date).toISOString().split('T')[0];
                                    document.getElementById('return_date').value = new Date(return_date).toISOString().split('T')[0];
                                    var options = document.getElementById('place_select').getElementsByTagName("option");
                                    for(var i = 0; i < options.length; i++) {
                                        if(options[i].value == place_select) {
                                            options[i].selected = true;
                                            break;
                                        }
                                    }
                                    //鎖定左邊欄位
                                    document.getElementById('borrow_date').setAttribute('readOnly', 'true');
                                    document.getElementById('return_date').setAttribute('readOnly', 'true');
                                    //document.getElementById('place_select').disabled = true;
                                    document.getElementById('check_info').disabled = true;
                                    document.getElementById('check_info').style.display = 'none';
                                    //解鎖右邊欄位
                                    document.getElementById('submit').disabled = false;
                                    document.getElementById('submit').style.display = 'block';
                                    document.getElementById('equipment_select').disabled = false;
                                    document.getElementById('equipment_amount').disabled = false;
                                    document.getElementById('add_equipment').disabled = false;
                                }
                            </script>
                            <?php
                                if($borrow_id) {
                                    $sql = "SELECT Club_ID, Borrow_date, Return_date, Space_ID, Lender_ID, Inventory_ID FROM borrowing_list where Borrowing_list_ID = ".$borrow_id.";";
                                    if($result = mysqli_query($conn, $sql)) {
                                        $borrow_data = mysqli_fetch_array($result);
                                    }
                                    else {
                                        echo "sql error!";
                                    }
                                    $sql = "SELECT Equipment_list_ID, Name, Equipment_amount FROM equipment_borrowed LEFT JOIN equipment_list ON equipment_list.Equipment_ID = equipment_borrowed.Equipment_list_ID WHERE borrowing_list_ID = ".$borrow_id.";";
                                    if($result = mysqli_query($conn, $sql)) {
                                        $equipment_data = array();
                                        while($equipment_data_row = mysqli_fetch_row($result)) {
                                            array_push($equipment_data, ($equipment_data_row));
                                        }
                                    }
                                    else {
                                        echo "sql error!";
                                    }
                                }
                            ?>
                            <script type="text/javascript">
                                if(borrow_id != '0') {
                                    var borrow_data = <?php echo json_encode($borrow_data); ?>;
                                    //[0]club_id; [1]borrow_date; [2]return_date; [3]space_id; [4]lender_id; [5]inventory_id
                                    var equipment_data = <?php echo json_encode($equipment_data); ?>;
                                    //[['ID', 'Name', 'amount'], ['ID', 'Name', 'amount']...]
                                    //equipment_data[i][0] = ID; [1] = name; [2] = amount
                                    //document.getElementById('borrow_id').value = borrow_data[0];
                                    var options = document.getElementById('club_select').getElementsByTagName("option");
                                    for(var i = 0; i < options.length; i++) {
                                        if(options[i].value == borrow_data[0]) {
                                            options[i].selected = true;
                                            break;
                                        }
                                    }
                                    document.getElementById('borrow_date').value = new Date(borrow_data[1]).toISOString().split('T')[0];
                                    document.getElementById('return_date').value = new Date(borrow_data[2]).toISOString().split('T')[0];
                                    var options = document.getElementById('place_select').getElementsByTagName("option");
                                    for(var i = 0; i < options.length; i++) {
                                        if(options[i].value == borrow_data[3]) {
                                            options[i].selected = true;
                                            break;
                                        }
                                    }
                                    if (borrow_data[4]) {
                                        options = document.getElementById('lender_select').getElementsByTagName("option");
                                        for(var i = 0; i < options.length; i++) {
                                            if(options[i].value == borrow_data[4]) {
                                                options[i].selected = true;
                                                break;
                                            }
                                        }
                                    }
                                    if (borrow_data[5]) {
                                        options = document.getElementById('inventory_select').getElementsByTagName("option");
                                        for(var i = 0; i < options.length; i++) {
                                            if(options[i].value == borrow_data[5]) {
                                                options[i].selected = true;
                                                break;
                                            }
                                        }
                                    }
                                    for(var i = 0; i < equipment_data.length; i++) {
                                        //物件放入equipment_array
                                        equipment_array.push({id:equipment_data[i][0], amount:equipment_data[i][2]});
                                        //寫入equipment_table
                                        //建立一個tr
                                        var tr=document.createElement("tr");
                                        tr.id=equipment_data[i][0];
                                        //向tr中新增內容
                                        tr.innerHTML="<td>"+equipment_data[i][0]+"</td>"+
                                                        "<td>"+equipment_data[i][1]+"</td>"+
                                                        "<td>"+equipment_data[i][2]+"</td>"+
                                                        "<td><a href='javascript:;' class='btn btn-sm btn-danger'>"+
                                                        "<span class='icon'>"+
                                                        "<i class='fas fa-trash'></i>"+
                                                        "</span></a></td>";
                                        var a=tr.getElementsByTagName("a")[0];
                                        a.onclick=delA;
                                        //把tr放在table中
                                        var equipmentList=document.getElementById("equipment_list");
                                        //獲取tbody
                                        var tbody=document.getElementsByTagName("tbody")[0];

                                        tbody.appendChild(tr);
                                        document.getElementById("equipment_array").value = JSON.stringify(equipment_array);
                                        //鎖定確認資訊
                                        document.getElementById('check_info').disabled = true;
                                        document.getElementById('check_info').style.display = 'none';
                                        //解鎖出借/借用人/右邊欄位
                                        document.getElementById('lender_select').disabled = false;
                                        document.getElementById('inventory_select').disabled = false;
                                        document.getElementById('equipment_select').disabled = false;
                                        document.getElementById('equipment_amount').disabled = false;
                                        document.getElementById('add_equipment').disabled = false;
                                        document.getElementById('submit').disabled = false;
                                        document.getElementById('submit').style.display = 'block';
                                    }
                                }
                            </script>
                            <!-- 載入預設值End -->
                        </div>
                    <?php
                        if($check_info || $borrow_id) {
                            echo "</form>";
                        }
                    ?>

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