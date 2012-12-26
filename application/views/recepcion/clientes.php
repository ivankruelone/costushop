<div><a id="imprime" href="#" class="button red">Imprimir</a></div>
<div><?php echo anchor('welcome', 'CERRAR', array('class' => 'button blue'));?></div>
<div id="tabla" align="center">
<?php
	if(isset($tabla)){
	   echo $tabla;
	}
?>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    $('#imprime').click(function(){
	   $('#tabla').printElement();
    });
});
</script>