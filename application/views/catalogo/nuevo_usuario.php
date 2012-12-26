<div>
<?php
	echo form_open('', array('id' => 'nuevo_usuario_form'));
    //id, username, password, nivel, tipo, nombre, puesto, email, avatar
?>
								<fieldset>
									<dl>
										<dt>
											<label>Usuario</label>
										</dt>
										<dd>
											<input class="small" type="text" id="username" name="username" maxlength="20" required />
										</dd>

										<dt>
											<label>Password</label>
										</dt>
										<dd>
											<input class="small" type="password" id="password" name="password" maxlength="20" required />
										</dd>

										<dt>
											<label>Nombre</label>
										</dt>
										<dd>
											<input class="medium" type="text" id="nombre" name="nombre" maxlength="60" required />
										</dd>

										<dt>
											<label>E-mail</label>
										</dt>
										<dd>
											<input class="small" type="text" id="email" name="email" maxlength="45"  />
										</dd>

										<dt>
											.
										</dt>

										<dd>
											<?php echo form_submit('agregar', 'Agregar Usuario');?>
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
            var nombre = $('#nombre').attr('value');
            var email = $('#emal').attr('value');
            
            var url = "<?php echo site_url();?>/catalogo/nuevo_usuario_submit";

                var variables = {
                    username: username,
                    password: password,
                    nombre: nombre,
                    email: email
                };
                
                $.post( url, variables, function(data) {
                    
                    if(data > 0){
                        window.location = "<?php echo site_url();?>/catalogo/usuarios";
                    }else{
                        alert('No se pudo agregar el usuario');
                    }
                });

            
        });
        
    });
    
  </script>
