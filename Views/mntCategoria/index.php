<?php
    require_once("../../Config/conn.php");
    require_once("../../Models/RolModel.php");

    $rol = new Rol();
    $datos = $rol->validar_acceso_rol($_SESSION["USER_ID"],"mntcategoria");
    if (isset($_SESSION["USER_ID"])){
        if(is_array($datos) and count($datos)> 0){


?>
<!doctype html>
<?php require_once("../html/html_head.php"); ?>

<head>

    <title>EynerDev | Categoria</title>
    <?php
    require_once("../html/head.php")    

    ?>
 

</head>

<body>

    <div id="layout-wrapper">
    <?php
        require_once("../html/header.php")
        ?>
        
        <?php
        require_once("../html/menu.php")
        ?>
        
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Mantenimiento</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="">Mantenimiento</a></li>
                                        <li class="breadcrumb-item active">Categoria</li>
                                    </ol>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <!-- Grids in modals -->
                                            <button type="button" id="btn_nuevo" name="btn_nuevo" class="btn btn-info btn-label waves-effect waves-light">
                                                <i class="ri-add-circle-fill label-icon align-middle fs-16 me-2"></i> Nuevo Registro
                                            </button>
                                            
                                        <div class="card-body">
                                            <table id="table_datos" name="table_datos" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Fecha de Creación</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->

                        </div>
                    </div>
                    <!-- end page title -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php
            require_once("../html/footer.php")
            ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <?php
    require_once("../html/butonTheme.php")
    ?>

    <?php
    require_once("ModalCategoria.php")
    ?>

    <?php
    require_once("../html/js.php")
    ?>
    
    <script type="text/javascript" src="mntCategoria.js"></script>
    
</body>

</html>
<?php
        }else{
        
            header("Location:".conectar::baseUrl()."Views/404/");

        }
    }else{
        header("Location:".conectar::baseUrl()."Views/404/");
    }
?>