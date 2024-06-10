<!-- ========== App Menu ========== -->
<?php
require_once("../../Models/MenuModel.php");
$menu = new Menu;
$datos = $menu->get_menu_role_id($_SESSION["USER_ROLE_ID"]);
// echo  json_decode($datos)

?>
<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="../../assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="../../assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../../assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="../../assets/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <?php
                            foreach($datos as $row){
                                if ($row["MEND_GROUP"]=="Dashboard" &&  $row["MEND_PERMISO"]=="SI"){
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]?>" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                                <i class="<?php echo $row["ICON"]?>"></i> <span data-key="t-dashboards"><?php echo $row["MEN_NAME"]?></span>
                                            </a>
                                        </li>

                                    <?php

                                }
                            }
                        
                        ?>
                    
                        <li class="menu-title"><span data-key="t-menu">Mantenimiento</span></li>
                        <?php
                            foreach($datos as $row){
                                if ($row["MEND_GROUP"]=="Mantenimiento" &&  $row["MEND_PERMISO"]=="SI"){
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]?>" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                                <i class="<?php echo $row["ICON"]?>"></i> <span data-key="t-dashboards"><?php echo $row["MEN_NAME"]?></span>
                                            </a>
                                        </li>

                                    <?php

                                }
                            }
                        
                        ?>
                        <li class="menu-title"><span data-key="t-menu">Compra</span></li>
                        <?php
                            foreach($datos as $row){
                                if ($row["MEND_GROUP"]=="Compra" &&  $row["MEND_PERMISO"]=="SI"){
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]?>" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                                <i class="<?php echo $row["ICON"]?>"></i> <span data-key="t-dashboards"><?php echo $row["MEN_NAME"]?></span>
                                            </a>
                                        </li>

                                    <?php

                                }
                            }
                        
                        ?>
                        <li class="menu-title"><span data-key="t-menu">Venta</span></li>
                        <?php
                            foreach($datos as $row){
                                if ($row["MEND_GROUP"]=="Venta" &&  $row["MEND_PERMISO"]=="SI"){
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link menu-link" href="<?php echo $row["MEN_RUTA"]?>" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                                <i class="<?php echo $row["ICON"]?>"></i> <span data-key="t-dashboards"><?php echo $row["MEN_NAME"]?></span>
                                            </a>
                                        </li>

                                    <?php

                                }
                            }
                        
                        ?>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>