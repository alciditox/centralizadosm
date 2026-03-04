<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />

<style>
    .form-group label {
        font-size: 14px;
        color: #000000;
        margin-bottom: 4px;
        font-weight: bold;
    }
</style>

<div class="breadcrumb">
    <ul>
        <li><a href="<?php echo base_url('menu'); ?>">Gestión de Menú</a></li>
        <li>Crear Nuevo Menú</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">

            <div class="col-md-8 offset-md-2">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Crear Nuevo Menú</h5>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo base_url('menu/create'); ?>">
                            
                            <div class="form-group">
                                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Nombre del menú">
                            </div>

                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Ej: controller/method">
                                <small class="form-text text-muted">Dejar vacío si es un menú padre con submenús</small>
                            </div>

                            <div class="form-group">
                                <label for="icon">Icono</label>
                                <input type="text" class="form-control" id="icon" name="icon" placeholder="Ej: fal fa-home">
                                <small class="form-text text-muted">Clases de Font Awesome. Ejemplo: fal fa-home, fal fa-users</small>
                            </div>

                            <div class="form-group">
                                <label for="parent">Menú Padre</label>
                                <select class="form-control" id="parent" name="parent">
                                    <option value="">-- Ninguno (Menú Principal) --</option>
                                    <?php foreach (($parent_menus ?: []) as $pmenu) { ?>
                                        <?php if (empty($pmenu->parent)): ?>
                                            <option value="<?php echo $pmenu->id; ?>"><?php echo $pmenu->nombre; ?></option>
                                        <?php endif; ?>
                                    <?php } ?>
                                </select>
                                <small class="form-text text-muted">Seleccione un menú padre si este es un submenú</small>
                            </div>

                            <div class="form-group">
                                <label for="status">Estado <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Activo" selected>Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="i-Yes"></i> Crear Menú
                                </button>
                                <a href="<?php echo base_url('menu'); ?>" class="btn btn-secondary">
                                    <i class="i-Close"></i> Cancelar
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

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
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/customizer.script.min.js"></script>
