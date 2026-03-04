<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/toastr.min.js"></script>

<script>
    const LogoutTime = 3 * 1000; //3 Segundos

    <?php
    $types = ['info', 'warning', 'success', 'error'];

    foreach ($types as $t):
        $msg = $this->session->flashdata($t);
        if (!empty($msg)):
    ?>
            toastr["<?= $t ?>"]("<?= htmlspecialchars($msg, ENT_QUOTES) ?>", "Mensaje", {
                progressBar: 100,
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: LogoutTime
            });
    <?php
            // eliminar inmediatamente
            $this->session->unset_userdata($t);
        endif;
    endforeach;
    ?>
</script>

<?php if ($modal = $this->session->flashdata('modal')): ?>
    <script>
        $(document).ready(() => $("#alertModal").modal());
    </script>

    <!-- Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Alertas</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?= htmlspecialchars($modal, ENT_QUOTES) ?></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->session->unset_userdata('modal'); ?>
<?php endif; ?>