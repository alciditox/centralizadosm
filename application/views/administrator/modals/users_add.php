                <!--  Large Modal -->

                <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('administrator/users/add'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Nuevo <i class="fad fa-layer-plus"></i> </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                                </div>
                                <div class="modal-body">



                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Nombre Completo</label>
                                            <input class="form-control letters" id="firstName1" name="nombre" type="text" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">usuario</label>
                                            <input class="form-control letters" id="firstName1" name="usuario" type="text" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Correo</label>
                                            <input class="form-control" id="firstName1" name="correo" type="email" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Contraseña</label>
                                            <div class="input-right-icon">
                                                <input class="form-control" id="password" name="clave" type="password" autocomplete="off" minlength="8" required>
                                                <div class="invalid-feedback">
                                                    Dato Obligatorio
                                                </div>
                                                <span class="span-right-input-icon" onclick="mostrarPassword()"><i class="fal fa-eye-slash icon"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Rol</label>
                                            <select class="form-control" id="rol" name="rol" onchange="agrega()" required>
                                                <option value="">Seleccione</option>
                                                <?php foreach ($rols as $k) { ?>
                                                    <option value="<?= $k->codigo; ?>"><?= $k->tipo; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Estatus</label>
                                            <select class="form-control" id="firstName1" name="status" required>
                                                <option value="Activo" selected>Activo</option>
                                                <option value="Inactivo">Inactivo</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Movil</label>
                                            <input class="form-control phone" id="firstName1" name="movil" type="text" autocomplete="off" minlength="12" />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-success" type="submit">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--  Small Modal -->