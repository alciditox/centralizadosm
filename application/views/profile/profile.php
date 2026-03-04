<style>
    .text-aument {
        font-size: 1.3em;
    }
</style>

<div class="card user-profile o-hidden mb-4">
    <div class="user-info">
        <img class="profile-picture avatar-lg mb-2" src="#" alt="">

    </div>
    <div class="card-body">
        <ul class="nav nav-tabs profile-nav mb-4" id="profileTab" role="tablist">

            <li class="nav-item"><a class="nav-link active show" id="principal-tab" data-toggle="tab" href="#principal" role="tab" aria-controls="principal" aria-selected="true"><?= $info->nombre; ?></a></li>
        </ul>
        <div class="tab-content" id="profileTabContent">

            <div class="tab-pane fade active show" id="principal" role="tabpanel" aria-labelledby="principal-tab">
                <h4>Personal Information</h4>

                <hr>
                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="mb-4">
                            <p class="text-primary mb-1 text-aument"><i class="far fa-user-tag"></i> Nombre</p><span><?= $info->nombre; ?></span>
                        </div>
                        <div class="mb-4">
                            <p class="text-primary mb-1 text-aument"><i class="far fa-portal-enter"></i> Usuario</p><span><?= $info->usuario; ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-4">
                            <p class="text-primary mb-1 text-aument"><i class="far fa-envelope"></i> Correo</p><span><?= $info->correo; ?></span>
                        </div>
                        <div class="mb-4">
                            <p class="text-primary mb-1 text-aument"><i class="far fa-sitemap"></i> Rol</p><span><?= $info->departamento; ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-4">
                            <p class="text-primary mb-1 text-aument"><i class="far fa-phone-office"></i> Movil</p><span><?= $info->movil; ?></span>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-2 col-sm-4 col-6 text-center">
                        <p class="text-16 mt-1">
                            <button class="btn btn-info btn-icon m-1" type="button" data-toggle="modal" data-target=".password">
                                <span class="ul-btn__icon"><i class="fad fa-lock-open-alt"></i> </span>
                                <span class="ul-btn__text"> Actualizar Contraseña</span>
                            </button>
                        </p>
                    </div>

                    <div class="col-md-2 col-sm-4 col-6 text-center">
                        <p class="text-16 mt-1">
                            <button class="btn btn-info btn-icon m-1" type="button" data-toggle="modal" data-target=".mobile">
                                <span class="ul-btn__icon"><i class="fad fa-mobile-alt"></i> </span>
                                <span class="ul-btn__text"> Actualizar Movil</span>
                            </button>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('profile/modals/modal');
?>

<?php //require(APPPATH . "views/profile/modals/modal.php"); 
?>

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
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/datatables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/datatables.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/customizer.script.min.js"></script>

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
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

<script>
    $(document).ready(function() {
        $('#mostrar_contrasena').click(function() {
            if ($('#mostrar_contrasena').is(':checked')) {
                $('.password').attr('type', 'text');
                $('.icon').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
            } else {
                $('.password').attr('type', 'password');
                $('.icon').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
            }
        });
    });
</script>

<script>
    $('.informacion').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        //modal.find('.modal-body #id').val(button.data('id'))
        $('.alert').hide(); //Oculto alert

    });
</script>

<script>
    $('.password').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        //modal.find('.modal-body #id').val(button.data('id'))
        $('.alert').hide(); //Oculto alert

    });
</script>

<script>
    $('.mobile').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        //modal.find('.modal-body #id').val(button.data('id'))
        $('.alert').hide(); //Oculto alert

    });
</script>

<script>
    $('.correo').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        //modal.find('.modal-body #id').val(button.data('id'))
        $('.alert').hide(); //Oculto alert

    });
</script>