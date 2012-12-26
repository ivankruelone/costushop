<?php
	echo $tabla;
?>
<script>
$(document).ready(function(){
	$('#busca').keyup(function(){
	
		var busca = $(this).attr('value');
		var largo = busca.length;
		if(largo >= 4){
			    
				var url = "<?php echo site_url();?>/catalogo/busca_clientes";

                var variables = {
                    busca: busca
                };
                
                $.post( url, variables, function(data) {
                    
                        $('#resultado_busqueda').html(data);                
                });
		}
	});
});
</script>