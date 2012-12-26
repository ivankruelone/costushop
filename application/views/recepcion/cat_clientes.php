<div align="center">

<?php

    $data_f1 = array(
              'name'        => 'nombre_cliente',
              'id'          => 'nombre_cliente',
              'size'        => '100'
            );

    	
?>

<div id="buscar" align="left">
<table>
<tbody>
<tr>
<td><?php echo form_label('Cliente', 'nombre_cliente');?></td>
<td><?php echo form_input($data_f1);?></td>
</tr>
<tr>
    <td colspan="2"><?php echo anchor('catalogo/tabla_clientes', 'Agrega un nuevo Cliente', array('class'=> 'button'));?></td>
</tr>
</tbody>
</table>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $('#nombre_cliente').focus();


        ///Autocompletar nombre del cliente
        
        var fuente = "<?php echo site_url();?>/recepcion/busca_clientes_autocomplete/";

		$('#nombre_cliente').autocomplete({
			source: fuente,
            minLength: 2,
            select: function(event, ui){
                if(ui.item.id > 0){
                    window.location = "<?php echo site_url();?>/catalogo/cambia_cliente/" + ui.item.id;
                }else{
                    window.location = "<?php echo site_url();?>/catalogo/tabla_clientes/";
                }
            }
		});
        
        // termina Autocompletar nombre del cliente


});
</script>