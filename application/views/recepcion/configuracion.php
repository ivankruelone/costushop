<?php
    $this->db->where('id', 1);
	$query = $this->db->get('parametros');
    $row = $query->row();
?>
<form id="configuracion">
<input type="hidden" value="<?php echo $row->id; ?>" name="id" id="id" />
								<!-- Inputs dias, id, sucursal, razon, rfc, regimen, direccion-->
								<!-- Use class .small, .medium or .large for predefined size -->
								<fieldset>
									<dl>
										<dt>
											<label>Dias de entrega</label>
										</dt>
										<dd>
											<input class="small" type="text" id="dias" name="dias" maxlength="1" value="<?php echo $row->dias; ?>" required />
											<p>Configura cuantos dias por Default para la entrega de una orden.</p>
										</dd>

										<dt>
											<label>Sucursal</label>
										</dt>
										<dd>
											<input class="medium" type="text" id="sucursal" name="sucursal" maxlength="255" value="<?php echo $row->sucursal; ?>" required />
											<p>Nombre de la Sucursal para mostrar.</p>
										</dd>

										<dt>
											<label>Nombre o Razon Social</label>
										</dt>
										<dd>
											<input class="small" type="text" id="razon" name="razon" maxlength="255" value="<?php echo $row->razon; ?>" required />
											<p>Nombre o Razon Social para mostrar</p>
										</dd>

										<dt>
											<label>RFC</label>
										</dt>
										<dd>
											<input class="small" type="text" id="rfc" name="rfc" maxlength="13" value="<?php echo $row->rfc; ?>" required />
											<p>Registro Federal de Contribuyente</p>
										</dd>

										<dt>
											<label>Regimen</label>
										</dt>
										<dd>
											<input class="large" type="text" id="regimen" name="regimen" maxlength="255" value="<?php echo $row->regimen; ?>" required />
											<p>Regimen Fiscal al que pertenece</p>
										</dd>

										<dt>
											<label>Direccion</label>
										</dt>
										<dd>
											<input class="large" type="text" id="direccion" name="direccion" maxlength="255" value="<?php echo $row->direccion; ?>" required />
											<p>Direccion para mostrar</p>
										</dd>

										<dt>
											<label>CLAUSULADO DE SERVICIO</label>
										</dt>
										<dd>
											<textarea class="large" id="clausulado" name="clausulado" rows="20" ><?php echo $row->clausulado; ?></textarea>
											<p>Direccion para mostrar</p>
										</dd>

                                    </dl>
                                </fieldset>
</form>

  <script language="javascript" type="text/javascript">
    
    $(document).ready(function(){
     
        $(":input").change(function(){
            var valor = $(this).attr('value');
            var variable = $(this).attr('name');
            var id = $('#id').attr('value');
            
            var url = "<?php echo site_url();?>/recepcion/cambia_configuracion";

                var variables = {
                    valor: valor,
                    variable: variable,
                    id: id
                };
                
                $.post( url, variables, function(data) {
                    
                    
                });

            
        });
        

        $("#clausulado").change(function(){
            var valor = $(this).attr('value');
            var variable = $(this).attr('name');
            var id = $('#id').attr('value');
            
            var url = "<?php echo site_url();?>/recepcion/cambia_configuracion";

                var variables = {
                    valor: valor,
                    variable: variable,
                    id: id
                };
                
                $.post( url, variables, function(data) {
                    
                    
                });

            
        });

    });
    
  </script>
