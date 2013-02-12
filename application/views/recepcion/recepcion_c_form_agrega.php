<div align="center">
<h1>No. de Orden: <?php echo $id?></h1>
  <?php
	$atributos = array('id' => 'recepcion_c_form_agrega');
    echo form_open('recepcion/insert_recepcion', $atributos);
    
    if($orden->no_prendas == 0){
        $orden->no_prendas = null;
    }
    
    if($orden->descuentox == 0){
        $orden->descuentox = null;
    }
    

    $data_id = array(
              'name'        => 'cliente',
              'id'          => 'cliente',
              'value'       => $orden->id_cliente,
              'maxlength'   => '13',
              'size'        => '12',
              'disabled'   => 'disabled'
            );

    $data_nom = array(
              'name'        => 'nom',
              'id'          => 'nom',
              'value'       => $orden->nombre,
              'maxlength'   => '70',
              'size'        => '50',
              'autofocus'   => 'autofocus'
            );

    $data_fecha_alta = array(
              'name'        => 'fecha_alta',
              'id'          => 'fecha_alta',
              'value'       => $orden->fecha_alta,
              'maxlength'   => '10',
              'size'        => '12',
              'type'        => 'text',
              'disabled'   => 'disabled'
            );

    $data_fecha_entrega = array(
              'name'        => 'fecha_entrega',
              'id'          => 'fecha_entrega',
              'value'       => $orden->fecha_entrega,
              'maxlength'   => '10',
              'size'        => '10',
              'type'        => 'text',
              'class'       => 'datepicker'
            );
            
    $data_estatus = array(
              'name'        => 'estatus',
              'id'          => 'estatus',
              'value'       => $orden->estatusx,
              'maxlength'   => '10',
              'size'        => '12',
              'type'        => 'text',
              'disabled'   => 'disabled'
            );
            
    $data_can = array(
              'name'        => 'can',
              'id'          => 'can',
              'maxlength'   => '10',
              'size'        => '12',
              'type'        => 'text'
            );

    $data_prendas = array(
              'name'        => 'noprendas',
              'id'          => 'noprendas',
              'value'       => $orden->no_prendas,
              'maxlength'   => '10',
              'size'        => '12',
              'type'        => 'text',
              'required'    => 'required'
            );

    $data_descu = array(
              'name'        => 'descuento',
              'id'          => 'descuento',
              'value'       => $orden->descuentox,
              'maxlength'   => '2',
              'size'        => '12',
              'type'        => 'text',
              'required'    => 'required'
            );

    $data_obser = array(
              'name'        => 'obser',
              'id'          => 'obser',
              'value'       => $orden->observacion,
              'rows'        => '1',
              'cols'        => '100',
              'placeholder' => 'Anote aqui sus observaciones'
            );
    
    
    if($orden->id_status <> 1){
        
        $a = array('disabled' => 'disabled');
        
        $data_nom = array_merge($data_nom, $a);
        $data_fecha_entrega = array_merge($data_fecha_entrega, $a);
        $data_prendas = array_merge($data_prendas, $a);
        $data_descu = array_merge($data_descu, $a);
        $data_obser = array_merge($data_obser, $a);
        $data_can = array_merge($data_can, $a);
        $desha = ' disabled="disabled"';
        
    }else{
        
        $desha = null;
        
    }
    
  ?>
  
  <table>
<tr>
	<td align="left">ID CLIENTE : </td>
    <td> <?php echo form_input($data_id, "");?></td>
	<td align="left">CLIENTE : </td>
    <td> <?php echo form_input($data_nom, ""); ?>
    <a href="#agrega_cliente" class="open-modal button green" id="boton_agrega_cliente">Agregar</a>
    </td>
</tr>
 <tr>
	<td align="left">FECHA DE ALTA : </td>
    <td> <?php echo form_input($data_fecha_alta);?></td>
	<td>FECHA DE ENTREGA : </td>
    <td><?php echo form_input($data_fecha_entrega);?></td>

</tr>
 <tr>
	<td align="left">STATUS : </td>
    <td> <?php echo form_input($data_estatus);?></td>
	<td>HORA DE ENTREGA : </td>
    <td><?php echo form_dropdown('hora_entrega', $hora, $orden->hora_entrega, 'id="hora_entrega"'.$desha);?></td>

</tr>
<?php
	if($orden->id_status == 2){
?>
 <tr>
	<td align="left">MOTIVO CANCELACION: </td>
    <td> <?php echo $orden->motivo_cancelacion;?></td>
	<td>FECHA Y HORA CANCELACION: </td>
    <td><?php echo $orden->fecha_cancelacion;?></td>

</tr>

<?php
	}
?>
<tr>
    <td colspan="4"><?php echo form_textarea($data_obser);?></td>
</tr>

<tr>
    <td colspan="4">
    <?php echo form_dropdown('prenda', $prenda, '', 'id="prenda"'.$desha);?>
    <?php echo form_dropdown('servicio', array('0' => 'Elige una Prenda Primero'), '', 'id="servicio"'.$desha);?>
    Cantidad: <?php echo form_input($data_can);?>
    <?php if($orden->id_status == 1){?>
    <a class="button blue" href="#" id="agregar_servicio">Agregar Servicio</a>
    <a href="#agrega_servicio" class="open-modal button blue" id="boton_agrega_servicio">Nuevo Servicio</a>
    <?php }?>
    </td>
</tr>
<tr>
	<td align="left"># DE PRENDAS : </td>
    <td> <?php echo form_input($data_prendas);?></td>
	<td>% DESCUENTO : </td>
    <td><?php echo form_input($data_descu);?></td>

</tr>
<tr>
<td colspan="4" align="center">

<?php
	if($orden->id_status == 1){
       echo anchor('recepcion/cerrar_orden/'.$id, 'Cerrar Orden y pasarla a proceso.', array('class' => 'button green', 'id' => 'cerrar_orden'));
	}elseif($orden->id_status == 3){
	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
       echo anchor('recepcion/pagos/'.$id, 'Pagos.', array('class' => 'button green', 'id' => 'pagos'));
       echo '</span>';
       $atts = array(
              'width'      => '900',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0',
              'menubar'     => 'yes',
              'class'       => 'button blue',
              'id'          => 'imprimir'
            );
       $atts2 = array(
              'width'      => '400',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0',
              'menubar'     => 'yes',
              'class'       => 'button blue',
              'id'          => 'imprimir2'
            );
//	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
//       echo anchor_popup('recepcion/comprobante/'.$id, 'Imprimir Recibo', $atts);
//       echo '</span>';
	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
       echo anchor_popup('recepcion/ticket/'.$id, 'Imprimir Ticket', $atts2);
       echo '</span>';
	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
       echo anchor_popup('recepcion/talon/'.$id, 'Imprimir Talon de Servicio', $atts2);
       echo '</span>';
	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
       echo anchor('', 'Cancelar Orden', array('class' => 'button reed', 'id' => 'cancela_orden'));
       echo '</span>';
	}elseif($orden->id_status == 4){
       $atts = array(
              'width'      => '900',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0',
              'menubar'     => 'yes',
              'class'       => 'button blue',
              'id'          => 'imprimir'
            );
       $atts2 = array(
              'width'      => '400',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0',
              'menubar'     => 'yes',
              'class'       => 'button blue',
              'id'          => 'imprimir2'
            );
//	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
//       echo anchor_popup('recepcion/comprobante/'.$id, 'Imprimir Recibo', $atts);
//       echo '</span>';
	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
       echo anchor_popup('recepcion/ticket/'.$id, 'Imprimir Ticket', $atts2);
       echo '</span>';
	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
       echo anchor_popup('recepcion/talon/'.$id, 'Imprimir Talon de Servicio', $atts2);
       echo '</span>';
	   if($this->session->userdata('nivel') == 1){
	   echo '<span style="padding-left: 10px; padding-right: 10px;">';
       echo anchor('', 'Cancelar Orden', array('class' => 'button reed', 'id' => 'cancela_orden'));
       echo '</span>';
	   }
	}
?>
</td>
<input type="hidden" value="0" name="valida" id="valida" />
<input type="hidden" value="<?php echo $orden->id_cliente; ?>" name="cliente_id" id="cliente_id" />
<input type="hidden" value="<?php echo $id; ?>" name="id" id="id" />
</tr>
  <?php
	echo form_close();
  ?>
</table>

<div id="tabla_recepcion">
</div>

<div id="agrega_cliente" class="modal">
  <blockquote>
    
    <p><strong>Agrega Cliente</strong></p>
  </blockquote>
  <?php
	$atributos = array('id' => 'clientes_c_form_agrega');
    echo form_open('catalogo/insert_cliente', $atributos);
    $data_nom = array(
              'name'        => 'nc_nom',
              'id'          => 'nc_nom',
              'value'       => '',
              'maxlength'   => '70',
              'size'        => '50'
            );
            $data_dir = array(
              'name'        => 'nc_dir',
              'id'          => 'nc_dir',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50'
            );
             $data_num = array(
              'name'        => 'nc_num',
              'id'          => 'nc_num',
              'value'       => '',
              'maxlength'   => '50',
              'size'        => '50',
              
            );
             $data_int = array(
              'name'        => 'nc_int',
              'id'          => 'nc_int',
              'value'       => '',
              'maxlength'   => '50',
              'size'        => '50',
              
            );
            $data_col = array(
              'name'        => 'nc_col',
              'id'          => 'nc_col',
              'value'       => '',
              'maxlength'   => '50',
              'size'        => '50'
            );
            $data_pob = array(
              'name'        => 'nc_pob',
              'id'          => 'nc_pob',
              'value'       => '',
              'maxlength'   => '50',
              'size'        => '50'
            );
            $data_cp = array(
              'name'        => 'nc_cp',
              'id'          => 'nc_cp',
              'value'       => '',
              'maxlength'   => '6',
              'size'        => '6'
            );
            $data_tcas = array(
              'name'        => 'nc_tcas',
              'id'          => 'nc_tcas',
              'value'       => '',
              'maxlength'   => '18',
              'size'        => '18'
            );
            $data_ttra = array(
              'name'        => 'nc_ttra',
              'id'          => 'nc_ttra',
              'value'       => '',
              'maxlength'   => '18',
              'size'        => '18'
            );
            $data_tcel = array(
              'name'        => 'nc_tcel',
              'id'          => 'nc_tcel',
              'value'       => '',
              'maxlength'   => '18',
              'size'        => '18'
            );
  ?>
  
  <table>
<tr>

 <tr>
	<td>Nombre del cliente: </td>
	<td><?php echo form_input($data_nom, "", 'required');?><span id="mensaje"></span></td>
	<td>Direccion: </td>
	<td><?php echo form_input($data_dir, "", 'required');?><span id="mensaje"></span></td>
</tr>
 <tr>
	<td>Numero exterior </td>
	<td><?php echo form_input($data_num, "", 'required');?><span id="mensaje"></span></td>
	<td>Numero interior: </td>
	<td><?php echo form_input($data_int);?><span id="mensaje"></span></td>
</tr>
 <tr>
	<td>Colonia </td>
	<td><?php echo form_input($data_col);?><span id="mensaje"></span></td>
	<td>Poblacion: </td>
	<td><?php echo form_input($data_pob);?><span id="mensaje"></span></td>
</tr>
 <tr>
    
	<td colspan="4">C.P:  <?php echo form_input($data_cp);?><span id="mensaje"></span></td>
</tr>
 <tr>
 <td align="center" colspan="4"><strong><?php echo	"TELEFONOS"?></strong></td>
 </tr>
 <tr>
    <td>Casa </td>
	<td><?php echo form_input($data_tcas, "");?><span id="mensaje"></span></td>
	<td>Trabajo:<?php echo form_input($data_ttra);?><span id="mensaje"></span></td>
    <td> Celular<?php echo form_input($data_tcel);?><span id="mensaje"></span></td>
</tr>

	<td colspan="6"><?php echo form_submit('envio', 'AGREGAR CLIENTE');?></td>
</tr>
</table>
  <?php
	echo form_close();
  ?>


</div>

<div id="agrega_servicio" class="modal">
<blockquote>
    
    <p><strong>Agrega un Servicio</strong></p>
</blockquote>

  <?php
	$atributos = array('id' => 'servicios_c_form_agrega');
    echo form_open('', $atributos);
    $data_nom = array(
              'name'        => 'servicio_nuevo',
              'id'          => 'servicio_nuevo',
              'value'       => '',
              'maxlength'   => '70',
              'size'        => '50',
            );
    $data_precio = array(
              'name'        => 'precio_nuevo',
              'id'          => 'precio_nuevo',
              'value'       => '',
              'maxlength'   => '70',
              'size'        => '50',
            );

  ?>
  
  <table>
<tr>
<tr>
	<td>Prenda: </td>
	<td align="left"><?php echo form_dropdown('prenda_nueva', $prenda, '', 'id="prenda_nueva"') ;?> </td>
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

</div>

<div id="pagos_en_orden" align="center">
<?php
	if(isset($pagos_en_orden)){
	   echo $pagos_en_orden;
	}
?>
</div>


</div>

  <script language="javascript" type="text/javascript">
    $(window).load(function () {
        $("#nom").focus();
    });
    
    $(document).ready(function(){
        
        var id = $('#id').attr('value');
        var prenda = $('#prenda').attr('value');
        var cli = $('#cliente').attr('value');
        llena_servicio(prenda);
        detalle_sin_orden();
        $('#cliente_id').val(cli);
        muestra_observacion_cliente(cli)
        
        $('#cerrar_orden').click(function(event){
            
            var cli = $('#cliente').attr('value');
            var noprendas = $('#noprendas').attr('value');
            var valida = $('#valida').attr('value');
			var fecha_entrega = $('#fecha_entrega').attr('value');
			cambia_fecha_entrega(id, fecha_entrega);
            
            if(confirm('Seguro que deseas cerrar esta orden y mandarla a proceso?')){
                
				
						
                if(cli == 0){
                    event.preventDefault();
                    alert('No hay un cliente seleccionado, imposible cerrar la orden.');
                    $('#cliente').focus();
                }else{
                    if(noprendas > 0){
                        
                        if(valida > 0){
						
						
				
                            
                        }else{
                            event.preventDefault();
                            alert('No has agregado ningun servicio.');
                            $('#prenda').focus();
                        }
                        
                    }else{
                        event.preventDefault();
                        alert('Debes poner el numero de prendas.');
                        $('#noprendas').focus();
                    }
                }
                
                
            }else{
                event.preventDefault();
            }
        })
        
    
    $('#nom').blur(function(){
            var nom = $('#nom').attr("value"); 
     });
 
 $('#dir').blur(
        function()
        {
            $('#dir').val($('#dir').attr("value").toUpperCase());
        }
    );   
//////////////////////////////////////////////////////////*****************************************//////////////

    $('#recepcion_c_form_agrega').submit(function(event) {
        
            event.preventDefault();
        
    	  });
          
//////////////////////////////////////////////////////////*****************************************//////////////

    $('input[id^="nc_"]').keyup(function(){
        
        var a = $(this).attr('value');
        $(this).val(a.toUpperCase());
        
    });
    

//////////////////////////////////////////////////////////*****************************************//////////////

    $('#clientes_c_form_agrega').submit(function(event) {
        
            event.preventDefault();
            var id = $('#id').attr('value');
        
                var url = "<?php echo site_url();?>/catalogo/insert_cliente_recepcion";
                var cliente = $('#nc_nom').attr('value');

                var variables = {
                    nom: $('#nc_nom').attr('value'),
                    dir: $('#nc_dir').attr('value'),
                    col: $('#nc_col').attr('value'),
                    pob: $('#nc_pob').attr('value'),
                    cp: $('#nc_cp').attr('value'),
                    correo: '',
                    rfc: '',
                    tcas: $('#nc_tcas').attr('value'),
                    ttra: $('#nc_ttra').attr('value'),
                    tcel: $('#nc_tcel').attr('value'),
                    num: $('#nc_num').attr('value'),
                    inte: $('#nc_int').attr('value')
                };
                
                $.post( url, variables, function(data) {
                    
                    if(data > 0)
                    {
                        $('#nc_nom').val('');
                        $('#nc_dir').val('');
                        $('#nc_col').val('');
                        $('#nc_pob').val('');
                        $('#nc_cp').val('');
                        $('#correo').val('');
                        $('#nc_rfc').val('');
                        $('#nc_tcas').val('');
                        $('#nc_ttra').val('');
                        $('#nc_tcel').val('');
                        $('#nc_num').val('');
                        $('#nc_int').val('');
                        
                        $('#cliente').val(data);
                        $('#cliente_id').val(data);
                        $('#nom').val(cliente);
                        cambia_cliente(id, data);
                        muestra_observacion_cliente(data)
                        $.nmTop().close();
                        
                    }else{
                        alert('No puede agregarse, Revise la informacion.')
                    }
                    
                });

    	  });

        
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $('#servicios_c_form_agrega').submit(function(event) {
        
            event.preventDefault();
            
        
                var url = "<?php echo site_url();?>/catalogo/recepcion_insert_servicios";

                var variables = {
                    nom: $('#servicio_nuevo').attr('value'),
                    pre: $('#prenda_nueva').attr('value'),
                    precio: $('#precio_nuevo').attr('value')
                };
                
                $.post( url, variables, function(data) {
                    
                    if(data > 0)
                    {
                        $('#prenda_nueva').val(0);
                        $('#servicio_nuevo').val('');
                        $('#precio_nuevo').val('');
                        $.nmTop().close();
                        
                    }else{
                        alert('No puede agregarse, Revise la informacion.')
                    }
                    
                });

    	  });

          
//////////////////////////////////////////////////////////*****************************************//////////////

        ///Autocompletar nombre del cliente
        
        var fuente = "<?php echo site_url();?>/recepcion/busca_clientes_autocomplete/";

		$('#nom').autocomplete({
			source: fuente,
            minLength: 2,
            select: function(event, ui){
                $('#fecha_entrega').focus();
                $('#cliente').val(ui.item.id);
                $('#cliente_id').val(ui.item.id);
                cambia_cliente(id, ui.item.id);
                muestra_observacion_cliente(ui.item.id);
            }
		});
        
        // termina Autocompletar nombre del cliente
 //////////////////////////////////////////////////////////*****************************************//////////////       
        //Llenar combo servicios a partir de prendas
        
        $('#prenda').change(function(){
            var prenda = $(this).attr('value');
            llena_servicio(prenda);
        });
        
        
        
        function llena_servicio(prenda){
        var url = "<?php echo site_url();?>/recepcion/servicios_de_prenda";
    
        var variables = {
            prenda: prenda
        };
        
        $.post( url, variables, function(data) {
            $('#servicio').html(data);
        });
        }
        
     //Termina Llenar combo servicios a partir de prendas
//////////////////////////////////////////////////////////*****************************************//////////////


        $('#descuento').change(function(){
            var descuento = $(this).attr('value');
            detalle_sin_orden();
            cambia_descuento(id, descuento);
        });

        //Funcion para agregar un servicio
        
        $('#agregar_servicio').click(function(){
            var servicio = $('#servicio').attr('value');
            var cantidad = $('#can').attr('value');
            var descuento = $('#descuento').attr('value');
            
            if(servicio > 0 && cantidad > 0){
                agrega_servicio(id, servicio, cantidad, descuento);
            }
        });
        
        
        function agrega_servicio(id, servicio, cantidad, descuento){
            var url = "<?php echo site_url();?>/recepcion/agrega_servicio";
        
            var variables = {
                id: id,
                servicio: servicio,
                cantidad: cantidad,
                descuento: descuento
            };
            
            $.post( url, variables, function(data) {
                $('#can').val('');
                $('#prenda').val(0);
                $('#servicio').html('');
                $('#tabla_recepcion').html(data);
                $('#prenda').focus();
            });
        }
        
        //Termina Funcion para agregar un servicio
        
        //Funcion para traer detalle de una orden sin guardar

        function detalle_sin_orden(){
            var url = "<?php echo site_url();?>/recepcion/detalle_sin_orden";
            var descuento = $('#descuento').attr('value');
        
            var variables = {
                id: id,
                descuento: descuento
            };
            
            $.post( url, variables, function(data) {
                $('#tabla_recepcion').html(data);
            });
        }
        
        //Termina Funcion para traer detalle de una orden sin guardar
        
        //Cambia el id del cliente
        function cambia_cliente(id, cliente){
            var url = "<?php echo site_url();?>/recepcion/cambia_cliente";
        
            var variables = {
                id: id,
                cliente: cliente
            };
            
            $.post( url, variables, function(data) {
                
            });
        }
        //Termina Cambiar el id del cliente
        
        function muestra_observacion_cliente(id){
            var url1 = "<?php echo site_url();?>/recepcion/observacion_cliente/" + id;
            var url2 = "<?php echo site_url();?>/recepcion/observacion_cliente2/" + id;
        
            var variables = {

            };
            
            $.post( url1, variables, function(data) {
                
                if(data.length > 0){
                    $.nmManual(url2);
                }
                

            });
        }
        
        
        //Cambia la fecha de entrega
        
        $('#fecha_entrega').blur(function(){
            var fecha_entrega = $(this).attr('value');
            //cambia_fecha_entrega(id, fecha_entrega);
        })

        $('#fecha_entrega').focus(function(){
            var fecha_entrega = $(this).attr('value');
            //cambia_fecha_entrega(id, fecha_entrega);
        })

        
        function cambia_fecha_entrega(id, fecha_entrega){
            var url = "<?php echo site_url();?>/recepcion/cambia_fecha_entrega";
        
            var variables = {
                id: id,
                fecha_entrega: fecha_entrega
            };
            
            $.post( url, variables, function(data) {
                
            });
        }
        //Cambia la fecha de entrega

        //Cambia la hora de entrega
        $('#hora_entrega').change(function(){
            var hora_entrega = $(this).attr('value');
            cambia_hora_entrega(id, hora_entrega);
        })
        
        
        function cambia_hora_entrega(id, hora_entrega){
            var url = "<?php echo site_url();?>/recepcion/cambia_hora_entrega";
        
            var variables = {
                id: id,
                hora_entrega: hora_entrega
            };
            
            $.post( url, variables, function(data) {
                
            });
        }
        //Cambia la hora de entrega

        //Cambia las prendas
        $('#noprendas').change(function(){
            var noprendas = $(this).attr('value');
            cambia_noprendas(id, noprendas);
        })
        
        
        function cambia_noprendas(id, noprendas){
            var url = "<?php echo site_url();?>/recepcion/cambia_noprendas";
        
            var variables = {
                id: id,
                noprendas: noprendas
            };
            
            $.post( url, variables, function(data) {
                
            });
        }
        //Cambia las prendas

        //Cambia descuento
        
        
        function cambia_descuento(id, descuento){
            var url = "<?php echo site_url();?>/recepcion/cambia_descuento";
        
            var variables = {
                id: id,
                descuento: descuento
            };
            
            $.post( url, variables, function(data) {
                
            });
        }
        //Cambia descuento

        //Cambia observacion
        $('#obser').change(function(){
            var obser = $(this).attr('value');
            cambia_obser(id, obser);
        })
        
        
        function cambia_obser(id, obser){
            var url = "<?php echo site_url();?>/recepcion/cambia_observacion";
        
            var variables = {
                id: id,
                obser: obser
            };
            
            $.post( url, variables, function(data) {
                
            });
        }
        //Cambia observacion
        
        
        $('#imprimir').click(function(event){
            //event.preventDefault();
            
            //alert('Imprimir');
            
        });
        
        
        $('#cancela_orden').click(function(event){
            event.preventDefault();
            var id = $('#id').attr('value');
            if(confirm('Seguro que deseas Cancelar esta Orden ' + id + ' ?')){

                var motivo = prompt("Cual es el motivo de la cancelacion ?", "", 'Estas a Punto de Cancelar la Orden ' + id);
                
                if(motivo.length < 9){
                    alert('Debes ser un poco mas especifico con el motivo.')
                }else{
                    cancela_orden(id, motivo);
                }
                
            }
        });

        function cancela_orden(id, motivo){
            var url = "<?php echo site_url();?>/recepcion/cancela_orden";
        
            var variables = {
                id: id,
                motivo: motivo
            };
            
            $.post( url, variables, function(data) {
                
                if(data > 0){
                    window.location = "<?php echo site_url();?>/recepcion/tabla_recepcion/" + id;
                }else{
                    alert('No se pudo hacer la Cancelacion.');
                }
                
            });
        }
        

});
  </script>
