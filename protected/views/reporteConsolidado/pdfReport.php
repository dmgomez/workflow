<html>
	<head>
		<style>
		 body {font-family: sans-serif;
		 font-size: 10pt;
		 }
		 p { margin: 0pt;
		 }

		 @page{
		    size: auto;
		    header: html_myheader;
		    footer: html_myfooter;
		}
		</style>
	</head>
	
	<body>
	
		<htmlpageheader name="myheader">
		 	<?php 
		 	$formatoCabecera=Funciones::generarCabecera($cabecera['ubicacion_logo'], $cabecera['titulo_reporte'], $cabecera['subtitulo_1'], $cabecera['subtitulo_2'], $cabecera['subtitulo_3'], $cabecera['subtitulo_4'], $cabecera['alineacion_titulos']);
		 	echo $formatoCabecera; 
		 	?>
		 	
		</htmlpageheader>
		 
		<htmlpagefooter name="myfooter">
		 	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
		 		Página {PAGENO} de {nb}
		 	</div>
		</htmlpagefooter>

		<div style="text-align: right; font-size: 10pt">
			<?php
			date_default_timezone_set('America/Caracas');
			$fecha=date('d-m-Y');
			?>
			<b>Fecha de Impresión: </b> <?php echo $fecha; ?> 
		</div><br>
		<div align="center"><b>Reporte Consolidado</b></div><br>
		<div align="left"><b>Rango de fecha seleccionado: </b> <?php echo $f_ini.' - '.$f_fin;?> </div>
		<br>
		
		
		<?php
		

		if(isset($procesos) && isset($array_proceso))
		{
		?>
			<table class="tablaRep" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
				<thead>
					<tr>
						<td align="center" style="background: #045FB4; color:white;"><b>Código</b></td>
						<td align="center" width="45%" style="background: #045FB4; color:white;"><b>Proceso</b></td>
						<td align="center" width="10%" style="background: #045FB4; color:white;"><b>Iniciados</b></td>
						<td align="center" width="10%" style="background: #045FB4; color:white;"><b>Procesados</b></td>
						<td align="center" width="10%" style="background: #045FB4; color:white;"><b>Procesados a Tiempo</b></td>
						<td align="center" width="10%" style="background: #045FB4; color:white;"><b>Procesados con Retraso</b></td>
						<td align="center" width="15%" style="background: #045FB4; color:white;"><b>Tiempo Promedio Procesados</b></td>
					</tr>
				</thead>

			<?php
			$color="#E6E6E6";
			for ($i=0; $i<count($procesos) ; $i++) 
			{
				if(isset($array_proceso[$procesos[$i]]['codigo']))
				{
					if($color=="#E6E6E6")
						$color="white";
					else
						$color="#E6E6E6";
				?>
					<tbody>
						<tr>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $array_proceso[$procesos[$i]]['codigo']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $array_proceso[$procesos[$i]]['nombre']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo (isset($array_proceso[$procesos[$i]]['iniciados'])) ? $array_proceso[$procesos[$i]]['iniciados'] : '0';  ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo (isset($array_proceso[$procesos[$i]]['cant'])) ? $array_proceso[$procesos[$i]]['cant'] : '0'; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo (isset($array_proceso[$procesos[$i]]['tiempo'])) ? $array_proceso[$procesos[$i]]['tiempo'] : '0';  ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo (isset($array_proceso[$procesos[$i]]['retrasado'])) ? $array_proceso[$procesos[$i]]['retrasado'] : '0';  ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo (isset($array_proceso[$procesos[$i]]['tpromedio'])) ? $array_proceso[$procesos[$i]]['tpromedio'] : '-';  ?> </td>

						</tr>
					</tbody>	

				<?php


				}
	
			} 
			
			?>
			</table>

		<?php	
		}
		else
		{
			echo"<br><br><i>No se encontraron resultados para el proceso seleccionado.</i>";
		}
		?>

	 </body>
 </html>
