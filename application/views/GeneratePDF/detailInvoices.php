<!DOCTYPE html>

<?php
$ci = &get_instance();
$ci->load->model("parameters"); // Cargar el modelo
$wcon = $ci->parameters->webConfigurations();
?>

<head>
    <meta charset="UTF-8" />
    <title><?= $wcon->tittle; ?></title>
    <style>
        img {
            width: 20em;
        }
    </style>
</head>

<body>
    <?php
    $path = FCPATH . 'assets/dist-assets/images/local/logo-pdf.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>

    <style>
        * {
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: #000;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            font-weight: bold;
            text-align: center;
            padding: 8px 5px;
        }

        td {
            text-align: center;
            padding: 5px;
        }
        
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .header-table td { padding: 0; }
        .info-table td { padding: 2px 0; }
        
        .resumen-table th, .resumen-table td {
            font-size: 10px;
        }
    </style>

    <table class="header-table" style="margin-bottom: 30px;">
        <tr>
            <td class="text-left" style="width: 50%;">
                <img src="<?= $base64 ?>" style="width: 250px;">
            </td>
            <td class="text-right" style="width: 50%; padding-top: 15px;">
                <a href="https://sunmivzla.com/" style="color: #0000ee; text-decoration: underline;">www.sunmivzla.com</a><br>
            </td>
        </tr>
    </table>

    <?php $primer_contrato = !empty($contratos) ? $contratos[0] : null; ?>

    <table class="info-table" style="margin-bottom: 40px;">
        <tr>
            <td class="text-left" style="width: 60%; vertical-align: top;">
                <div style="font-size: 19px; margin-bottom: 5px;">Cliente:</div>
                <div><?= isset($api['rif']) ? $api['rif'] : '' ?></div>
                <div style="text-transform: uppercase;"><?= isset($api['business_name']) ? $api['business_name'] : '' ?></div>
                <div style="max-width: 300px; text-transform: uppercase;">
                    <?= !empty($api['address']) ? $api['address'] : (!empty($api['direccion']) ? $api['direccion'] : '') ?>
                </div>
                <div><?= !empty($api['mobile']) ? (strpos($api['mobile'], '+') === 0 ? $api['mobile'] : '+58 ' . $api['mobile']) : (!empty($api['telephone']) ? $api['telephone'] : '') ?></div>
            </td>
            <td class="text-left" style="width: 40%; vertical-align: top; padding-left: 20px;">
                <div style="margin-top: 25px;">
                    <b>Modelo:</b> <?= isset($contratoDetails['modelo']) ? $contratoDetails['modelo'] : '' ?><br>
                    <b>Serial:</b> <?= isset($contratoDetails['serialPos']) ? $contratoDetails['serialPos'] : '' ?><br>
                    <b>Plan:</b> <?= isset($contratoDetails['plan']) ? $contratoDetails['plan'] : '' ?> <br>
                    <?php 
                        $tipo_pago_label = '';
                        if (isset($contratoDetails['tipo_pago'])) {
                            $mapa_tipos = ['D' => 'Diario', 'M' => 'Mensual', 'Q' => 'Quincenal'];
                            $tipo_pago_label = isset($mapa_tipos[$contratoDetails['tipo_pago']]) ? $mapa_tipos[$contratoDetails['tipo_pago']] : $contratoDetails['tipo_pago'];
                        }
                    ?>
                    <b>Tipo:</b> <?= $tipo_pago_label ?> <br>
                    <b>Fecha:</b> <?= date('d M. Y') ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="text-center font-bold" style="font-size: 18px; margin-bottom: 20px;">
        Resumen de Movimientos
    </div>

    <table class="resumen-table">
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Mes Cobro</th>
                <th>Cargos</th>
                <th>Descripción de Pago</th>
                <th><!--Fecha de Pago--></th>
                <th>Abonos</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>

            <?php 
            $total_cargos = 0;
            $total_abonos = 0;
            $balance = 0;
            foreach (($contratos ? $contratos : array()) as $c) { 
                $cargo = isset($c['cuota']) ? (float)$c['cuota'] : 0;
                $abono = $cargo - (isset($c['residuo']) ? (float)$c['residuo'] : 0);
                $balance += ($cargo - $abono);
                
                $total_cargos += $cargo;
                $total_abonos += $abono;
                
                $descripcion = "Domiciliación";
                $fecha_generado = isset($c['fecha_mes_cobro']) ? date('m-Y', strtotime($c['fecha_mes_cobro'])) : date('m-Y');
                $fecha_pago = (isset($c['fecha_conciliado']) && !empty($c['fecha_conciliado'])) ? date('d-m-Y', strtotime($c['fecha_conciliado'])) : '----';
            ?>
            <tr>
                <td>Cargo - No. <?= $c['id']?></td>
                <td><?= $fecha_generado ?></td>
                <td><?= $cargo > 0 ? $cargo : '' ?></td>
                <td><?= $descripcion ?></td>
                <td><?= $fecha_pago ?></td>
                <td><?= $abono > 0 ? $abono . (isset($c['tasa']) ? ' (Bs. ' . number_format($abono * (float)$c['tasa'], 2) . ')' : '') : '----' ?></td>
                <!-- <td><? //= number_format($balance, 2) ?></td> -->
                <td><?= number_format(($cargo - $abono), 2) ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td class="font-bold" colspan="2" style="padding-top: 15px;">Totales</td>
                <td class="font-bold" style="padding-top: 15px;">$ <?= number_format($total_cargos, 2) ?></td>
                <td colspan="2" style="padding-top: 15px;"></td>
                <td class="font-bold" style="padding-top: 15px;">$ <?= number_format($total_abonos, 2) ?></td>
                <td class="font-bold" style="padding-top: 15px;">$ <?= number_format($balance, 2) ?></td>
            </tr>
        </tbody>
    </table>

</body>

</html>