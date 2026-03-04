<html><br>

<head>
    <title>IZI Asistencias</title>
</head>

<body>
    <style>
        h3 {
            font-family: Verdana;
            font-size: 18pt;
            font-style: normal;
            font-weight: bold;
            color: #232e7c;
            text-align: center;
        }

        table {
            font-family: Verdana;
            color: black;
            font-size: 12pt;
            font-style: normal;
            font-weight: bold;
            text-align: left;
            border-collapse: collapse;
            width: 90%;
        }
    </style>
    <h3>IZI Asistencia</h3>

    <table align="center" cellpadding="8" cellspacing="8" border="0">
        <thead>
            <tr>
                <th>Cliente</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?= $row->nombre; ?> <?= $row->apellido; ?><br>
                    Contrato # : <?= $row->id; ?><br>
                    CI : <?= $row->cedula; ?><br>
                    Rif : <?= $row->rif; ?><br>
                    Periodicidad : <?= $row->nperiodicidad; ?><br>
                    Cantidad Afiliados : <?= $row->afiliados; ?><br>
                    Nivel : <?= $row->nnivel; ?><br>
                    Plan : <?= $row->nplan; ?><br>
                    Banco : <?= $row->nbanco; ?><br>
                </td>
                <td style="text-align:right">
                    <?= $row->correo; ?><br>
                    <?= $row->celular; ?><br>
                    <?= $row->pago; ?><br>
                    Monto Anual : <?= $row->monto; ?><br>
                    Monto X Cuota : <?= $row->cobrar; ?><br>
                </td>
            </tr>
        </tbody>
    </table>
    <br><br>

    <table align="center" cellpadding="8" cellspacing="8" border="3">
        <thead>
            <tr>
                <th># Cobro</th>
                <th>Usd</th>
                <th>Bs</th>
                <th>Banco</th>
                <th>Generado</th>
                <th>Conciliado</th>
                <th>Referencia</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($list ? $list : array()) as $k) { ?>
                <tr>
                    <td><?= $k->ncobro; ?></td>
                    <td><?= $k->usd; ?></td>
                    <td><?= $k->monto; ?></td>
                    <td><?= $k->nbanco; ?></td>
                    <td><?= $k->fecha_mes_cobro; ?></td>
                    <td><?= $k->fecha_conciliado; ?></td>
                    <td><?= $k->respuesta; ?></td>
                    <td>
                        <?php require(APPPATH . "views/invoices/modals/status.php"); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>