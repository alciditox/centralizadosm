<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="breadcrumb">
    <ul>
        <li><a href="#">Roles </a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row-->
<div class="col-md-12 mb-4">
    <div class="card text-left">
        <div class="card-body">

            <button class="btn btn-info btn-icon m-1" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">
                <span class="ul-btn__icon"><i class="fal fa-user-plus"></i>
                </span>
                <span class="ul-btn__text"> Agregar</span>
            </button>

        </div>
    </div>
</div>
<!-- end of col-->

<!-- end of row-->
<div class="col-md-12 mb-4">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Rol</th>
                            <th>Agentes</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($rols ? $rols : array()) as $k) { ?>
                            <tr>
                                <td><?= $k->codigo; ?></td>
                                <td><?= $k->tipo; ?></td>
                                <td><strong>(<?= $k->agentes; ?>)</strong></td>
                                <td><?= $k->status; ?></td>
                                <td>
                                    <form method="POST" action="<?= base_url('administrator/roles/view'); ?>">
                                        <input name="id" value="<?= $k->id; ?>" type="hidden" />
                                        <input name="tipo" value="<?= $k->tipo; ?>" type="hidden" />
                                        <input name="codigo" value="<?= $k->codigo; ?>" type="hidden" />
                                        <input name="status" value="<?= $k->status; ?>" type="hidden" />
                                        <input name="agentes" value="<?= $k->agentes; ?>" type="hidden" />
                                        <button class="btn btn-info btn-icon m-1" type="submit">
                                            <span class="ul-btn__icon"><i class="fal fa-edit"></i>
                                            </span>
                                            <span class="ul-btn__text">Editar</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>
<!-- end of col-->

<!-- ============ Modals ============= -->
<?php $this->load->view('administrator/modals/roles_add'); ?>

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

<!-- DataTables  & Plugins -->
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            order: [
                [0, 'desc']
            ],
            "lengthChange": false,
            "ordering": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            order: [
                [0, 'desc']
            ],
        });
    });
</script>