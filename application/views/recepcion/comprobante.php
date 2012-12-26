<?php
	$dat = $datos->row();
	include_once("CNumeroaLetra.php");
	$numalet= new CNumeroaletra;
	$numalet->setMoneda('PESOS');
	$numalet->setPrefijo("");
	$numalet->setSufijo('M. N.');
?>
<div align="left" style="width: 400px; float: left;">
<table width="400px">
    <tr>
        <td>
            <div align="center">
            <img src="<?php echo base_url();?>img/<?php echo LOGO_TICKET; ?>" border="0" width="100" align="middle" />
            
            </div>
        </td>
        <td>
            <div align="center" style="font-size: xx-small;">
                <?php echo $dat->sucursal; ?>
                <br /><?php echo $dat->razon; ?>
                <br />R. F. C. <?php echo $dat->rfc; ?>
                <br /><?php echo $dat->regimen; ?>
            </div>
        </td>
        <td>
            <div align="center">
                No. Orden: <?php echo $row->id; ?>
            </div>
        </td>
    </tr>
</table>

<table width="400px" style="font-size: x-small;">
    <tr>
        <td>
            Nombre:
        </td>
        <td>
            <?php echo $row->nombre; ?>
        </td>
        <td>
            Total de Prendas:
        </td>
        <td>
            <?php echo $row->no_prendas; ?>
        </td>
    </tr>
    <tr>
        <td>
            Tel&eacute;fono:
        </td>
        <td>
            <?php echo $row->telcasa; ?>
        </td>
        <td>
            Fecha:
        </td>
        <td>
            <?php echo $row->fecha_alta; ?>
        </td>
    </tr>
</table>
<div style="width: 400px; height: 180px;">
<table width="400px" style="font-size: x-small;">
    <thead>
        <tr>
            <th>CAN.</th>
            <th>DESCRIPCION</th>
            <th>P. UNITARIO</th>
            <th>IMPORTE</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($query2->result() as $row2){?>
        <tr>
            <td><?php echo $row2->cantidad; ?></td>
            <td><?php echo $row2->prendax.' '.$row2->serviciox; ?></td>
            <td align="right"><?php echo number_format($row2->precio, 2); ?></td>
            <td align="right"><?php echo number_format($row2->cantidad * $row2->precio, 2); ?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
</div>
<table width="400px" style="font-size: x-small;">
        <tr>
            <td align="right">TOTAL</td>
            <td align="right"><?php echo number_format($row->total, 2); ?></td>
        </tr>
</table>

<table width="400px" style="font-size: x-small;">
    <tr>
        <td>Fecha de entrega: </td>
        <td><?php echo $row->fecha_entrega; ?></td>
        <td>Anticipo: </td>
        <td align="right"><?php echo number_format($row->abono, 2); ?></td>
        <td>Descuento: </td>
        <td align="right"><?php echo number_format($row->descu, 2); ?></td>
    </tr>
    <tr>
        <td>Hora de entrega: </td>
        <td><?php echo $row->hora_entrega; ?></td>
        <td>Pendiente: </td>
        <td align="right"><?php echo number_format($row->pendiente, 2); ?></td>
        <td>Status</td>
        <td align="center"><?php echo $row->estatusx; ?></td>
    </tr>
    <tr>
        <td colspan="6" align="center">
            <?php
            	$numalet->setNumero($row->total);
                echo $numalet->letra();
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" align="center"><?php echo $dat->direccion; ?></td>
    </tr>
</table>

</div>


<div align="left" style="width: 400px; float: right;">
<table width="400px">
    <tr>
        <td>
            <div align="center">
            <img src="<?php echo base_url();?>img/logo_blanco.png" border="0" width="100" align="middle" />
            
            </div>
        </td>
        <td>
            <div align="center" style="font-size: xx-small;">
                <?php echo $dat->sucursal; ?>
                <br /><?php echo $dat->razon; ?>
                <br />R. F. C. <?php echo $dat->rfc; ?>
                <br /><?php echo $dat->regimen; ?>
            </div>
        </td>
        <td>
            <div align="center">
                No. Orden: <?php echo $row->id; ?>
            </div>
        </td>
    </tr>
</table>

<table width="400px" style="font-size: x-small;">
    <tr>
        <td>
            Nombre:
        </td>
        <td>
            <?php echo $row->nombre; ?>
        </td>
        <td>
            Total de Prendas:
        </td>
        <td>
            <?php echo $row->no_prendas; ?>
        </td>
    </tr>
    <tr>
        <td>
            Tel&eacute;fono:
        </td>
        <td>
            <?php echo $row->telcasa; ?>
        </td>
        <td>
            Fecha:
        </td>
        <td>
            <?php echo $row->fecha_alta; ?>
        </td>
    </tr>
</table>
<div style="width: 400px; height: 180px;">
<table width="400px" style="font-size: x-small;">
    <thead>
        <tr>
            <th>CAN.</th>
            <th>DESCRIPCION</th>
            <th>P. UNITARIO</th>
            <th>IMPORTE</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($query2->result() as $row2){?>
        <tr>
            <td><?php echo $row2->cantidad; ?></td>
            <td><?php echo $row2->prendax.' '.$row2->serviciox; ?></td>
            <td align="right"><?php echo number_format($row2->precio, 2); ?></td>
            <td align="right"><?php echo number_format($row2->cantidad * $row2->precio, 2); ?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
</div>
<table width="400px" style="font-size: x-small;">
        <tr>
            <td align="right">TOTAL</td>
            <td align="right"><?php echo number_format($row->total, 2); ?></td>
        </tr>
</table>

<table width="400px" style="font-size: x-small;">
    <tr>
        <td>Fecha de entrega: </td>
        <td><?php echo $row->fecha_entrega; ?></td>
        <td>Anticipo: </td>
        <td align="right"><?php echo number_format($row->abono, 2); ?></td>
        <td>Descuento: </td>
        <td align="right"><?php echo number_format($row->descu, 2); ?></td>
    </tr>
    <tr>
        <td>Hora de entrega: </td>
        <td><?php echo $row->hora_entrega; ?></td>
        <td>Pendiente: </td>
        <td align="right"><?php echo number_format($row->pendiente, 2); ?></td>
        <td>Status</td>
        <td align="center"><?php echo $row->estatusx; ?></td>
    </tr>
    <tr>
        <td colspan="6" align="center">
            <?php
            	$numalet->setNumero($row->total);
                echo $numalet->letra();
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" align="center"><?php echo $dat->direccion; ?></td>
    </tr>
</table>

</div>
