  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'servicios_c_form_cambia');
    echo form_open('catalogo/cambia_servicios_datos', $atributos);
 $data_precio = array(
              'name'        => 'precio',
              'id'          => 'precio',
              'value'       => $precio,
              'maxlength'   => '70',
              'autofocus'   => 'autofocus'
            );
 $data_nombre = array(
              'name'        => 'nombre',
              'id'          => 'nombre',
              'value'       => $nom,
              'maxlength'   => '255',
              'class'       => 'medium'
            );
  ?>
  
  <table>
<tr>

 <tr>
    <td><strong>Prenda: </strong><?php echo $prendax ?></td>
	<td><strong>Servicio: <?php echo form_input($data_nombre, "", 'required');?></td>
</tr>
<tr>
	<td>Precio: <?php echo form_input($data_precio, "", 'required');?></td>
	<td><strong>Tipo: </strong><?php echo form_dropdown('tipo',array('1'=>'Activo','0'=>'Inactivo'),$tipo)?></td>
</tr>

	<td><?php echo form_submit('envio', 'CAMBIA SERVICIO');?></td>
</tr>
</table>
<input type="hidden" value="<?php echo $id?>" name="id" id="id" />
<input type="hidden" value="<?php echo $pre?>" name="pre" id="pre" />
  <?php
	echo form_close();
  ?>
<table align="center">
<tr>
	<td><?php echo $tabla;?></td>
</tr>
</table>

</div>    
  <script language="javascript" type="text/javascript">
    
    $(document).ready(function(){
    


    $('#servicios_c_form_cambia').submit(function() {
        
        var precio = $('#precio').attr("value");
        
         
    	  if(precio >0 ){
    	    if(confirm("Seguro que los datos son correctos?")){
    	    return true;
    	    }else{
    	    return false;
    	    }
    	    
    	  }else{

    	    alert('Verifica la informacion de producto por favor');
    	    $('#nombre').focus();
    	    return false    

    	        }
    	  });
          
          
        
     
});
  </script>