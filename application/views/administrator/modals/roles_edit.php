<style>
    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        height: 0;
    }
</style>
<div class="breadcrumb">
    <ul>
        <li><a href="#">Roles </a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


<form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('administrator/roles/edit'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
    <!-- end of row-->
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <div class="row">

                    <input name="id" type="hidden" value="<?= $id; ?>" required />
                    <input name="codigo" type="hidden" value="<?= $codigo; ?>" required />

                    <div class="col-md-1 form-group">
                        <label for="firstName1">N#</label>
                        <input class="form-control" type="text" value="<?= $codigo; ?>" required readonly />
                        <div class="invalid-feedback">
                            Dato Obligatorio
                        </div>
                    </div>

                    <div class="col-md-1 form-group">
                        <label for="firstName1">Agentes</label>
                        <input class="form-control" type="text" value="<?= $agentes; ?>" required readonly />
                        <div class="invalid-feedback">
                            Dato Obligatorio
                        </div>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="firstName1">Nombre Rol</label>
                        <input class="form-control only-number" id="firstName1" name="tipo" type="text" autocomplete="off" value="<?= $tipo; ?>" required />
                        <div class="invalid-feedback">
                            Dato Obligatorio
                        </div>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="firstName1">Estatus</label>
                        <select class="form-control" id="firstName1" name="status" required>
                            <option value="Activo" <?php if ($status == "Activo") echo "selected"; ?>>Activo</option>
                            <option value="Inactivo" <?php if ($status == "Inactivo") echo "selected"; ?>>Inactivo</option>
                        </select>
                        <div class="invalid-feedback">
                            Dato Obligatorio
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- end of col-->

    <!-- end of row-->
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <div class="row">

                    <?php foreach ($menuUno as $uno) { ?>
                        <div class="col-md-3 form-group">
                            <label class="checkbox checkbox-secondary">
                                <input type="checkbox" name="menu_id[]" value="<?= $uno->id; ?>" <?php
                                                                                                    foreach ($rpm as $r) {
                                                                                                        if (($uno->id) == ($r->menu_id)) {
                                                                                                            echo 'checked="checked"';
                                                                                                        }
                                                                                                    }

                                                                                                    ?>><span><strong><?= $uno->nombre; ?></strong></span><span class="checkmark"></span>
                            </label>
                            <hr>

                            <?php foreach ($menuDos as $dos) { ?>
                                <?php if (($uno->id) == ($dos->parent)) { ?>

                                    <label class="checkbox checkbox-secondary">
                                        <input type="checkbox" name="menu_id[]" value="<?= $dos->id; ?>" <?php
                                                                                                            foreach ($rpm as $r) {
                                                                                                                if (($dos->id) == ($r->menu_id)) {
                                                                                                                    echo 'checked="checked"';
                                                                                                                }
                                                                                                            }

                                                                                                            ?>><span><?= $dos->nombre; ?></span><span class="checkmark"></span>
                                    </label>

                            <?php }
                            } ?>
                            <br><br>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end of col-->

    <!-- end of row-->
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <input name="id" value="<?= $id; ?>" type="hidden" />
                <input name="codigo" value="<?= $codigo; ?>" type="hidden" />

                <button class="btn btn-success btn-icon m-1" type="submit" data-toggle="modal" data-target=".bd-example-modal-lg">
                    <span class="ul-btn__icon"><i class="fal fa-user-plus"></i>
                    </span>
                    <span class="ul-btn__text">Guardar</span>
                </button>

                <a href="<?= base_url('administrator/roles'); ?>">
                    <button class="btn btn-info btn-icon m-1" type="button">
                        <span class="ul-btn__icon"><i class="fal fa-undo"></i>
                        </span>
                        <span class="ul-btn__text">Regresar</span>
                    </button>
                </a>

            </div>
        </div>
    </div>
    <!-- end of col-->
</form>


<!-- ============ Search UI End ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/tooltip.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/script_2.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/sidebar.large.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/feather.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/metisMenu.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/layout-sidebar-vertical.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/datatables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/datatables.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/customizer.script.min.js"></script>

<!-- ============ Search UI End ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>