<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />

<style>
    .form-group label {
        font-size: 14px;
        color: #000000;
        margin-bottom: 4px;
        font-weight: bold;
    }

    .detail-label {
        font-weight: bold;
        color: #666;
    }

    .detail-value {
        color: #000;
        margin-bottom: 15px;
    }

    .badge-activo {
        background-color: #28a745;
        color: #fff;
    }

    .badge-inactivo {
        background-color: #6c757d;
        color: #fff;
    }
</style>

<div class="breadcrumb">
    <ul>
        <li><a href="<?php echo base_url('menu'); ?>">Gestión de Menú</a></li>
        <li>Detalle del Menú</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">

            <div class="col-md-8 offset-md-2">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Detalle del Menú</h5>
                            <div>
                                <a href="<?php echo base_url('menu/edit/' . $menu->id); ?>" class="btn btn-warning btn-sm">
                                    <i class="i-Pen-2"></i> Editar
                                </a>
                                <a href="<?php echo base_url('menu'); ?>" class="btn btn-secondary btn-sm">
                                    <i class="i-Arrow-Back"></i> Volver
                                </a>
                            </div>
                        </div>

                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="detail-item">
                                    <div class="detail-label">ID</div>
                                    <div class="detail-value"><?php echo $menu->id; ?></div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Nombre</div>
                                    <div class="detail-value"><?php echo $menu->nombre; ?></div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">URL</div>
                                    <div class="detail-value">
                                        <?php if ($menu->url): ?>
                                            <code><?php echo $menu->url; ?></code>
                                        <?php else: ?>
                                            <span class="text-muted">Sin URL (Menú padre)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Icono</div>
                                    <div class="detail-value">
                                        <?php if ($menu->icon): ?>
                                            <i class="<?php echo $menu->icon; ?> mr-2"></i>
                                            <code><?php echo $menu->icon; ?></code>
                                        <?php else: ?>
                                            <span class="text-muted">Sin icono</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Menú Padre</div>
                                    <div class="detail-value">
                                        <?php if ($menu->parent_nombre): ?>
                                            <?php echo $menu->parent_nombre; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Ninguno (Menú principal)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Estado</div>
                                    <div class="detail-value">
                                        <span class="badge <?php echo $menu->status === 'Activo' ? 'badge-activo' : 'badge-inactivo'; ?>">
                                            <?php echo $menu->status; ?>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="<?php echo base_url('menu/edit/' . $menu->id); ?>" class="btn btn-warning">
                                <i class="i-Pen-2"></i> Editar Menú
                            </a>
                            <a href="<?php echo base_url('menu'); ?>" class="btn btn-secondary">
                                <i class="i-Arrow-Back"></i> Volver al Listado
                            </a>
                            <button class="btn btn-danger" type="button" onclick="eliminarMenu(<?php echo $menu->id; ?>)">
                                <i class="i-Close"></i> Eliminar
                            </button>
                        </div>

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

<script>
    function eliminarMenu(id) {
        if (confirm('¿Está seguro de eliminar este menú? Esta acción no se puede deshacer.\n\nNOTA: Si este menú tiene submenús, también serán eliminados.')) {
            window.location.href = '<?php echo base_url('menu/delete/'); ?>' + id;
        }
    }
</script>
