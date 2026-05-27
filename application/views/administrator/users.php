<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    hr {
        margin-top: 0rem;
        margin-bottom: 0rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        height: 0;
    }
</style>

<div class="breadcrumb">
    <ul>
        <li><a href="#">Usuarios</a></li>
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
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estatus</th>
                            <th>Fallidos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($users ? $users : array()) as $k) { ?>
                            <tr>
                                <td><?= $k->id; ?></td>
                                <td><?= $k->nombre; ?></td>
                                <td><?= $k->usuario; ?></td>
                                <td>
                                    <strong>Email: </strong><?= $k->correo; ?> <br>
                                    <strong>Movil: </strong><?= $k->movil; ?>
                                </td>
                                <td><?= $k->tipo; ?> (<?= $k->rol; ?>)</td>
                                <td><?= $k->status; ?></td>
                                <td><?= $k->fallidos; ?></td>
                                <td>
                                    <button class="btn btn-info btn-icon m-1" type="button" data-toggle="modal" data-nombre="<?= $k->nombre; ?>" data-id="<?= $k->id; ?>" data-usuario="<?= $k->usuario; ?>" data-correo="<?= $k->correo; ?>" data-rol="<?= $k->rol; ?>" data-movil="<?= $k->movil; ?>" data-target=".users_edit">
                                        <span class="ul-btn__icon"><i class="fal fa-edit"></i>
                                        </span>
                                        <span class="ul-btn__text"> Editar</span>
                                    </button>

                                    <?php if ($k->fallidos >= 3) { ?>
                                        <button class="btn btn-danger btn-icon m-1" type="button" data-toggle="modal" data-nombre="<?= $k->nombre; ?>" data-movil="<?= $k->movil; ?>" data-correo="<?= $k->correo; ?>" data-id="<?= $k->id; ?>" data-target=".users_reset">
                                            <span class="ul-btn__icon"><i class="fal fa-repeat"></i>
                                            </span>
                                            <span class="ul-btn__text"> Resetear</span>
                                        </button>
                                    <?php } ?>
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
<?php require(APPPATH . "views/administrator/modals/users_add.php"); ?>
<?php require(APPPATH . "views/administrator/modals/users_edit.php"); ?>
<?php require(APPPATH . "views/administrator/modals/users_reset.php"); ?>

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
            "buttons": [
                "colvis"
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $('.users_edit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal

        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        modal.find('.modal-body #id').val(button.data('id'))
        modal.find('.modal-body #nombre').val(button.data('nombre'))
        modal.find('.modal-body #usuario').val(button.data('usuario'))
        modal.find('.modal-body #correo').val(button.data('correo'))
        modal.find('.modal-body #movil').val(button.data('movil'))
        $('.alert').hide(); //Oculto alert

        Object.size = function(obj) {
            var size = 0,
                key;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size;
        };

        $.ajax({
            url: '<?php echo base_url(); ?>administrator/rols',
            dataType: 'json',
            success: function(data) {
                var size = Object.size(data);
                var items = "";
                var rol = button.data('rol');
                items = items + '<option value="">Seleccione</option>';
                for (var i = 0; i < size; i++) {
                    items = items + '<option value="' + data[i].codigo + '" ' + (data[i].codigo == rol ? 'selected' : '') + '>' + data[i].tipo + '</option>';
                }
                $('#rolEdit').html("");
                $('#rolEdit').append(items);
                $('#rolEdit').change();
            }
        });

    });
</script>

<script>
    $('.users_reset').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal

        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        modal.find('.modal-body #id').val(button.data('id'))
        modal.find('.modal-body #nombre').val(button.data('nombre'))
        modal.find('.modal-body #correo').val(button.data('correo'))
        modal.find('.modal-body #movil').val(button.data('movil'))
        $('.alert').hide(); //Oculto alert

    });
</script>

<script type="text/javascript">
    function mostrarPassword() {
        var cambio = document.getElementById("password");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('fal fa-eye-slash').addClass('fal fa-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('fal fa-eye').addClass('fal fa-eye-slash');
        }
    }
</script>

<script type="text/javascript">
    function mostrarPasswordEdit() {
        var cambio = document.getElementById("passwordEdit");
        if (cambio.type == "password") {
            cambio.type = "text";
            $('.icon').removeClass('fal fa-eye-slash').addClass('fal fa-eye');
        } else {
            cambio.type = "password";
            $('.icon').removeClass('fal fa-eye').addClass('fal fa-eye-slash');
        }
    }
</script>