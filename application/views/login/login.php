<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<title><?php echo TITULO_WEB;?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo base_url();?>apple-touch-icon.png">
	
	<!-- CSS Styles -->
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/colors.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.tipsy.css">
	
	<!-- Google WebFonts -->
	<!--<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>-->
	
	<script src="<?php echo base_url();?>js/libs/modernizr-1.7.min.js"></script>
</head>
<body class="login">
	<section role="main">
	
		<a href="/costurita"></a>
	
		<!-- Login box -->
		<article id="login-box">
		
			<div class="article-container">
			
				<p>Teclea por favor tu usuario y contase&ntilde;a, recuerda que siempre deben ser minusculas y despues da clic en el boton ingresar. </p>
                
                <?php if(isset($error)){?>
				
				<!-- Notification -->
				<div class="notification error">
					<a href="#" class="close-notification" title="Ocultar Notificaci&oacute;n" rel="tooltip">x</a>
					<p><strong>Error</strong> Usuario y/o Contase&ntilde;a no validos. Vuelve a Intentar o cumunicate a Sistemas.</p>
				</div>
				<!-- /Notification -->
                <?php }?>
                
                <?php echo form_open('login/validate_credentials');?>
			
					<fieldset>
						<dl>
							<dt>
								<label>Usuario</label>
							</dt>
							<dd>
                                <?php
                                
                                $data_login = array(
                                              'name'        => 'username',
                                              'id'          => 'username',
                                              'maxlength'   => '20',
                                              'type'        => 'text',
                                              'class'       => 'large',
                                              'autofocus'   => 'autofocus',
                                              'required'    => 'required'
                                            );
                                
                                echo form_input($data_login);

                                ?>
							</dd>
							<dt>
								<label>Password</label>
							</dt>
							<dd>
                                <?php
                                
                                $data_password = array(
                                              'name'        => 'password',
                                              'id'          => 'password',
                                              'maxlength'   => '20',
                                              'type'        => 'password',
                                              'class'       => 'large',
                                              'required'    => 'required'
                                            );
                                
                                echo form_input($data_password);

                                ?>
							</dd>
						</dl>
					</fieldset>
					<button type="submit" class="right">Ingresar</button>
				</form>
			
			</div>
		
		</article>
		<!-- /Login box -->
<!--
		<ul class="login-links">
			<li><a href="#">Lost password?</a></li>
			<li><a href="#">Wiki</a></li>
			<li><a href="#">Back to page</a></li>
		</ul>
-->		
	</section>

	<!-- JS Libs at the end for faster loading -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
	<script src="js/libs/selectivizr.js"></script>
	<script src="js/jquery/jquery.tipsy.js"></script>
	<script src="js/login.js"></script>
	<script>
		var _gaq=[['_setAccount','UA-XXXXXX'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>