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
		 	//echo "ESTE ES EL ENCABEZADO";
		 	?>
		 	
		</htmlpageheader>
		 
		<htmlpagefooter name="myfooter">
		 	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
		 		Página {PAGENO} de {nb}
		 	</div>
		</htmlpagefooter>

		<!--<htmlpagebody name="mybody">-->

			<?php
			date_default_timezone_set('America/Caracas');
			$fecha=date('d-m-Y');
			?>
			<div style="text-align: right; font-size: 10pt">
				<p><b>Fecha de Impresión: </b> <?php echo $fecha; ?> </p>
				
			</div><br>
			
			<div align="center"><b>Reporte de Tiempo de Ejecución de Procesos</b></div><br>
			<p><b>Rango de Fecha: </b><?php echo $f_ini.' al '.$f_fin; ?></p><br>


			<?php
			
			if(isset($reporte) && $reporte!=null)
			{
				$cont=0;
				$promedio_general=0;
				
				foreach ($reporte as $key => $value) 
				{
					if($cont==0)
					{
					?>
						<p><b>Proceso:</b> <?php echo $value['proceso']; ?></p>
						<p><b>Cantidad de Trámites Procesados:</b> <?php echo $value['cant_tramites']; ?></p>
						<br>

						<table page-break-inside="avoid" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
										
							<thead>
								<tr>
									<td align="center" style="background: #045FB4; color:white;"><b>Actividad</b></td>
									<td align="center" width="10%" style="background: #045FB4; color:white;"><b>Menor Tiempo</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Empleado con Menor Tiempo</b></td>
									<td align="center" width="10%" style="background: #045FB4; color:white;"><b>Mayor Tiempo</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Empleado con Mayor Tiempo</b></td>
									<td align="center" width="10%" style="background: #045FB4; color:white;"><b>Tiempo Promedio</b></td>
									
								</tr>
							</thead>

							<tbody>
					<?php
					}

					if($value['tiempo_promedio']!="" && $value['tiempo_promedio']!=null)
					{
						$promedio_general += $value['tiempo_promedio'];

						$promedio = ($value['tiempo_promedio'] / 60) / $horasDiaLaborable;
						$dTemp = floor($promedio);
						$promedio = $promedio - $dTemp;
						$promedio = $promedio * $horasDiaLaborable;
						$hTemp = floor($promedio);
						$promedio = $promedio - $hTemp;
						$mTemp = $promedio * 60;
						$promedio = $dTemp.' dias - '.$hTemp.' hr - '.$mTemp.' min';
					}
					else if($value['tiempo_promedio']=='0')
					{
						$promedio = '0 dias - 0 hr - 0 min';
					}
					else
					{		
						$promedio = '-';
					}

					if($value['menor_tiempo']!="" && $value['menor_tiempo']!=null)
					{
						$menor_tiempo = explode('-', $value['menor_tiempo']);

						$menor = ($menor_tiempo[0] / 60) / $horasDiaLaborable;
						$dTemp = floor($menor);
						$menor = $menor - $dTemp;
						$menor = $menor * $horasDiaLaborable;
						$hTemp = floor($menor);
						$menor = $menor - $hTemp;
						$mTemp = $menor * 60;
						$menor = $dTemp.' dias - '.$hTemp.' hr - '.$mTemp.' min';

						$empleado_menor_t = $menor_tiempo[1];
					}
					else
					{
						$menor = '-';
						$empleado_menor_t = '-';
					}

					if($value['mayor_tiempo']!="" && $value['mayor_tiempo']!=null)
					{
						$mayor_tiempo = explode('-', $value['mayor_tiempo']);

						$mayor = ($mayor_tiempo[0] / 60) / $horasDiaLaborable;
						$dTemp = floor($mayor);
						$mayor = $mayor - $dTemp;
						$mayor = $mayor * $horasDiaLaborable;
						$hTemp = floor($mayor);
						$mayor = $mayor - $hTemp;
						$mTemp = $mayor * 60;
						$mayor = $dTemp.' dias - '.$hTemp.' hr - '.$mTemp.' min';

						$empleado_mayor_t = $mayor_tiempo[1];
					}
					else
					{
						$mayor = '-';
						$empleado_mayor_t = '-';
					}

					if($cont%2!=0)
						$color="#E6E6E6";
					else
						$color="white";
					?>

					
						<tr>

							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['actividad'] ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $menor; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $empleado_menor_t; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $mayor; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $empleado_mayor_t; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $promedio; ?> </td>

						</tr>

					
					<?php

					$cont++;
				}

				$promedio_general = ($promedio_general / 60) / $horasDiaLaborable;
				$dTemp = floor($promedio_general);
				$promedio_general = $promedio_general - $dTemp;
				$promedio_general = $promedio_general * $horasDiaLaborable;
				$hTemp = floor($promedio_general);
				$promedio_general = $promedio_general - $hTemp;
				$mTemp = $promedio_general * 60;
				$promedio_general = $dTemp.' dias - '.$hTemp.' hr - '.$mTemp.' min';

				?>
					<tr>

						<td align="center" style="background: #A4A4A4;"><b> Total General </b></td>
						<td align="center" style="background: #A4A4A4;"></td>
						<td align="center" style="background: #A4A4A4;"></td>
						<td align="center" style="background: #A4A4A4;"></td>
						<td align="center" style="background: #A4A4A4;"></td>
						<td align="center" style="background: #A4A4A4;"><b> <?php echo $promedio_general; ?> </b></td>

					</tr>
					</tbody>
			

				</table>

			<?php	
			}
			else
			{
				echo"<br><br><i>No se encontraron resultados para el periodo seleccionado.</i>";
			}
			?>

	 </body>
 </html>
