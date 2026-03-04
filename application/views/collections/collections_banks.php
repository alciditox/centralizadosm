<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Loading Model -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/loadingModal/css/jquery.loadingModal.min.css">


<div class="breadcrumb">
    <ul>
        <li><a href="#">Bancos de Cobranza (Collections Banks)</a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row-->
<div class="col-md-12 mb-4">
    <div class="card text-left">
        <div class="card-body">
            <button class="btn btn-info btn-icon m-1" type="button" onclick="addBank()">
                <span class="ul-btn__icon"><i class="fal fa-plus"></i></span>
                <span class="ul-btn__text"> Agregar Banco</span>
            </button>
        </div>
    </div>
</div>

<div class="col-md-12 mb-4">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_bancos" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Cuenta Contable</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============ Modals ============= -->
<form action="#" id="form_bank" method="POST" accept-charset="UTF-8">
    <div class="modal fade" id="modal_form_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Banco <i class="fal fa-arrow-alt-circle-right"></i></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" value="" name="id" id="bank_id"/> 
                    
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="codigo" class="col-sm-12"><b>Código*</b></label>
                            <input name="codigo" id="codigo" placeholder="Código" class="form-control" type="text" required>
                        </div>
                        
                        <div class="col-sm-3">
                            <label for="nombre" class="col-sm-12"><b>Nombre*</b></label>
                            <input name="nombre" id="nombre" placeholder="Nombre" class="form-control" type="text" required>
                        </div>
                        
                        <div class="col-sm-3">
                            <label for="cuenta_contable" class="col-sm-12"><b>Cta. Contable*</b></label>
                            <input name="cuenta_contable" id="cuenta_contable" placeholder="Cuenta Contable" class="form-control" type="number" required>
                        </div>
                        
                        <div class="col-sm-3">
                            <label for="status" class="col-sm-12"><b>Estatus*</b></label>
                            <select name="status" id="status" class="form-control select2" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-outline-success" type="submit" id="btnSaveBank">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Scripts -->
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
<!-- mask plugin  -->
<script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>

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

<!-- Loading Modal -->
<script src="<?php echo base_url('assets/') ?>dist-assets/loadingModal/js/jquery.loadingModal.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var table;
    
    $(document).ready(function() {
        table = $('#table_bancos').DataTable({ 
            "processing": true,
            "serverSide": true,
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('collections_aplicated/get_collections_banks_ajax')?>",
                "type": "POST"
            },
            "columnDefs": [
                { "targets": [ -1 ], "orderable": false }
            ],
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });

        $('#form_bank').on('submit', function(e) {
            e.preventDefault();
            $('#btnSaveBank').text('Guardando...'); //change button text
            $('#btnSaveBank').attr('disabled', true); //set button disable 

            $('body').loadingModal({
                text: 'Estamos procesando su informaci&oacute;n<br> En breve estar&aacute; listo<br> Por favor no recargar la pagina'
            });
            var delay = function(ms) {
                return new Promise(function(r) {
                    setTimeout(r, ms)
                })
            };
            var time = 2000;
            delay(time).then(function() {
                $('body').loadingModal('animation', 'threeBounce');
            });
     
            $.ajax({
                url : "<?php echo site_url('collections_aplicated/save_collection_bank')?>",
                type: "POST",
                data: $('#form_bank').serialize(),
                dataType: "JSON",
                success: function(data) {
                    $('body').loadingModal('destroy');
                    if(data.status) {
                        $('#modal_form_bank').modal('hide');
                        table.ajax.reload(null, false);
                        toastr["success"]("El banco ha sido guardado correctamente.", "Mensaje", {
                            progressBar: 100,
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            timeOut: 3000
                        });
                    }
                    $('#btnSaveBank').text('Guardar');
                    $('#btnSaveBank').attr('disabled', false); 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('body').loadingModal('destroy');
                    toastr["error"]("Error al agregar / modificar datos", "Mensaje", {
                        progressBar: 100,
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        timeOut: 3000
                    });
                    $('#btnSaveBank').text('Guardar');
                    $('#btnSaveBank').attr('disabled', false); 
                }
            });
        });
    });

    function addBank() {
        $('#form_bank')[0].reset(); 
        $('#bank_id').val('');
        $('[name="status"]').val('Activo'); // default status
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
        $('#modal_form_bank').modal('show'); 
        $('#modal_title').html('Banco <i class="fal fa-arrow-alt-circle-right"></i>'); 
    }

    function editBank(id) {
        $('#form_bank')[0].reset(); 
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
     
        $.ajax({
            url : "<?php echo site_url('collections_aplicated/get_collection_bank')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#bank_id').val(data.id);
                $('[name="codigo"]').val(data.codigo);
                $('[name="nombre"]').val(data.nombre);
                $('[name="cuenta_contable"]').val(data.cuenta_contable);
                $('[name="status"]').val(data.status);
                
                $('#modal_form_bank').modal('show'); 
                $('#modal_title').html('Banco <i class="fal fa-arrow-alt-circle-right"></i>'); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr["error"]("Error al obtener datos", "Mensaje", {
                    timeOut: 3000
                });
            }
        });
    }

    function deleteBank(id) {
        if (confirm("¿Estás seguro? ¡No podrás revertir esto!")) {
            $.ajax({
                url : "<?php echo site_url('collections_aplicated/delete_collection_bank')?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $('#modal_form_bank').modal('hide');
                    table.ajax.reload(null, false);
                    toastr["success"]("El banco ha sido eliminado.", "Mensaje", {
                        progressBar: 100,
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        timeOut: 3000
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr["error"]("Error al borrar el dato", "Mensaje", {
                        progressBar: 100,
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        timeOut: 3000
                    });
                }
            });
        }
    }
</script>
