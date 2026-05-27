                <!--  Large Modal -->

                <form class="needs-validation" id="basicForm" novalidate="novalidate" method="POST" action="<?= base_url('invoices/generate'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade modal-cobro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Generar Cobros <i class="fal fa-arrow-alt-circle-right"></i> </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <input type="hidden" name="type_service" id="type_service" value="9">

                                        <div class="col-sm-3">
                                            <label for="bank_id" class="col-sm-12"><b>Banco*</b></label>
                                            <select id="bank_id" class="form-control bank_id select2" required="required" name="bank_id" id="bank_id">
                                                <option value="">Seleccione Banco...</option>
                                                <?php foreach ($banks as $item) { ?>
                                                    <option value="<?= $item['id']; ?>"><?= $item['description']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-3 field months">
                                            <label for="date_invoice" class="col-sm-12"><b>Cobranza*</b></label>
                                            <input id="date_invoice" name="fecha_generado" type="month" class="form-control input date_invoice" placeholder="yyyy-mm" data-toggle="datepicker" required="">
                                        </div>

                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-danger" type="button" data-dismiss="modal">Cerrar</button>
                                    <button class="btn btn-outline-success" type="submit">Generar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--  Small Modal -->