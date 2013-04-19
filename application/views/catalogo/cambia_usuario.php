<div>
<?php
    $row = $query->row();
	echo form_open('', array('id' => 'nuevo_usuario_form'));
    //id, username, password, nivel, tipo, nombre, puesto, email, avatar
?>
<input type="hidden" value="<?php echo $row->id; ?>" name="id" id="id" />
								<fieldset>
									<dl>
										<dt>
											<label>Usuario</label>
										</dt>
										<dd>
											<input class="small" type="text" id="username" name="username" maxlength="20" value="<?php echo $row->username; ?>" required />
										</dd>

										<dt>
											<label>Password</label>
										</dt>
										<dd>
											<input class="small" type="password" id="password" name="password" maxlength="20" value="<?php echo $row->password; ?>" required />
										</dd>

										<dt>
										<dt>
											<label>Password para reimpresiones</label>
										</dt>
										<dd>
											<input class="small" type="password" id="password2" name="password2" maxlength="20" value="<?php echo $row->password2; ?>" required />
										</dd>

											<label>Nombre</label>
										</dt>
										<dd>
											<input class="medium" type="text" id="nombre" name="nombre" maxlength="60" value="<?php echo $row->nombre; ?>" required />
										</dd>

										<dt>
											<label>E-mail</label>
										</dt>
										<dd>
											<input class="small" type="text" id="email" name="email" maxlength="45" value="<?php echo $row->email; ?>"  />
										</dd>

										<dt>
											<label>Status</label>
										</dt>
										<dd>
											<?php echo form_dropdown('tipo', array('0' => 'Inactivo', '1' => 'Activo'), $row->tipo, 'id="tipo"') ?>
										</dd>

										<dt>
											.
										</dt>

										<dd>
											<?php echo form_submit('cambiar', 'Modificar Usuario');?>
										</dd>
                                    </dl>
                                </fieldset>

<?php
	echo form_close();
?>
</div>
  <script language="javascript" type="text/javascript">
    
    $(document).ready(function(){
        
        $('#username').focus();
     
        $("#nuevo_usuario_form").submit(function(event){
            event.preventDefault();
            var username = $('#username').attr('value');
            var password = $('#password').attr('value');
            var password2 = $('#password2').attr('value');
            var nombre = $('#nombre').attr('value');
            var email = $('#emal').attr('value');
            var id = $('#id').attr('value');
            var tipo = $('#tipo').attr('value');
            
            alert(tipo);
            
            var url = "<?php echo site_url();?>/catalogo/cambia_usuario_submit";

                var variables = {
                    username: username,
                    password: password,
                    password2: password2,
                    nombre: nombre,
                    email: email,
                    id: id,
                    tipo: tipo
                };
                
                $.post( url, variables, function(data) {
                    
                    if(data > 0){
                        window.location = "<?php echo site_url();?>/catalogo/usuarios";
                    }else{
                        alert('No se pudo actualizar el usuario');
                    }
                });

            
        });
        
    });
    
  </script>
