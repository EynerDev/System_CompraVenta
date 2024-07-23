<?php
    require_once("../../Config/conn.php");
    require_once("../../Models/RolModel.php");

    $rol = new Rol();
    $datos = $rol->validar_acceso_rol($_SESSION["USER_ID"],"listcompra");
    if (isset($_SESSION["USER_ID"])){
        if(is_array($datos) and count($datos)> 0){


?>
<!doctype html>
<?php require_once("../html/html_head.php"); ?>

<head>

    <title>EynerDev | Documentos ayuda</title>
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
                                <h4 class="mb-sm-0">Ayuda</h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Ver</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Acceso</a></th>
                                                <td>Como iniciar sesion en el sistema</td>
                                                <td><a href="../../assets/documentos_ayuda/inicio.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Categoria</a></th>
                                                <td>Modulo de mantenimiento de las categorias</td>
                                                <td><a href="../../assets/documentos_ayuda/categoria.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Producto</a></th>
                                                <td>Modulo de mantenimiento de productos</td>
                                                <td><a href="../../assets/documentos_ayuda/producto.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Cliente</a></th>
                                                <td>Modulo de mantenimiento de cliente</td>
                                                <td><a href="../../assets/documentos_ayuda/cliente.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Proveedor</a></th>
                                                <td>Modulo de mantenimiento de proveedor</td>
                                                <td><a href="../../assets/documentos_ayuda/proveedor.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Moneda</a></th>
                                                <td>Modulo de mantenimiento de moneda </td>
                                                <td><a href="../../assets/documentos_ayuda/moneda.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Und Medida</a></th>
                                                <td>Modulo de mantenimiento de unidad de medida</td>
                                                <td><a href="../../assets/documentos_ayuda/unidadmedida.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Empresa</a></th>
                                                <td>Modulo de mantenimiento de empresa </td>
                                                <td><a href="../../assets/documentos_ayuda/empresa.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Sucursal</a></th>
                                                <td>Modulo de mantenimiento de sucursal</td>
                                                <td><a href="../../assets/documentos_ayuda/sucursal.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Usuario</a></th>
                                                <td>Modulo de mantenimiento de usuario</td>
                                                <td><a href="../../assets/documentos_ayuda/usuario.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Rol</a></th>
                                                <td>Modulo de mantenimiento de rol</td>
                                                <td><a href="../../assets/documentos_ayuda/rol.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Compras</a></th>
                                                <td>Modulo de mantenimiento de compras </td>
                                                <td><a href="../../assets/documentos_ayuda/compra1.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Ventas</a></th>
                                                <td>Modulo de mantenimiento de ventas</td>
                                                <td><a href="../../assets/documentos_ayuda/sucursal.pdf" target="_blank"class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Listado de compras</a></th>
                                                <td>Listado de compras</td>
                                                <td><a href="../../assets/documentos_ayuda/listado_compras.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><a href="#" class="fw-semibold">Listado de ventas</a></th>
                                                <td>Listado de Ventas</td>
                                                <td><a href="../../assets/documentos_ayuda/listado_ventas.pdf" target="_blank" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>
                                            </tr>
                                        </tbody>
                                    </table>

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
    require_once("../html/js.php")
    ?>
    
    <script type="text/javascript" src="listVenta.js"></script>
    
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