  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'prendas_c_form_cambia');
    echo form_open('catalogo/cambia_condicion_submit', $atributos);
    
        $data_nom = array(
              'name'        => 'nom',
              'id'          => 'nom',
              'value'       => $nom,
              'maxlength'   => '70',
              'size'        => '100%',
              'autofocus'   => 'autofocus'
            );

 
  ?>
  
  <table>

 <tr>
	<td><strong>Condici&oacute;n: </strong><?php echo form_input($data_nom, "", 'required');?><span id="mensaje"></span></td>
</tr>
<tr>
    <td><strong>Tipo: </strong><?php echo form_dropdown('tipo',array('1'=>'Activo','0'=>'Inactivo'),$tipo, 'id="tipo"')?></td>
</tr>
<tr>
	<td><?php echo form_submit('envio', 'CAMBIA CONDICION');?></td>
</tr>
</table>
<input type="hidden" value="<?php echo $id?>" name="id" id="id" />
  <?php
	echo form_close();
  ?>


</div>    
  <script language="javascript" type="text/javascript">
    $(window).load(function () {
        $("#nom").focus();
    });
    
    $(document).ready(function(){
    


    $('#prendas_c_form_cambia').submit(function() {
        
        var nom = $('#nom').attr("value");
        
         
    	  if(nom.length >0 ){
    	    if(confirm("Seguro que los datos son correctos?")){
    	    return true;
    	    }else{
    	    return false;
    	    }
    	    
    	  }else{

    	    alert('Verifica la informacion por favor');
    	    $('#nom').focus();
    	    return false    

    	        }
    	  });
          
          
        
     
});
  </script>