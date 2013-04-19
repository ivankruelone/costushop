<div align="center">

<?php

    $data_f1 = array(
              'name'        => 'fecha_inicial',
              'id'          => 'fecha_inicial',
              'size'        => '20',
              'class'       => 'datepicker',
              'value'       => date('Y-m-d')
            );

    $data_f2 = array(
              'name'        => 'fecha_final',
              'id'          => 'fecha_final',
              'size'        => '20',
              'class'       => 'datepicker',
              'value'       => date('Y-m-d')
            );
            
    echo form_open('recepcion/cuota_submit');
    	
?>

<div id="buscar" align="left">
<table>
<tbody>
<tr>
<td><?php echo form_label('Fecha Inicial ', 'fecha_inicial');?></td>
<td><?php echo form_input($data_f1);?></td>
<td><?php echo form_label('Fecha Final', 'fecha_final');?></td>
<td><?php echo form_input($data_f2);?></td>
</tr>
<tr>
<td colspan="6" align="center"><?php echo form_submit('', 'Generar Reporte', 'class="button green"');?></td>
</tr>
</tbody>
</table>



</div>

<?php
	echo form_close();
?>
<div><a id="imprime" href="#" class="button red">Imprimir</a></div>
<div><?php echo anchor('welcome', 'CERRAR', array('class' => 'button blue'));?></div>
<div id="tabla" align="center">
<?php
	if(isset($tabla)){
	   echo $tabla;
	
?>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto" ></div>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    $('#imprime').click(function(){
	   $('#tabla').printElement();
    });
    
    
            chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '<?php echo $titulo_grafica; ?>'
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Cuota de venta',
                data: [
                    <?php echo $arreglo; ?>
                ]
            }]
        });
});
</script>
<?php
	}
?>