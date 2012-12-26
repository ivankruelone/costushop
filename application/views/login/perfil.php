<?php 
$row = $query->row();
echo form_open('login/submit_perfil');
?>
        <fieldset>
            <legend>Perfil Basico</legend>
            <dl>
                <dt>
                    <label>Nombre:</label>
                </dt>
                <dd>
                    <?php
                    $data_nombre = array(
                                    'name'      => 'nombre',
                                    'id'        => 'nombre',
                                    'type'      => 'text',
                                    'autofocus' => 'autofocus',
                                    'class'     => 'medium',
                                    'required'  => 'required'
                                    );
                    echo form_input($data_nombre, $row->nombre);
                    ?>
                </dd>
                <dt>
                    <label>Puesto:</label>
                </dt>
                <dd>
                    <?php
                    $data_puesto = array(
                                    'name'      => 'puesto',
                                    'id'        => 'puesto',
                                    'type'      => 'text',
                                    'class'     => 'medium',
                                    'required'  => 'required'
                                    );
                    echo form_input($data_puesto, $row->puesto);
                    ?>
                </dd>
                <dt>
                    <label>E-mail:</label>
                </dt>
                <dd>
                    <?php
                    $data_mail = array(
                                    'name'      => 'email',
                                    'id'        => 'email',
                                    'type'      => 'text',
                                    'class'     => 'small'
                                    );
                    echo form_input($data_mail, $row->email);
                    ?>
                </dd>
                <dt>
                    <label>Usuario:</label>
                </dt>
                <dd>
                    <?php
                    $data_usuario = array(
                                    'name'      => 'username',
                                    'id'        => 'username',
                                    'type'      => 'text',
                                    'class'     => 'small',
                                    'required'  => 'required'
                                    );
                    echo form_input($data_usuario, $row->username);
                    ?>
                </dd>
            </dl>
        </fieldset>
        <input type="hidden" value="<?php echo $row->id;?>" name="id" id="id" />
        <button type="submit">Modificar</button> o <?php echo anchor('welcome', 'Cancelar')?>
<?php echo form_close();?>
        <fieldset>
        <legend>Avatar</legend>
        <dl>
            <dt style="margin-bottom: 10px;">
                <label>Elige otro avatar:</label>
            </dt>
            <dd style="margin-bottom: 10px;">
                <button class="green medium" id="upload_button">Da click aqui para seleccionar un avatar desde arhivo.</button>
            </dd>
            <div id="avatar" style="margin-bottom: 10px;">
                <img src="<?php echo base_url();?>img/avatar/<?php echo $this->session->userdata('avatar');?>" alt="<?php echo $this->session->userdata('nombre');?>">
            </div>
        </dl>
        </fieldset>
<script language="javascript" type="text/javascript"> 
	var button = $('#upload_button'), interval;
	new AjaxUpload('#upload_button', {
        action: '<?php echo site_url();?>/login/upload_avatar',
		onSubmit : function(file , ext){
		if (! (ext && /^(png|jpg|gif)$/.test(ext))){
			alert('Error: Solo se permiten .jpg, .png, .gif');
			return false;
		} else {
			button.text('Subiendo el  archivo. Espere un momento por favor...');
			this.disable();
		  }
		},
		onComplete: function(file, response){
			button.text('Da click aqui para seleccionar un avatar desde arhivo.');
			this.enable();			
			$('#avatar').html(response);
		}	

	});
</script> 