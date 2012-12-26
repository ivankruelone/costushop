<div align="center">

<?php

    $data_orden = array(
              'name'        => 'orden',
              'id'          => 'orden',
              'size'        => '10'
            );

    $data_cliente = array(
              'name'        => 'cliente',
              'id'          => 'cliente',
              'size'        => '40'
            );
    	
?>

<div id="buscar" align="left">
<table>
<tbody>
<tr>
<td><?php echo form_label('Orden ', 'orden');?></td>
<td><?php echo form_input($data_orden);?></td>
<td><?php echo form_label('Cliente', 'cliente');?></td>
<td><?php echo form_input($data_cliente);?></td>
</tr>
</tbody>
</table>
</div>

<div id="resultado">
</div>

</div>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $('#orden').focus();
    entregas();
    
    //Autocompletar cliente    
    var fuente = "<?php echo site_url();?>/recepcion/busca_clientes_autocomplete/";

		$('#cliente').autocomplete({
			source: fuente,
            minLength: 2,
            select: function(event, ui){
                busca_cliente(ui.item.id);
                
            }
		});
        //

    //Autocompletar cliente    
    var fuente = "<?php echo site_url();?>/recepcion/busca_orden_autocomplete/";

		$('#orden').autocomplete({
			source: fuente,
            minLength: 1,
            select: function(event, ui){
                busca_orden(ui.item.id);
                
            }
		});
        //

        //Buscar Entregas Pendientes
        function entregas(){
            
            var url = "<?php echo site_url();?>/recepcion/entregas_pendientes";
        
            $.post( url, '', function(data) {
                $('#resultado').html(data);
            });
        }
            
        //
        
        //Buscar Entregas para hoy
        $('#entregas_hoy').click(function(event){
            
            event.preventDefault();
            
            var url = "<?php echo site_url();?>/recepcion/entregas_hoy";
        
            $.post( url, '', function(data) {
                $('#resultado').html(data);
            });
            
        });
        //
        

        //Busca cliente usando id devuelve tabla en #resultado
        function busca_cliente(id_cliente){
        var url = "<?php echo site_url();?>/recepcion/busca_orden_cliente";
    
        var variables = {
            id_cliente: id_cliente
        };
        
        $.post( url, variables, function(data) {
            $('#resultado').html(data);
            $('#cliente').val('').focus();
        });
        }
        //

        //Busca cliente usando id devuelve tabla en #resultado
        function busca_orden(orden){
        var url = "<?php echo site_url();?>/recepcion/busca_orden_id";
    
        var variables = {
            orden: orden
        };
        
        $.post( url, variables, function(data) {
            $('#resultado').html(data);
            $('#orden').val('').focus();
        });
        }
        //

    
});
</script>
