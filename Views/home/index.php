<?php
    require_once("../../config/conn.php");
    require_once("../../models/RolModel.php");
    $rol = new Rol();
    $datos = $rol->validar_acceso_rol($_SESSION["USER_ID"],"dashboard");
    if(isset($_SESSION["USER_ID"])){
        if(is_array($datos) and count($datos)>0){

            require_once("../../models/ProductoModel.php");
            $producto = new Producto();
            $datos_producto=$producto->get_producto_sucursal_id($_SESSION["SUC_ID"]);

            require_once("../../models/CategoriaModel.php");
            $categoria = new Categoria();
            $datos_categoria=$categoria->get_categoria_suc_id($_SESSION["SUC_ID"]);

            require_once("../../models/ClienteModel.php");
            $cliente = new Cliente();
            $datos_cliente=$cliente->get_cliente_empresa_id($_SESSION["EMP_ID"]);

            require_once("../../models/ProveedorModel.php");
            $proveedor = new Proveedor();
            $datos_proveedor=$proveedor->get_proveedor_empresa_id($_SESSION["EMP_ID"]);
?>

<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <title>EynerDev | Home</title>
    <?php require_once("../html/head.php"); ?>

    <!-- jsvectormap css -->
    <link href="../../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="../../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div id="layout-wrapper">

        <?php require_once("../html/header.php"); ?>

        <?php require_once("../html/menu.php"); ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">

                            <div class="h-100">

                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">Buen dia, <?php echo $_SESSION["USER_NAME"]?>!</h4>
                                                <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                                            </div>
                                            <div class="mt-3 mt-lg-0">

                                                <form action="javascript:void(0);">
                                                    <div class="row g-3 mb-0 align-items-center">

                                                        <div class="col-auto">
                                                            <a href="../MntProducto/" type="button" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Agregar Producto</a>
                                                        </div>

                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                                                        </div>

                                                    </div>
                                                 
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- TODO: Total de Productos -->
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Productos</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo count($datos_producto);?>">0</span></h4>
                                                        <a href="../MntProducto/" class="text-decoration-underline">Ver Productos</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-success rounded fs-3">
                                                            <i class="bx bx-dollar-circle text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TODO: Total de Categorias -->
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total de Categorias</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo count($datos_categoria);?>">0</span></h4>
                                                        <a href="../MntCategoria/" class="text-decoration-underline">Ver Categorias</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                                            <i class="bx bx-shopping-bag text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TODO: Total de Clientes -->
                                    <div class="col-xl-3 col-md-6">

                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total de Clientes</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo count($datos_cliente);?>">0</span> </h4>
                                                        <a href="../MntCliente/" class="text-decoration-underline">Ver Clientes</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-warning rounded fs-3">
                                                            <i class="bx bx-user-circle text-warning"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TODO: Total de Proveedores -->
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total de Proveedores</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo count($datos_proveedor);?>">0</span> </h4>
                                                        <a href="../MntProveedor/" class="text-decoration-underline">Ver Proveedores</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-primary rounded fs-3">
                                                            <i class="bx bx-wallet text-primary"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Compras</h4>
                                            </div>
                                            <!-- TODO: Barras de Compras x dia -->
                                            <div class="card-body ">
                                                <canvas id="grafcompra" class="chartjs-chart" data-colors='["--vz-success-rgb, 0.8", "--vz-primary-rgb, 0.9"]'></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Ventas</h4>
                                            </div>
                                            <!-- TODO: Barras de Venta x dia -->
                                            <div class="card-body ">
                                                <canvas id="grafventa" class="chartjs-chart" data-colors='["--vz-danger-rgb, 0.8", "--vz-primary-rgb, 0.9"]'></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Top 5 Productos - Compras </h4>
                                            </div>

                                            <div class="card-body">
                                                <!-- TODO: Top 5 productos Compra -->
                                                <div class="table-responsive table-card">
                                                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                        <tbody id="listtopcompraproducto">

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="align-items-center mt-4 pt-2 justify-content-between d-flex">
                                                    <div class="flex-shrink-0">
                                                        <div class="text-muted">
                                                            <!-- TODO: Redirigir a ver todas las compras -->
                                                            <a href="../ListCompra/" class="text-decoration-underline">Ver Compras</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Top 5 Productos - Ventas</h4>
                                            </div>

                                            <div class="card-body">
                                                <!-- TODO: Top 5 productos venta -->
                                                <div class="table-responsive table-card">
                                                    <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                                        <tbody id="listtopventaproducto">

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="align-items-center mt-4 pt-2 justify-content-between d-flex">
                                                    <div class="flex-shrink-0">
                                                        <div class="text-muted">
                                                            <!-- TODO: Redirigir a ver todas las Ventas -->
                                                            <a href="../ListVenta/" class="text-decoration-underline">Ver Ventas</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Consumo Compras x Categoria</h4>
                                            </div>

                                            <div class="card-body">
                                                <!-- TODO: Consumo de Compras por categoria -->
                                                <canvas id="grafdona" class="chartjs-chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-black"]'></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-8">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Compras Recientes</h4>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <!-- TODO: Top 6 de las ultimas compras -->
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th scope="col">Nro</th>
                                                                <th scope="col">Usuario</th>
                                                                <th scope="col">Proveedor</th>
                                                                <th scope="col">Moneda</th>
                                                                <th scope="col">Subtotal</th>
                                                                <th scope="col">IGV</th>
                                                                <th scope="col">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listventatop5">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-auto layout-rightside-col">
                            <div class="overlay"></div>
                            <div class="layout-rightside">
                                <div class="card h-100 rounded-0">
                                    <div class="card-body p-0">
                                        <div class="p-3">
                                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">Actividad Reciente</h6>
                                        </div>
                                        <div data-simplebar style="max-height: 710px;" class="p-3 pt-0">
                                            <!-- TODO: Listado de compra y venta como actividades recientes -->
                                            <div class="acitivity-timeline acitivity-main" id="listcompraventa">

                                            </div>
                                        </div>

                                        <!-- TODO: Total de Categoria -->
                                        <div class="p-3 mt-2">
                                            <h6 class="text-muted mb-3 text-uppercase fw-semibold">Total de Stock por Categoria
                                            </h6>

                                            <ol class="ps-3 text-muted" id="listcategoriastock">

                                            </ol>
                                            <div class="mt-3 text-center">
                                                <a href="../MntCategoria/" class="text-muted text-decoration-underline">Ver Categorias</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <?php require_once("../html/footer.php"); ?>
        </div>

    </div>

    <?php require_once("../html/js.php"); ?>

    <!-- apexcharts -->
    <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Vector map-->
    <script src="../../assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="../../assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!--Swiper slider js-->
    <script src="../../assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Dashboard init -->
    <script src="../../assets/js/pages/dashboard-ecommerce.init.js"></script>

    <!-- Chart JS -->
    <script src="../../assets/libs/chart.js/chart.min.js"></script>

    <script src="../../assets/js/pages/chartjs.init.js"></script>

    <script type="text/javascript" src="home.js"></script>
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
