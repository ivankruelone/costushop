<!DOCTYPE HTML>
<html>
<title>Password:</title>
<body>
<p style="text-align: justify;">Para poder hacer una reimpresi&oacute;n es necesario introducir la contrase&ntilde;a.</p>
<p style="text-align: center;"><?php echo $error;?></p>
<?php
	echo form_open('recepcion/tintoreria_password_submit');
    
    echo form_label('Contrase&ntilde;a: ');
    $data = array(
              'name'        => 'clave',
              'id'          => 'clave',
              'maxlength'   => '20',
              'type'       => 'password',
              'autofocus'   => 'autofocus'
            );

    echo form_input($data);
    echo form_hidden('id', $id);
    echo form_submit('mysubmit', 'Aceptar!');
    echo form_close();
?>
</body>
</html>