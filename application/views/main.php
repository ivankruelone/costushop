<!-- Add class .fixed for fixed layout. You would need also edit CSS file for width -->
<body>

	<!-- Fixed Layout Wrapper -->
	<div>

	<!-- Aside Block -->
	<section role="navigation" id="navinavi">

        <?php $this->load->view('head/titulo');?>

        <?php $this->load->view('head/usuario');?>

        <?php $this->load->view('head/menu');?>
        
        <?php 
        
        if(isset($sidebar))
        {
        $this->load->view($sidebar);
        }
        
        ?>
		
	</section>
	<!-- /Aside Block -->
		
	
	<!-- Main Content -->
	<section role="main">
	
        <?php 
        
        if(isset($widgets))
        {
        $this->load->view($widgets);
        }
        
        ?>

        <?php 
        
        if(isset($dondeestoy))
        {
        $this->load->view($dondeestoy);
        }
        
        ?>
		
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2><?php echo $titulo;?></h2>
					<!-- Article Header Tab Navigation -->
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
				
				<?php $this->load->view($contenido);?>
					
				</section>
				<!-- /Article Content -->
                
                <?php $this->load->view('main/footer')?>
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Full Content Block -->
	
	</section>
	<!-- /Main Content -->
	
	</div>
	<!-- /Fixed Layout Wrapper -->

	<!-- JS Libs at the end for faster loading -->
	<script src="<?php echo base_url();?>js/libs/selectivizr.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.nyromodal.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.tipsy.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.wysiwyg.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.datatables.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.datepicker.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.fileinput.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.fullcalendar.min.js"></script>
	<script src="<?php echo base_url();?>js/jquery/excanvas.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.visualize.js"></script>
	<script src="<?php echo base_url();?>js/jquery/jquery.visualize.tooltip.js"></script>
	<script src="<?php echo base_url();?>js/script.js"></script>
	<script src="<?php echo base_url();?>js/hc/highcharts.js"></script>
	<script src="<?php echo base_url();?>js/hc/modules/exporting.js"></script>
    

<link rel="stylesheet" href="<?php echo base_url();?>css/themes/base/jquery.ui.all.css" />
<script src="<?php echo base_url();?>js/ui/jquery.ui.core.min.js"></script>
<script src="<?php echo base_url();?>js/ui/jquery.ui.widget.min.js"></script>
<script src="<?php echo base_url();?>js/ui/jquery.ui.position.min.js"></script>
<script src="<?php echo base_url();?>js/ui/jquery.ui.autocomplete.min.js"></script>
    
	<script language="javascript" type="text/javascript">
        //F2=113, F4=115, F8=119
        $(document).keydown(function(event) 
        {
        	if (event.keyCode == 113)
        	{
        		window.location = "<?php echo site_url();?>/recepcion/nueva_recepcion";
        	}else if (event.keyCode == 115)
        	{
        		window.location = "<?php echo site_url();?>/recepcion/entregas";
        	}else if (event.keyCode == 119)
        	{
        		window.location = "<?php echo site_url();?>/catalogo";
        	}else if (event.keyCode == 120 && 1 == <?php echo $this->session->userdata('nivel');?>)
        	{
        		window.location = "<?php echo site_url();?>/catalogo/importar";
        	}
        });
        
        
        $('#navinavi').addClass('quitar');
	</script>
</body>
</html>