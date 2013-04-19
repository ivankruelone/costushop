<html>
<head>
   	<script src="<?php echo base_url();?>js/jquery/jquery-1.5.1.min.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.printElement.min.js"></script>
</head>
<body>
<?php
	$dat = $datos->row();
	include_once("CNumeroaLetra.php");
	$numalet= new CNumeroaletra;
	$numalet->setMoneda('PESOS');
	$numalet->setPrefijo("");
	$numalet->setSufijo('M. N.');

    $dia1 = new DateTime($row->fecha_alta);
    $dia2 = new DateTime($row->fecha_entrega);

	$dia = array(
			'1' => 'DOMINGO',
			'2' => 'LUNES',
			'3' => 'MARTES',
			'4' => 'MIERCOLES',
			'5' => 'JUEVES',
			'6' => 'VIERNES',
			'7' => 'SABADO'
			);
?>
<div align="center"><a id="imprime" href="#" class="button red">Imprimir</a></div>
<div style="width: 100%;" id="ticket">

<div style="width: 100%; clear: both;">
<div style="height: 325px; width: 100%;">.</div>
    <div align="center">
    <img src="<?php echo base_url();?>img/<?php echo LOGO_TICKET; ?>" border="0" width="350" align="middle" />
    </div>
    <div align="center">
                <?php echo $dat->sucursal; ?>
                <br /><?php echo $dat->razon; ?>
                <br />R. F. C. <?php echo $dat->rfc; ?>
                <br /><?php echo $dat->regimen; ?>
    </div>
    <div align="right">
                No. Orden: <strong><?php echo $row->id; ?></strong>
    </div>
    <div>
    <table width="100%">
    <tr>
        <td colspan="4">
            Nombre: <?php echo $row->nombre; ?>
        </td>
    </tr>
	<tr>
        <td>
            Tel.:
        </td>
        <td>
            <?php echo $row->telcasa; ?>
        </td>
        <td>
            Celular:
        </td>
        <td>
            <?php echo $row->telcel; ?>
        </td>
	</tr>
    <tr>
        <td>
            Fecha:
        </td>
        <td>
            <?php echo $dia[$row->dia_alta]." ".date_format($dia1, 'd/m/Y'); ?>
        </td>
        <td>
            Total de Prendas:
        </td>
        <td>
            <?php echo $row->no_prendas; ?>
        </td>
    </tr>
</table>
    </div>
    <div>
    <table width="100%">
    <thead>
        <tr>
            <th>CAN.</th>
            <th>DESC</th>
            <th>P.U.</th>
            <th>IMP.</th>
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
    <div>
    <table width="100%">
        <tr>
            <td align="right">TOTAL</td>
            <td align="right"><?php echo number_format($row->total, 2); ?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
            <?php
            	$numalet->setNumero($row->total);
                echo $numalet->letra();
            ?>
            </td>
        </tr>
    </table>
    </div>
    <div>
    <table width="100%">
    <tr>
        <td>Fecha de entrega: </td>
        <td><?php echo $dia[$row->dia]." ".date_format($dia2, 'd/m/Y'); ?></td>
        <td>Hora de entrega: </td>
        <td><?php echo $row->hora_entrega; ?></td>
    </tr>
    <tr>
        <td>Anticipo: </td>
        <td align="right"><?php echo number_format($row->abono, 2); ?></td>
        <td>Descuento: </td>
        <td align="right"><?php echo number_format($row->descu, 2); ?></td>
    </tr>
    <tr>
        <td colspan="2">Pendiente: </td>
        <td colspan="2" align="right"><?php echo number_format($row->pendiente, 2); ?></td>
    </tr>
    <tr>
        <td colspan="6" align="center">Observaciones: <?php echo $row->observacion; ?></td>
    </tr>
    <tr>
        <td colspan="6" style="background-color: black; color: white; font-weight: bolder; text-align: left;">
            <ul>
                <?php
                
                foreach($query3->result() as $row3)
                {
                    echo "<li>$row3->condicion</li>";
                }
                
                ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td colspan="6" align="center"><?php echo $dat->direccion; ?></td>
    </tr>
</table>
    </div>
	
	<div align="center" style="font-size: 150px; clear: both;">
                <?php echo $row->id; ?>
    </div>
	<div align="center" style="font-size: 35px; clear: both;">
                <?php echo $dia[$row->dia]; ?>
    </div>
	<p>---</p>
</div>
</div>
</body>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    //$('#imprime').click(function(){
	   $('#ticket').printElement();
	   window.close();
      return false;
    //});
});
</script>
</html>
<?php
//id, id_orden, fecha, tipo
$data = array(
   'id_orden' => $row->id ,
   'tipo' => 'talon',
   'id_usuario' => $this->session->userdata('id')
);
$this->db->set('fecha', 'now()', false);
$this->db->insert('audita_impresiones', $data); 
?>