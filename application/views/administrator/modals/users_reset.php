                <!--  Large Modal -->

                <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('administrator/users/reset'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade bd-example-modal-lg users_reset" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Resetear usuario <i class="fad fa-repeat"></i> </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                                </div>
                                <div class="modal-body">



                                    <div class="row">

                                        <input id="id" name="id" type="hidden" required />
                                        <input id="correo" name="correo" type="hidden" required />
                                        <input id="movil" name="movil" type="hidden" required />

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Nombre Completo</label>
                                            <input class="form-control letters" id="nombre" name="nombre" type="text" required readonly />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Correo</label>
                                            <input class="form-control" id="correo" name="correo" type="email" required readonly />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-danger" type="submit">Resetear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--  Small Modal -->