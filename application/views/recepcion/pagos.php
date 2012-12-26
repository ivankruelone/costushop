<div align="center">
<h1>No. de Orden: <?php echo $id?></h1>
  <?php
	$atributos = array('id' => 'recepcion_c_form_agrega');
    echo form_open('recepcion/insert_recepcion', $atributos);

    $data_id = array(
              'name'        => 'cliente',
              'id'          => 'cliente',
              'value'       => $orden->id_cliente,
              'maxlength'   => '13',
              'size'        => '12',
              'disabled'   => 'disabled'
            );

    $data_nom = array(
              'name'        => 'nom',
              'id'          => 'nom',
              'value'       => $orden->nombre,
              'maxlength'   => '70',
              'size'        => '100',
              'disabled'   => 'disabled'
            );

    $data_abono = array(
              'name'        => 'abono',
              'id'          => 'abono',
              'maxlength'   => '10',
              'size'        => '10',
              'type'        => 'text'
            );
            
    
    if($orden->id_status <> 3){
        
        $a = array('disabled' => 'disabled');
        
        $data_abono = array_merge($data_abono, $a);
        $desha = ' disabled="disabled"';
        
    }else{
        
        $desha = null;
        
    }
    
  ?>
  
  <table>
<tr>
	<td align="left">CLIENTE ID : </td>
    <td> <?php echo form_input($data_id, "");?></td>
	<td align="left">NOMBRE : </td>
    <td> <?php echo form_input($data_nom, "");?></td>
</tr>
<tr>
	<td align="left">IMPORTE : </td>
    <td><?php echo number_format($orden->importe, 2)?></td>
	<td align="left">DESCUENTO : </td>
    <td><?php echo number_format($orden->descu, 2)?></td>
</tr>
<tr>
	<td align="left">TOTAL A PAGAR : </td>
    <td id="total_pagar"><?php echo number_format($orden->total, 2)?></td>
	<td>PENDIENTE : </td>
    <td id="deuda"><?php echo number_format($orden->pendiente, 2)?></td>

</tr>
<tr>
<td colspan="4" align="center">
<?php
    if($orden->id_status == 3){
       echo anchor('recepcion/entregar/'.$id, 'Entregar.', array('class' => 'button green', 'id' => 'entregar'));
       echo '  ';
       echo anchor('recepcion/tabla_recepcion/'.$id, 'Regresar a la orden.', array('class' => 'button red', 'id' => 'entregar'));
	}
?>
</td>
<input type="hidden" value="<?php echo $orden->id_status; ?>" name="estatus" id="estatus" />
<input type="hidden" value="<?php echo $id; ?>" name="id" id="id" />
</tr>
  <?php
	echo form_close();
  ?>

<tr>
    <td colspan="4">
    <?php echo form_dropdown('tipo_pago', $tipo_pago, '', 'id="tipo_pago"'.$desha);?>
    Abono: <?php echo form_input($data_abono);?>
    <?php if($orden->id_status == 3){?>
    <a class="button blue" href="#" id="agregar_pago">Agregar Pago</a>
    <?php }?>
    </td>
</tr>
</table>

<div id="tabla_recepcion">
</div>
</div>    
  <script language="javascript" type="text/javascript">
    $(window).load(function () {
        $("#nom").focus();
    });
    
    $(document).ready(function(){
        
        var id = $('#id').attr('value');
        abonos();
        
        $('#entregar').click(function(event){
            var deuda = $('#deuda').html();
            deuda = parseFloat(deuda);
            if(deuda == 0){
                if(confirm('Seguro que deseas poner es estatus de entregada a esta orden?')){
                    
                }else{
                    event.preventDefault();
                }
            }else{
                event.preventDefault();
                alert('No puedes Cambiar el estatus de esta orden, ya que hay un adeudo de MX $ ' + deuda.toFixed(2));
            }
        })
        
    

        
        $('#agregar_pago').click(function(){
            
            var tipo_pago = $('#tipo_pago').attr('value');
            var abono = $('#abono').attr('value');
            var deuda = $('#deuda').html();
            deuda = parseFloat(deuda);
                
            if(tipo_pago > 0){
                
                if(abono > 0 && abono <= deuda){

                    if(confirm('Estas seguro que deseas agregar este abono MX $ ' + abono + ' ?')){
                        agrega_abono(id, tipo_pago, abono);
                    }
                }else{
                    alert('El abono debe ser mayor a MX $ 0.00 y menor a MX $ ' + deuda.toFixed(2));
                }
                
            }else{
                alert('Elige el tipo de pago');
            }
        });
        
        
        function agrega_abono(id, tipo_pago, abono){
            var url = "<?php echo site_url();?>/recepcion/agrega_abono";
        
            var variables = {
                id: id,
                tipo_pago: tipo_pago,
                abono: abono
            };
            
            $.post( url, variables, function(data) {
                $('#abono').val('');
                $('#tipo_pago').val(0);
                $('#tabla_recepcion').html(data);
                $('#tipo_pago').focus();
            });
        }
        
        //Termina Funcion para agregar un servicio
        
        //Funcion para traer detalle de una orden sin guardar

        function abonos(){
            var url = "<?php echo site_url();?>/recepcion/abonos";
        
            var variables = {
                id: id
            };
            
            $.post( url, variables, function(data) {
                $('#tabla_recepcion').html(data);
            });
        }
        
        //Termina Funcion para traer detalle de una orden sin guardar
        


});
  </script>
