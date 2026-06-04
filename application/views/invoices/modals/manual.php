                <!--  Large Modal -->
                <?php
                $contrato = "";
                if (!empty($row)) $contrato = $row->id;
                ?>
                <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('invoices/manuals/agg/' . $contrato . ''); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade modal-manual" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Generar Cobro Manual </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">

                                    <input id="contrato" name="contrato" type="hidden" autocomplete="off" readonly required="" />
                                    <input id="cedula" name="cedula" type="hidden" autocomplete="off" readonly required="" />

                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">$ Por Cuota</label>
                                            <input class="form-control" id="cobrar" name="cobrar" type="text" autocomplete="off" required="" readonly />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>
                                        <!--
                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Cantidad de Cuotas</label>
                                            <input class="form-control only-number" id="cuotas" name="cuotas" type="text" maxlength="2" autocomplete="off" required="" />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>
                                        -->

                                        <input class="form-control only-number" id="cuotas" name="cuotas" type="hidden" value="1" maxlength="1" readonly />

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Tasa</label>
                                            <input class="form-control money" id="tasa" name="tasa" type="text" autocomplete="off" required="" />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-8 form-group">
                                            <label for="firstName1">Observaci&oacute;n o Referencia</label>
                                            <input class="form-control" id="respuesta" name="respuesta" placeholder="Especificar (Transferencia o Efectivo) + Referencia" type="text" autocomplete="off" required="" />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Total USD</label>
                                            <input class="form-control money" id="totalusd" name="totalusd" type="text" autocomplete="off" readonly />
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Total BS</label>
                                            <input class="form-control money" id="totalbs" name="totalbs" type="text" autocomplete="off" readonly />
                                        </div>

                                    </div>
                                    <hr>
                                    <hr>

                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Fecha Generado (Cobro Correspondiente)</label>
                                            <input class="form-control" id="generated" name="generated" type="date" required />
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Fecha Conciliacion (Fecha en la que abono el cobro)</label>
                                            <input class="form-control" id="conciliated" name="conciliated" type="date" required />
                                        </div>

                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-danger" type="button" data-dismiss="modal">Cerrar</button>
                                    <button class="btn btn-outline-success" type="submit">Cargar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--  Small Modal -->