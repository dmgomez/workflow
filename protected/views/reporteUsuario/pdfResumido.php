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
			<?php
			date_default_timezone_set('America/Caracas');
			$fecha=date('d-m-Y');
			?>

			<div style="text-align: right; font-size: 10pt">
				<b>Fecha de Generación: </b> <?php echo $fecha; ?> 
			</div>
		 	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
		 		Página {PAGENO} de {nb}
		 	</div>
		</htmlpagefooter>

			<div align="center"><b>Reporte de Actividades por Empleado - Evaluación Resumido</b></div><br>
			
			<?php
			
			if(isset($reporte) && $reporte!=null)
			{
				$empleado = -1;
				$proceso = -1;
				//$cont = 0;
				
				foreach ($reporte as $key => $value) 
				{
					//if($key!=0 && $proceso != $value['proceso'])
					//{
					?>
						<!--<pagebreak orientation="L" margin-left="15" margin-right="15" margin-top="50" margin-bottom="25" />-->
					<?php
					//}

					if($empleado != $value['id_empleado'])
					{
						if($key != 0)
						{
							?>
							<pagebreak orientation="L" margin-left="15" margin-right="15" margin-top="50" margin-bottom="25" />
							<?php
						}
						?>
						<p><b>Empleado:  <?php echo $value['nombre_empleado']; ?></b></p>
						<?php
						$empleado = $value['id_empleado'];
						$proceso = -1;
					}
					if($proceso != $value['id_proceso'])
					{
						$cont = 0;
						$proceso = $value['id_proceso'];
						
						?>
						<br><br><p><strong> Proceso <?php echo $value['proceso']; ?> </strong></p><br>

						<table page-break-inside="avoid" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
										
							<thead>
								<tr>
									<td align="center" style="background: #045FB4; color:white;"><b>Código Actividad</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Descripción Actividad</b></td>		
									<td align="center" style="background: #045FB4; color:white;"><b>Cantidad Actividad</b></td>	
									<td align="center" style="background: #045FB4; color:white;"><b>Promedio Retraso</b></td>	
									<td align="center" style="background: #045FB4; color:white;"><b>% Efectividad</b></td>							
								</tr>
							</thead>

							<tbody>


						
						<?php
					}

					?>
					
					<?php
					
					if($cont%2!=0)
						$color="#E6E6E6";
					else
						$color="white";

					$p_retraso = '-';

					if($value['cant_retraso'] > 0)
					{
						$t_retraso = $value['tiempo_retraso'] / $value['cant_retraso'];
						$t_retraso = ($t_retraso / 60) / $horasDiaLaborable;
						$dTemp = floor($t_retraso);

						if($dTemp > 0)
						{
							$p_retraso = $dTemp.' Dia(s)';
						}
						else
						{
							//$p_retraso = $p_retraso - $dTemp;
							$t_retraso = $t_retraso * $horasDiaLaborable;
							$hTemp = floor($t_retraso);

							if($hTemp > 0)
							{
								$p_retraso = $hTemp.' Hora(s)';
							}
							else
							{
								//$p_retraso = $p_retraso - $hTemp;
								$mTemp = $t_retraso * 60;

								if($mTemp > 0)
								{
									$p_retraso = $mTemp.' Minutos(s)';
								}

							}
						}
					}
					
					$efectividad = ((100 * ($value['cant_actividad'] - $value['cant_retraso'])) / $value['cant_actividad']);

						if($efectividad < 70)
						{
							$colorE = '#F78181';
						}
						else
						{
							$colorE = '#81F781';
						}

						$efectividad .= ' %';

					?>

						<tr>

							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['codigo_actividad'] ?> </td>
							<td align="left" style="background: <?php echo $color ?>"> <?php echo $value['nombre_actividad']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['cant_actividad'] ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $p_retraso ?> </td>
							<td align="center" style="background: <?php echo $colorE ?>"> <?php echo $efectividad ?> </td>

						</tr>

					<?php
					if(isset($reporte[$key+1]))
					{
						if($proceso != $reporte[$key+1]['id_proceso'])
						{
							
							?>

						</tbody>
				
					</table>
					
					<?php

						}
					}
					else
					{
						
						?>
							
						</tbody>
				

					</table>
					
					<?php

					}
					?>

					
					<?php

					$cont++;
				}
				if($key!=0 && $empleado != $value['id_empleado'])
				{
				?>

					</pagebreak>
				<?php
				}
				
			}
			else
			{
				echo"<br><br><i>No se encontraron resultados para el periodo seleccionado.</i>";
			}
			?>

	 </body>
 </html>
