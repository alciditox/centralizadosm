<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    .form-group label {
        font-size: 14px;
        color: #000000;
        margin-bottom: 4px;
        font-weight: bold;
    }

    .badge-activo {
        background-color: #28a745;
        color: #fff;
    }

    .badge-inactivo {
        background-color: #6c757d;
        color: #fff;
    }

    .menu-parent {
        font-weight: bold;
        background-color: #f8f9fa;
    }

    .menu-child {
        padding-left: 30px;
    }
</style>

<div class="breadcrumb">
    <ul>
        <li><a href="#">Administración</a></li>
        <li>Gestión de Menú</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Gestión de Menú</h5>
                            <a href="<?php echo base_url('menu/create'); ?>" class="btn btn-primary">
                                <i class="i-Add"></i> Nuevo Menú
                            </a>
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
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>URL</th>
                                                <th>Icono</th>
                                                <th>Menú Padre</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (($list ?: []) as $menu) { ?>
                                                <tr class="<?php echo empty($menu->parent) ? 'menu-parent' : 'menu-child'; ?>">
                                                    <td><?php echo $menu->id; ?></td>
                                                    <td>
                                                        <?php if (!empty($menu->parent)): ?>
                                                            <i class="fal fa-level-up-alt fa-rotate-90 mr-1"></i>
                                                        <?php endif; ?>
                                                        <?php echo $menu->nombre; ?>
                                                    </td>
                                                    <td><?php echo $menu->url ?: '-'; ?></td>
                                                    <td>
                                                        <?php if ($menu->icon): ?>
                                                            <i class="<?php echo $menu->icon; ?>"></i> 
                                                            <small class="text-muted"><?php echo $menu->icon; ?></small>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $menu->parent_nombre ?: '-'; ?></td>
                                                    <td>
                                                        <span class="badge <?php echo $menu->status === 'Activo' ? 'badge-activo' : 'badge-inactivo'; ?>">
                                                            <?php echo $menu->status; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url('menu/view/' . $menu->id); ?>" class="btn btn-outline-info btn-sm" title="Ver Detalle">
                                                            <i class="i-Eye"></i>
                                                        </a>
                                                        <a href="<?php echo base_url('menu/edit/' . $menu->id); ?>" class="btn btn-outline-warning btn-sm" title="Editar">
                                                            <i class="i-Pen-2"></i>
                                                        </a>
                                                        <button class="btn btn-outline-<?php echo $menu->status === 'Activo' ? 'secondary' : 'success'; ?> btn-sm" 
                                                                type="button" 
                                                                onclick="cambiarEstado(<?php echo $menu->id; ?>, '<?php echo $menu->status; ?>')" 
                                                                title="<?php echo $menu->status === 'Activo' ? 'Desactivar' : 'Activar'; ?>">
                                                            <i class="i-Power-2"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm" type="button" onclick="eliminarMenu(<?php echo $menu->id; ?>)" title="Eliminar">
                                                            <i class="i-Close"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            }
        });
    });

    function cambiarEstado(id, estadoActual) {
        var accion = estadoActual == 'Activo' ? 'desactivar' : 'activar';
        if (confirm('¿Está seguro de ' + accion + ' este menú?')) {
            window.location.href = '<?php echo base_url('menu/change_status/'); ?>' + id;
        }
    }

    function eliminarMenu(id) {
        if (confirm('¿Está seguro de eliminar este menú? Esta acción no se puede deshacer.\n\nNOTA: Si este menú tiene submenús, también serán eliminados.')) {
            window.location.href = '<?php echo base_url('menu/delete/'); ?>' + id;
        }
    }
</script>
