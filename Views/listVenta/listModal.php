<!-- Grids in modals -->
<div class="modal fade" id="ListModal" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lblTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table id="detalle_data" name="table_datos" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                            <th></th>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>P.Venta</th>
                            <th>Cantidad</th>
                            <th>Total</th>                     
                    </tr>
                    </thead>
                    <tbody>        
                    </tbody>
                </table>
                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" id="det_venta" style="width:250px">
                    <tbody>
                        <tr>
                            <td>Sub Total</td>
                            <td class="text-end" id="venta_sub_total">0.0</td>
                        </tr>
                        <tr>
                            <td>IVA (19%)</td>
                            <td class="text-end" id="venta_iva">0.0</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                                <td class="text-end" id="venta_total">0.0</td>
                        </tr>                                                 
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                
            </div>
        </div>
    </div>
</div>