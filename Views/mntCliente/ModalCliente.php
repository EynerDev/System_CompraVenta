<!-- Grids in modals -->
<div class="modal fade" id="ModalCliente" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lblTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="mantenimiento_form">
                    <div class="row g-3">

                        <input type="hidden" name="cli_id" id="cli_id">
                        
                        <div class="col-xxl-6">
                            <div>
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="cli_name" name="cli_name" required placeholder="Nombre del cliente">
                            </div>
                        </div><!--end col-->

                        <div class="col-lg-4">
                            <h6 class="fw-semibold">Tipo Documento:</h6>
                            <select class="js-example-basic-single" id="tipo_doc_id" name="tipo_doc_id">
                            </select>
                        </div>
                        <div class="col-xxl-6">
                            <div>
                                <label for="documento" class="form-label"># Documento:</label>
                                <input type="number" class="form-control" id="cli_doc" name="cli_doc" required placeholder="Numero de documento">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="numero" class="form-label">Numero:</label>
                                <input type="number" class="form-control" id="cli_number" name="cli_number" required placeholder="Numero del cliente">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="direccion" class="form-label">Direccion:</label>
                                <input type="text" class="form-control" id="cli_direcc" name="cli_direcc" required placeholder="Dirección del cliente">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" class="form-control" id="cli_email" name="cli_email" required placeholder="Email del cliente">
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
