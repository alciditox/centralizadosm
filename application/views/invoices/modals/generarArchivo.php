                <!--  Large Modal -->

                <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('invoices/create'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade modal-generararchivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Generar Proceso <i class="fal fa-arrow-alt-circle-right"></i> </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">


                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Banco</label>
                                            <select class="form-control" id="firstName1" name="banco" required>
                                                <option value="">Seleccione Banco...</option>
                                                <?php foreach ($banks as $item) { ?>
                                                    <option value="<?= $item['id']; ?>"><?= $item['description']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Fecha Generada</label>
                                            <input class="form-control" id="fecha_generado" name="fecha_generado" type="date" autocomplete="off" required="" />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
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