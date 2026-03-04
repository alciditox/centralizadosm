<!DOCTYPE html>

<?php
$ci = &get_instance();
$ci->load->model("parameters"); // Cargar el modelo
$wcon = $ci->parameters->webConfigurations();
?>

<head>
    <meta charset="UTF-8" />
    <title><?= $wcon->tittle; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <style>
        img {
            width: 20em;
        }
    </style>
</head>

<body>
    <?php
    $path = FCPATH . 'assets/dist-assets/images/local/front.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>

    <img src="<?= $base64 ?>">

    <style>
        * {
            font-size: x-small;
        }

        th {
            background-color: #f7f7f7;
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
            text-align: center;
            font-size: 1.2em;
        }

        td {
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
            text-align: center;
            font-size: 1.2em;
        }

        table {
            border-collapse: collapse;
        }

        /* Para sobrescribir lo que está en div-table.css */
        .divTableCell,
        .divTableHead {
            padding: 0px !important;
            border: 0px !important;
        }
    </style>

    <h1><?php echo $api['business_name']; ?></h1>


    <!-- end of row-->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Datos Cliente</h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="feature_disable_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Rif</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $api['id']; ?></td>
                                    <td><?php echo $api['rif']; ?></td>
                                    <td><?php echo $api['business_name']; ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th scope="col">Fecha Registro</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Movil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $api['created_at']; ?></td>
                                    <td><?php echo $api['email']; ?></td>
                                    <td><?php echo $api['telephone']; ?></td>
                                    <td><?php echo $api['mobile']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- end of row-->



    <!-- end of row-->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Contratos</h4>

                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="feature_disable_table" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Contrato</th>
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Afiliado</th>
                                    <th scope="col">Pos</th>
                                    <th scope="col">Cuota</th>
                                    <th scope="col">Faltante</th>
                            </thead>
                            <tbody>
                                <?php foreach (($contratos ? $contratos : array()) as $c) { ?>
                                    <tr>
                                        <td><?= str_pad($c['contract_id'], 8, "0", STR_PAD_LEFT);
                                            ?></td>
                                        <td><?= $c['cuenta'] ?></td>
                                        <td><?= $c['afiliado'] ?></td>
                                        <td><?= $c['nropos'] ?></td>
                                        <td><?= $c['cuota'] ?></td>
                                        <td><?= $c['residuo'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- end of row-->


    <!-- DataTables  & Plugins -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/datatables.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/datatables.script.min.js"></script>

</body>

</html>