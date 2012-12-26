  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'servicios_c_form_agrega');
    echo form_open('catalogo/insert_servicios', $atributos);
    $data_nom = array(
              'name'        => 'nom',
              'id'          => 'nom',
              'value'       => '',
              'maxlength'   => '70',
              'size'        => '50',
              'autofocus'   => 'autofocus'
            );
    $data_precio = array(
              'name'        => 'precio',
              'id'          => 'precio',
              'value'       => '',
              'maxlength'   => '70',
              'size'        => '50',
              'autofocus'   => 'autofocus'
            );

  ?>
  
  <table>
<tr>
<tr>
	<td>Prenda: </td>
	<td align="left"><?php echo form_dropdown('pre', $prex, '', 'id="pre"') ;?> </td>
</tr>
 <tr>
	<td>Servicio: </td>
	<td><?php echo form_input($data_nom, "", 'required');?><span id="mensaje"></span></td>

</tr>
 <tr>
	<td>Precio: </td>
	<td><?php echo form_input($data_precio, "", 'required');?><span id="mensaje"></span></td>

</tr>


	<td colspan="6"><?php echo form_submit('envio', 'AGREGAR SERVICIO');?></td>
</tr>
</table>
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
    $(window).load(function () {
        $("#pre").focus();
    });
    
    $(document).ready(function(){
    

    $('#servicios_c_form_agrega').submit(function() {
        
        var pre = $('#pre').attr("value");
        var precio = $('#precio').attr("value");
        
         
    	  if(pre > 0 && precio > 0){
    	    echo ;
    	    if(confirm("Seguro que los datos son correctos?")){
    	    return true;
    	    }else{
    	    return false;
    	    }
    	    
    	  }else{

    	    alert('Verifica la informacion de producto por favor');
    	    $('#clave').focus();
    	    return false    

    	        }
    	  });
          
          
        
     
});
  </script>