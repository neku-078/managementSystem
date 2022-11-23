<!-- Sidebar -->
<?php
    echo '<ul class="navbar-nav bg-gray-800 sidebar sidebar-dark accordion" id="accordionSidebar">' .

            #Sidebar - Brand
            '<a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard_'.$_SESSION['identity'].'.php">' .
                '<div class="sidebar-brand-icon rotate-n-15">' .
                    '<i class="fas fa-laugh-wink"></i>' .
                '</div>' .
                '<div class="sidebar-brand-text mx-3">器材管理系統</div>' .
            '</a>' .

            #Divider
            '<hr class="sidebar-divider my-0">' .

            #Nav Item - Dashboard
            '<li class="nav-item active">' .
                '<a class="nav-link" href="dashboard_'.$_SESSION['identity'].'.php">' .
                    '<i class="fas fa-fw fa-tachometer-alt"></i>' .
                    '<span>Dashboard</span></a>' .
            '</li>' .

            #Divider
            '<hr class="sidebar-divider">' .

            #Heading
            '<div class="sidebar-heading">' .
                '借用' .
            '</div>' .

            #借用單（藍單）
            '<li class="nav-item">' .
                '<a class="nav-link" href="borrowing_'.$_SESSION['identity'].'.php">' .
                    '<i class="fas fa-fw fa-clipboard-list"></i>' .
                    '<span>借用單（藍單）</span></a>' .
            '</li>';

            //管理員專用
            if($_SESSION['identity'] == 'admin') {
                //器材
                echo '<hr class="sidebar-divider">' .

                #Heading
                '<div class="sidebar-heading">' .
                    '管理' .
                '</div>' .
                '<li class="nav-item">' .
                '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"' .
                    'aria-expanded="true" aria-controls="collapseUtilities">' .
                    '<i class="fas fa-fw fa-wrench"></i>' .
                    '<span>器材</span>' .
                '</a>' .
                '<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"' .
                    'data-parent="#accordionSidebar">' .
                    '<div class="bg-white py-2 collapse-inner rounded">' .
                        '<h6 class="collapse-header">器材相關:</h6>' .
                        '<a class="collapse-item" href="equipment_manage_admin.php">器材總表</a>' .
                    '</div>' .
                '</div>' .
            '</li>' .

            #社團
            '<li class="nav-item">' .
                '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"' .
                    'aria-expanded="true" aria-controls="collapseTwo">' .
                    '<i class="fas fa-fw fa-cog"></i>' .
                    '<span>社團</span>' .
                '</a>' .
                '<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">' .
                    '<div class="bg-white py-2 collapse-inner rounded">' .
                        '<h6 class="collapse-header">社團相關:</h6>' .
                        '<a class="collapse-item" href="violation_records_admin.php">違規扣點紀錄</a>' .
                        '<a class="collapse-item" href="violation_register_admin.php">扣點登記</a>' .
                    '</div>' .
                '</div>' .
            '</li>' ;
            }

            #Divider
            echo '<hr class="sidebar-divider">' .

            #Heading
            '<div class="sidebar-heading">' .
                '總覽' .
            '</div>' .

            #借用總覽
            '<li class="nav-item">' .
                '<a class="nav-link" href="equipment_loan.php">' .
                    '<i class="fas fa-fw fa-table"></i>' .
                    '<span>借用總覽</span></a>' .
            '</li>' .

            #Divider
            '<hr class="sidebar-divider d-none d-md-block">' .

            #Sidebar Toggler (Sidebar)
            '<div class="text-center d-none d-md-inline">' .
                '<button class="rounded-circle border-0" id="sidebarToggle"></button>' .
            '</div>' .

            #Sidebar Message
            #'<div class="sidebar-card d-none d-lg-flex">' .
            #   ' <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">' .
            #   ' <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>' .
            #    '<a class="btn btn-success btn-sm" href="https:#startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>' .
            #'</div>' .

        '</ul>';
?>
<!-- End of Sidebar -->