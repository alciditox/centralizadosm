<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    hr {
        margin-top: 0.2rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        height: 0;
    }

    label {
        color: #003473 !important;
        font-weight: bold;
    }

    .form-group p {
        font-weight: bold;
    }
</style>

<div class="breadcrumb">
    <ul>
        <li><a href="#">Consolidado de Pagos</a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


<form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('invoices/consolidated/search'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">


    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-4 mt-4">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label for="firstName1">Banco</label>
                                <select class="form-control" id="firstName1" name="banco" required>
                                    <option value="">Seleccione</option>
                                    <option value="Todos">Todos</option>
                                </select>
                                <div class="invalid-feedback">
                                    Dato Obligatorio
                                </div>
                            </div>

                            <div class="col-md-2 form-group">
                                <br>
                                <button class="btn btn-success" type="submit">Buscar</button>
                            </div>
                            <div class="col-md-2 form-group">
                                <br>
                                <a href="<?= base_url('invoices/consolidated'); ?>">
                                    <button class="btn btn-info" type="button">Refrescar</button>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php if (!empty($row)) { ?>

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="card mt-4 mt-4">
                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Numero de cobro</th>
                                        <th>Contrato</th>
                                        <th>Contrato Estatus</th>
                                        <th>Fecha Contrato</th>
                                        <th>Afiliados</th>
                                        <th>Banco</th>
                                        <th>Periodicidad</th>
                                        <th>Nombre</th>
                                        <th>Rif</th>
                                        <th>Usd</th>
                                        <th>Bs</th>
                                        <th>Fecha Generado</th>
                                        <th>Fecha Conciliado</th>
                                        <th>Tipo</th>
                                        <th>Estatus</th>
                                        <th>Referencia</th>
                                        <th>Fecha Creacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (($list ? $list : array()) as $k) { ?>
                                        <tr>
                                            <td><?= $k->id; ?></td>
                                            <td><?= $k->contract_id; ?></td>
                                            <td><?= $k->status_contrato; ?></td>
                                            <td><?= date('d-m-Y', strtotime($k->fecha_registrado)); ?></td>
                                            <td><?= $k->afiliados; ?></td>
                                            <td><?= $k->nbanco; ?></td>
                                            <td><?= $k->nperiodicidad; ?></td>
                                            <td><?= $k->nombre; ?> <?= $k->apellido; ?></td>
                                            <td><?= $k->rif; ?></td>
                                            <td><?= $k->usd; ?></td>
                                            <td><?= $k->monto; ?></td>
                                            <td><?= $k->fecha_mes_cobro; ?></td>
                                            <td><?= $k->fecha_conciliado; ?></td>
                                            <td><?= $k->pago; ?></td>
                                            <td>
                                                <?php require(APPPATH . "views/invoices/modals/status.php"); ?>
                                            </td>
                                            <td><?= $k->respuesta; ?></td>
                                            <td><?= $k->fecha_generado; ?></td>
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

<?php } ?>

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
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "buttons": [{
                    extend: 'excelHtml5',
                    title: 'Archivo_Descargado',
                },
                "colvis"
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/') ?>dist-assets/select2/js/select2.full.min.js"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>