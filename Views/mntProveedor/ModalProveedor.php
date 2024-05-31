<!-- Grids in modals -->
<div class="modal fade" id="ModalProveedor" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lblTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="mantenimiento_form">
                    <div class="row g-3">

                        <input type="hidden" name="prov_id" id="prov_id">
                        
                        <div class="col-xxl-6">
                            <div>
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="prov_name" name="prov_name" required placeholder="Nombre del proveedor">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="documento" class="form-label">RUT:</label>
                                <input type="number" class="form-control" id="prov_rut" name="prov_rut" required placeholder="Numero de RUT">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="numero" class="form-label">Numero:</label>
                                <input type="number" class="form-control" id="prov_number" name="prov_number" required placeholder="Numero del proveedor">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="direccion" class="form-label">Direccion:</label>
                                <input type="text" class="form-control" id="prov_dirc" name="prov_dirc" required placeholder="Dirección del proveedor">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" class="form-control" id="prov_email" name="prov_email" required placeholder="Email del proveedor">
                            </div>
                        </div><!--end col-->
                        
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit"  name="action" value="add" class="btn btn-primary">Agregar</button>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>
