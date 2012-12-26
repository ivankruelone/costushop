  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'prendas_c_form_agrega');
    echo form_open('catalogo/insert_prenda', $atributos);
    $data_nom = array(
              'name'        => 'nom',
              'id'          => 'nom',
              'value'       => '',
              'maxlength'   => '70',
              'size'        => '50',
              'autofocus'   => 'autofocus'
            );

  ?>
  
  <table>
<tr>

 <tr>
	<td>Nombre de la prenda: </td>
	<td><?php echo form_input($data_nom, "", 'required');?><span id="mensaje"></span></td>

</tr>


	<td colspan="6"><?php echo form_submit('envio', 'AGREGAR PRENDA');?></td>
</tr>
</table>
<input type="hidden" value="0" name="valida" id="valida" />
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
        $("#nom").focus();
    });
    
    $(document).ready(function(){
    
 

    $('#prendas_c_form_agrega').submit(function() {
        
        var nom = $('#nom').attr("value");
        
         
    	  if(nom >0 ){
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