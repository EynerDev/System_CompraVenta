<?php
    require_once("../../Config/conn.php");
    require_once("../../Models/RolModel.php");

    $rol = new Rol();
    $datos = $rol->validar_acceso_rol($_SESSION["USER_ID"],"mntcompra");
    if (isset($_SESSION["USER_ID"])){
        if(is_array($datos) and count($datos)> 0){


?>


<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <title>EynerDev | Compra</title>
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
                                        <li class="breadcrumb-item active">Compra</li>
                                    </ol>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                            <!-- TODO: ID de compra -->
                             <input type="hidden" name="compra_id" id="compra_id">
                            <!-- TODO: Datos de pago -->
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Datos Pago</h4>
                                        </div><!-- end card header -->
                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-lg-4">
                                                        <h6 class="fw-semiboldT">Tipo Documento</h6>
                                                            <select class="js-example-basic-single" id="doc_id" name="doc_id">
                                                                <option selected>Seleccionar</option>
                                                            </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h6 class="fw-semibold">Metodo de Pago</h6>
                                                            <select class="js-example-basic-single" id="pago_id" name="pago_id">
                                                                <option selected>Seleccionar</option>
                                                            </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <h6 class="fw-semibold">Moneda Pago</h6>
                                                            <select class="js-example-basic-single" id="mon_id" name="mon_id">
                                                                <option selected>Seleccionar</option>
                                                            </select>                                                
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            <!-- TODO: Datos del proveedor -->
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Datos del proveedor</h4>
                                        </div><!-- end card header -->
                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-lg-4">
                                                        <h6 class="fw-semibold">Proveedor</h6>
                                                            <select class="js-example-basic-single" id="prov_id" name="prov_id">
                                                                <option selected>Seleccionar</option>
                                                            </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="basiInput" class="form-label">RUT</label>
                                                        <input type="number" class="form-control" id="prov_rut" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="basiInput" class="form-label">Dirección</label>
                                                        <input type="text" class="form-control" id="prov_direcc" readonly>                                                
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="basiInput" class="form-label">Correo</label>
                                                        <input type="text" class="form-control" id="prov_email" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="basiInput" class="form-label">Numero</label>
                                                        <input type="number" class="form-control" id="prov_number" readonly>                                                
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            <!-- TODO: Datos del producto -->
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Agregar Producto</h4>
                                        </div><!-- end card header -->
                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-lg-4">
                                                        <h6 class="fw-semibold">Categoria</h6>
                                                            <select class="js-example-basic-single" id="cat_id" name="cat_id">
                                                                <option selected>Seleccionar</option>
                                                            </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h6 class="fw-semibold">Producto</h6>
                                                            <select class="js-example-basic-single" id="prod_id" name="prod_id">
                                                                <option selected>Seleccionar</option>
                                                            </select>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="basiInput" class="form-label">Precio</label>
                                                        <input type="number" class="form-control" id="prod_pcompra">                                                
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="basiInput" class="form-label">UndMedida</label>
                                                        <input type="text" class="form-control" id="unid_medida" readonly>                                                
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="basiInput" class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control" id="prod_stock">                                                
                                                    </div>
                                                    
                                                    <div class="col-lg-3">  
                                                        <br>
                                                        <button type="submit"  name="action" value="add" id="btn_agregar" class="btn btn-secondary btn-label waves-effect waves-light"><i class="ri-add-circle-line label-icon align-middle fs-16 me-2"></i> Agregar</button>
                                                    </div>

                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            <!-- TODO: Datos de compra -->
                                <div class="col-lg-12">
                                    <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Datos de compra</h4>
                                    </div><!-- end card header -->
                                        <div class="card-body">
                                            <table id="table_datos" name="table_datos" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Categoria</th>
                                                        <th>Producto</th>
                                                        <th>Unidad</th>
                                                        <th>P.Compra</th>
                                                        <th>Cantidad</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>        
                                                </tbody>
                                            </table>
                                            
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" id="det_compra" style="width:250px">
                                                    <tbody>
                                                        <tr>
                                                            <td>Sub Total</td>
                                                            <td class="text-end" id="compra_sub_total">0.0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>IVA (19%)</td>
                                                            <td class="text-end" id="compra_iva">0.0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td class="text-end" id="compra_total">0.0</td>
                                                        </tr>
                                                        
                                                    </tbody>
                                            </table>
                                            <div class="mt-4">
                                                <label for="exampleFormControlTextarea1" class="form-label text-muted text-uppercase fw-semibold">NOTES</label>
                                                <textarea class="form-control alert alert-info" id="prov_coment" placeholder="Notes" rows="2" required=""></textarea>
                                            </div>
                                            <div class="hstack gap-2 left-content-end d-print-none mt-4">
                                                <button type="submit" id="btn_guardar" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Guardar</button>
                                                <a href="" id="btnlimpiar" class="btn btn-danger"><i class="ri-send-plane-fill align-bottom me-1"></i>Limpiar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>

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
    require_once("../html/js.php")
    ?>
    
    
    <script type="text/javascript" src="mntCompra.js"></script>
    
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