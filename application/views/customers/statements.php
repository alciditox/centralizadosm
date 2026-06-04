<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="breadcrumb">
    <ul>
        <li><a href="#">Actividades</a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">



        <?php if (empty($api['id'])) { ?>
            <div class="row">

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('customers/statements/rif'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">

                                <div class="row">

                                    <div class="col-md-6 form-group">
                                        <label for="firstName1">Rif</label>
                                        <input class="form-control rif" id="rif" name="rif" type="text" autocomplete="off" required />
                                        <div class="invalid-feedback">
                                            Dato Obligatorio
                                        </div>
                                    </div>

                                    <div class="col-md-4 form-group" style="margin-top: 1.8em;">
                                        <button class=" btn btn-success" type="submit">Aceptar</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('customers/statements/contrato'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">

                                <div class="row">

                                    <div class="col-md-6 form-group">
                                        <label for="firstName1">Contrato</label>
                                        <input class="form-control" id="" name="contrato" maxlength="10" type="text" autocomplete="off" required />
                                        <div class="invalid-feedback">
                                            Dato Obligatorio
                                        </div>
                                    </div>

                                    <div class="col-md-4 form-group" style="margin-top: 1.8em;">
                                        <button class=" btn btn-success" type="submit">Aceptar</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>


        <div class="row">


            <?php if (!empty($api['id'])) { ?>

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Cliente</h5>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Cliente</th>
                                                    <th scope="col">Rif</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Fecha Registro</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $api['id']; ?></td>
                                                    <td><?php echo $api['rif']; ?></td>
                                                    <td><?php echo $api['business_name']; ?></td>
                                                    <td><?php echo $api['created_at']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Contratos</h5>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>INFO</th>
                                                    <th></th>
                                                    <th scope="col">Contrato</th>
                                                    <th scope="col">Plan</th>
                                                    <th scope="col">Modelo</th>
                                                    <th scope="col">Serial</th>
                                                    <th scope="col">Banco</th>
                                                    <th scope="col">Afiliado</th>
                                                    <th scope="col">N pos</th>
                                                    <th scope="col">Estatus</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach (($contratos ? $contratos : array()) as $c) { ?>
                                                    <tr>
                                                        <td><a href="<?= base_url('customers/invoices/') . $c['id']; ?>">ESTADO DE CUENTA</a></td>
                                                        <td>
                                                            <a href="<?= base_url("GeneratePDF/statements/" . $api['id'] . "_" . $c['id']); ?>" target="_blank">
                                                                <button class=" btn btn-info btn-sm m-1" type="submit">PDF</button>
                                                            </a>
                                                        </td>
                                                        <td><?= str_pad($c['id'], 8, "0", STR_PAD_LEFT); ?></td>
                                                        <td><?= $c['plan'] ?></td>
                                                        <td><?= $c['modelo'] ?></td>
                                                        <td><?= $c['serialPos'] ?></td>
                                                        <td><?= $c['banco'] ?></td>
                                                        <td><?= $c['afiliado'] ?></td>
                                                        <td><?= $c['nropos'] ?></td>
                                                        <td><?= $c['status'] ?></td>

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

<?php } ?>

</div>
</div>
</div>

<!-- ============ Modals ============= -->


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
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/echarts.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/echart.options.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/customizer.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/toastr.min.js"></script>

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

<!-- ============ Search UI End ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>
<!-- mask plugin  -->
<script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>
<!-- ============ Mrtricas ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/metricas.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/') ?>dist-assets/select2/js/select2.full.min.js"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            order: [
                [0, 'desc']
            ],
            "buttons": [{
                    name: 'excel',
                    extend: 'excel',
                    filename: 'Banesco',
                    sheetName: 'Hoja1',
                    title: null
                },
                "colvis"
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>