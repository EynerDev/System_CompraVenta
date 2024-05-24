<!-- Grids in modals -->
<div class="modal fade" id="ModalMoneda" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lblTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="mantenimiento_form">
                    <div class="row g-3">

                        <input type="hidden" name="mon_id" id="mon_id">
                        
                        <div class="col-xxl-6">
                            <div>
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="mon_name" name="mon_name" required placeholder="Nombre de la moneda">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            
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