  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'condiciones_c_form_agrega');
    echo form_open('catalogo/insert_condicion', $atributos);
    $data_nom = array(
              'name'        => 'nom',
              'id'          => 'nom',
              'value'       => '',
              'maxlength'   => '255',
              'autofocus'   => 'autofocus',
              'class'       => 'medium'
            );

  ?>
  
  <table>
<tr>

 <tr>
	<td>Condici&oacute;n: </td>
	<td><?php echo form_input($data_nom, "", 'required');?><span id="mensaje"></span></td>

</tr>


	<td colspan="6"><?php echo form_submit('envio', 'AGREGAR CONDICION');?></td>
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
    
 

    $('#condicion_c_form_agrega').submit(function() {
        
        var nom = $('#nom').attr("value");
        
         
    	  if(nom.length > 0 ){
    	    if(confirm("Seguro que los datos son correctos?")){
    	    return true;
    	    }else{
    	    return false;
    	    }
    	    
    	  }else{

    	    alert('Verifica la informacion por favor.');
    	    $('#nom').focus();
    	    return false    

    	        }
    	  });
          
          
        
     
});
  </script>