  <blockquote>
    
    <p><strong><?php echo $titulo;?></strong></p>
  </blockquote>
<div align="center">
  <?php
	$atributos = array('id' => 'prendas_c_form_cambia');
    echo form_open('catalogo/cambia_prenda_datos', $atributos);
 
  ?>
  
  <table>
<tr>

 <tr>
	<td><strong>Nombre de la prenda: </strong><?php echo $nom ?><span id="mensaje"></span><br />
    <strong>Tipo: </strong><?php echo form_dropdown('tipo',array('1'=>'Activo','0'=>'Inactivo'),$tipo)?></td>
</tr>

	<td><?php echo form_submit('envio', 'CAMBIA PRENDA');?></td>
</tr>
</table>
<input type="hidden" value="<?php echo $id?>" name="id" id="id" />
<input type="hidden" value="<?php echo $nom?>" name="nom" id="nom" />
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
    


    $('#prendas_c_form_cambia').submit(function() {
        
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