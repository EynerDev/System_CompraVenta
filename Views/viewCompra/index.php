<?php
    require_once("../../Config/conn.php");
    if (isset($_SESSION["USER_ID"])){
?>

<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <title>EynerDev | Usuario</title>
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
                    <div class="container-fluid" id="invoice_pdf">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Invoice Details</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Invoices</a></li>
                                            <li class="breadcrumb-item active">Invoice Details</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row justify-content-center">
                            <div class="col-xxl-9">
                                <div class="card" id="demo">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card-header border-bottom-dashed p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <img src="../../assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="17">
                                                        <img src="../../assets/images/logo-light.png" class="card-logo card-logo-light" alt="logo light" height="17">
                                                        <div class="mt-sm-5 mt-4">
                                                            <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                                                            <p class="text-muted mb-1" id="txt_dirc"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                        <h6><span class="text-muted fw-normal">No RUT: </span><span id="txt_rut"></span></h6>
                                                        <h6><span class="text-muted fw-normal">Email: </span><span id="txt_email"></span></h6>
                                                        <h6><span class="text-muted fw-normal">Sitio: </span><span id="txt_sitio"></span></h6>
                                                        <h6 class="mb-0"><span class="text-muted fw-normal">Contact No:  </span><span id="txt_number"></span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end card-header-->
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="card-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-lg-3 col-6">
                                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Invoice No</p>
                                                        <h5 class="fs-14 mb-0">#C-<span id="compra_id"></span></h5>
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-6">
                                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Fecha</p>
                                                        <h5 class="fs-14 mb-0"><span id="created_at"></h5>
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-6">
                                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Tipo de pago</p>
                                                        <span class="badge badge-soft-success fs-11" id="pago_id"></span>
                                                    </div>
                                                    <div class="col-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Moneda de pago</h6>
                                                    <p class="fw-medium mb-2" id="mon_name">David Nichols</p>
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-6">
                                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Total</p>
                                                        <h5 class="fs-14 mb-0">$<span id="compra_total"></span></h5>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-12">
                                        <div class="card-body p-4 border-top border-top-dashed">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Datos del usuario</h6>
                                                    <p class="fw-medium mb-2" id="user_name"></p><p class="fw-medium mb-2" id="user_ape"></p>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Datos del proveedor</h6>
                                                    <p class="fw-medium mb-2"id=""><span>Nombre: </span><span id="prov_name"></span></p>
                                                    <p class="fw-medium mb-2"><span>Dirección: </span><span id="prov_dirc"></span></p>
                                                    <p class="fw-medium mb-2"><span>Numero: </span><span id="prov_number"></span></p>
                                                    <p class="fw-medium mb-2"><span>Email: </span><span id="prov_email"></span></p>

                                                </div>
                                                
                                                
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                        <div class="col-lg-12">
                                            <div class="card-body p-4">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0" >
                                                        <thead>
                                                            <tr class="table-detail_pdf">
                                                                <th scope="col">Categoria</th>
                                                                <th scope="col">Producto</th>
                                                                <th scope="col">Unidad</th>
                                                                <th scope="col">Precio</th>
                                                                <th scope="col">Cantidad</th>
                                                                <th scope="col" class="text-end">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="list_detalles">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="border-top border-top-dashed mt-2">
                                                    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                        <tbody>
                                                            <tr>
                                                                <td>Sub Total</td>
                                                                <td id="sub_total"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>IVA (19%)</td>
                                                                <td id="compra_iva"></td>
                                                            </tr>
                                                            <tr class="border-top border-top-dashed fs-15">
                                                                <th scope="row">Total</th>
                                                                <th id="compra_total2"></th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                </div>
                                                
                                                <div class="mt-4">
                                                    <div class="alert alert-info">
                                                        <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                                            <span id="compra_coment">
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                                    <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        

                    </div>
                </div>
            </div>

    </div>
    <!-- END layout-wrapper -->



    <?php
    require_once("../html/butonTheme.php")
    ?>
    <?php
    require_once("../html/js.php")
    ?>
    
  <script type="text/javascript" src="viewCompra.js"></script>
    
</body>

</html>
<?php
}else{
    header("Location:".conectar::baseUrl()."Views/404/");
}
?>