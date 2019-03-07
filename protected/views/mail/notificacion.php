<html>
    <head>
    	<?php
			$formatoCabecera=Funciones::generarCabeceraEmail($logo_cfp, $logo, $cabecera['titulo_reporte'], $cabecera['subtitulo_1'], $cabecera['subtitulo_2'], $cabecera['subtitulo_3'], $cabecera['subtitulo_4'], $cabecera['alineacion_titulos']);
		 	echo $formatoCabecera; 
    	?>
    </head>
    <body><br><br>
    	<?php

		 	
    	if($tipo=='empleado')
    	{
    	?>
	        Estimado(a) <?php echo $nombre; ?>
	        <br><br>
	        Se le informa que la actividad "<?php echo $model->nombre_actividad;?>", del proceso "<?php echo $model->codigo_instancia_proceso; ?>" 
	        le ha sido asignada.
	    <?php
		}
		else if($tipo=='superior' || $tipo == 'director')
		{
	    ?>
	    	Estimado(a) <?php echo $nombre; ?>
	        <br><br>
	        Se le informa que la actividad "<?php echo $model->nombre_actividad; ?>", del proceso "<?php echo $model->codigo_instancia_proceso; ?>" 
	        asignada al empleado <?php echo $model->nombre_empleado; ?> se encuentra en estado <?php echo $estado; ?>.
	    <?php
		}
		else 
		{
	    ?>
	    	Estimado(a) 
	        <br><br>
	        Se le informa que la actividad "<?php echo $model->nombre_actividad; ?>", del proceso "<?php echo $model->codigo_instancia_proceso; ?>" 
	        asignada al empleado <?php echo $model->nombre_empleado; ?> se encuentra en estado <?php echo $estado; ?>.
	    <?php
		}
	    ?>
    </body>
</html>