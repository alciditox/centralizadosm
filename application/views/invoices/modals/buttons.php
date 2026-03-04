<?php //'Pendiente','Por Conciliar','Conciliado' 
?>


<?php

switch ($k->status) {
    case 'Pendiente':
?>
        <button class="btn btn-success ripple m-1" type="button" data-toggle="modal" data-target=".modal-subir" data-banconame="<?= $k->bancoName; ?>" data-id="<?= $k->id; ?>" data-date="<?= $k->fecha_generado; ?>" data-banco="<?= $k->banco; ?>" data-target=".conciliar">Subir Archivo</button>

        <button class="btn btn-danger ripple m-1" type="button" data-toggle="modal" data-target=".modal-anular" data-banconame="<?= $k->bancoName; ?>" data-id="<?= $k->id; ?>" data-date="<?= $k->fecha_generado; ?>" data-banco="<?= $k->banco; ?>" data-target=".conciliar">Anular</button>

    <?php
        break;

    case 'Por Conciliar':
    ?>
        <button class="btn btn-info ripple m-1" type="button" data-toggle="modal" data-target=".modal-conciliar" data-banconame="<?= $k->bancoName; ?>" data-id="<?= $k->id; ?>" data-date="<?= $k->fecha_generado; ?>" data-banco="<?= $k->banco; ?>" data-registros="<?= $k->total_register; ?>" data-target=".conciliar">Conciliar</button>
    <?php
        break;

    case 'Conciliado':
    ?>
        <a href="<?= base_url('') . $k->recived; ?>" download>
            <button class="btn btn-dark ripple m-1" type="button">Descargar Archivo</button>
        </a>

    <?php
        break;


    case 'Anulado':
    ?>
        <br>
        <strong>Motivo de Anulacion: </strong>
        <strong><?= $k->observacion; ?></strong>
        <br>
<?php
        break;

    default:
        break;
}

?>