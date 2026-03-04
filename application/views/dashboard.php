<style>
    .card-icon-bg [class^="fa"] {
        font-size: 4rem;
        color: #4ea5dc;
    }

    .credito {
        color: blue;
    }

    .debito {
        color: red;
    }
</style>
<div class="breadcrumb">
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row-->
<div class="col-md-12 mb-4">

    <div class="row">
        <!-- ICON BG-->
        <?php foreach (($list ? $list : array()) as $k) { ?>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center"><i class="fad fa-tachometer-alt-fast"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0"><?= $k->status; ?></p>
                            <p class="text-primary text-24 line-height-1 mb-2"><?= $k->conteo; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="fad fa-tachometer-alt-fast"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">AAAAAA</p>
                        <p class="text-primary text-24 line-height-1 mb-2">BBBBBB</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="fad fa-tachometer-alt-fast"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">AAAAAA</p>
                        <p class="text-primary text-24 line-height-1 mb-2">BBBBBB</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="fad fa-tachometer-alt-fast"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">AAAAAA</p>
                        <p class="text-primary text-24 line-height-1 mb-2">BBBBBB</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- end of col-->

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

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            order: [
                [0, 'desc']
            ],
            "lengthChange": false,
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