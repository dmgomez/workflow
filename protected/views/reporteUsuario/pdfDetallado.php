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

			<div align="center"><b>Reporte de Actividades por Empleado - Evaluación Detallado</b></div><br>
			
			<?php
			
			if(isset($reporte) && $reporte!=null)
			{
				$empleado = -1;
				$proceso = -1;
				$actividad = -1;
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
						//$cont = 0;
						$proceso = $value['id_proceso'];
						$actividad = -1;

						?>
						
						<br><br><p><strong> Proceso <?php echo $value['proceso']; ?> </strong></p>

						<?php
					}

					if($actividad != $value['id_actividad'])
					{
						$cont = 0;
						$actividad = $value['id_actividad'];
						$cant = 0;
						$p_retraso = 0;
						$cant_retraso = 0;

						?>
						<br><p><div style="display: inline-block; float: left;"><strong> Actividad <?php echo $value['actividad']; ?> </strong></div> 
						<div><strong>Tiempo estimado de ejecución: <?php echo $value['dias'] ." día(s) ". $value['horas']. " hora(s)"; ?></strong></div></p><br>

						<table page-break-inside="avoid" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
										
							<thead>
								<tr>
									<td align="center" style="background: #045FB4; color:white;"><b>Código Proceso</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Estatus Actividad</b></td>		
									<td align="center" style="background: #045FB4; color:white;"><b>Fecha Inicio</b></td>	
									<td align="center" style="background: #045FB4; color:white;"><b>Fecha Fin</b></td>	
									<td align="center" style="background: #045FB4; color:white;"><b>Retrasada</b></td>	
									<td align="center" style="background: #045FB4; color:white;"><b>Día Retraso</b></td>	
									<td align="center" style="background: #045FB4; color:white;"><b>Hora Retraso</b></td>	
									<td align="center" style="background: #045FB4; color:white;"><b>Minuto Retraso</b></td>							
								</tr>
							</thead>

							<tbody>

						<?php
					}

					if($cont%2!=0)
						$color="#E6E6E6";
					else
						$color="white";

					$cant ++;
					$retrasada = 'NO';
					$d_retraso = 0;
					$h_retraso = 0;
					$m_retraso = 0;

					if($value['tiempo_retraso'] > 0)
					{ 
						$cant_retraso ++;
						$p_retraso += $value['tiempo_retraso'];
						$retrasada = 'SI';

						//$t_retraso = $value['tiempo_retraso'] / $value['cant_retraso'];
						$t_retraso = ($value['tiempo_retraso'] / 60) / $horasDiaLaborable;
						$d_retraso = floor($t_retraso);

						$t_retraso = $t_retraso - $d_retraso;
						$t_retraso = $t_retraso * $horasDiaLaborable;
						$h_retraso = floor($t_retraso);
	
						$t_retraso = $t_retraso - $h_retraso;
						$t_retraso = $t_retraso * 60;
						$m_retraso = floor($m_retraso);
	
					}

					?>

						<tr>

							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['codigo_instancia_proceso']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['nombre_estado_actividad']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['fecha_ini']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['fecha_fin']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $retrasada; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $d_retraso; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $h_retraso; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $m_retraso; ?> </td>

						</tr>

						
					
					


					<?php

					if(isset($reporte[$key+1]))
					{
						if($actividad != $reporte[$key+1]['id_actividad'])
						{
							if($p_retraso > 0)
							{
								$p_retraso = $p_retraso / $cant_retraso;
								$p_retraso = ($p_retraso / 60) / $horasDiaLaborable;
								$dTemp = floor($p_retraso);

								if($dTemp > 0)
								{
									$p_retraso = $dTemp.' Día(s)';
								}
								else
								{
									//$p_retraso = $p_retraso - $dTemp;
									$p_retraso = $p_retraso * $horasDiaLaborable;
									$hTemp = floor($p_retraso);

									if($hTemp > 0)
									{
										$p_retraso = $hTemp.' Hora(s)';
									}
									else
									{
										//$p_retraso = $p_retraso - $hTemp;
										$mTemp = $p_retraso * 60;
										$p_retraso = $mTemp.' Minutos(s)';

									}
								}
							}
							else
							{
								$p_retraso = $p_retraso." Día";
							}

							$efectividad = ((100 * ($cant - $cant_retraso)) / $cant);

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
							</tbody>
						</table>
						<!--<p><div style="display: inline-block; float: left;"><strong> Actividad <?php //echo $value['actividad']; ?> </strong></div> <div><strong>Tiempo estimado de ejecución: <?php// echo $value['dias'] ." día(s) ". $value['horas']. " hora(s)"; ?></strong></div></p><br>-->
						<table width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
							<tr>
								<td align="center" width="12%" height="1.5em"><b>Cantidad de actividades</b></td>
								<td align="center" width="12%" height="1.5em" style="background: #819FF7"><?=$cant;?></td>
								<td align="center" width="12%" height="1.5em"><b>Promedio de retraso</b></td>
								<td align="center" width="12%" height="1.5em" style="background: #F78181"><?=$p_retraso;?></td>
								<td align="center" width="12%" height="1.5em"><b>% Efectividad de la actividad</b></td>
								<td align="center" width="12%" height="1.5em" style="background: <?php echo $colorE; ?>"><?=$efectividad;?></td>
							</tr>
						</table>
							<?php
						}
					}
					else
					{
						if($p_retraso > 0)
						{
							$p_retraso = $p_retraso / $cant_retraso;
							$p_retraso = ($p_retraso / 60) / $horasDiaLaborable;
							$dTemp = floor($p_retraso);

							if($dTemp > 0)
							{
								$p_retraso = $dTemp.' Día(s)';
							}
							else
							{
								//$p_retraso = $p_retraso - $dTemp;
								$p_retraso = $p_retraso * $horasDiaLaborable;
								$hTemp = floor($p_retraso);

								if($hTemp > 0)
								{
									$p_retraso = $hTemp.' Hora(s)';
								}
								else
								{
									//$p_retraso = $p_retraso - $hTemp;
									$mTemp = $p_retraso * 60;

									$p_retraso = $mTemp.' Minutos(s)';
									

								}
							}
						}
						else
						{
							$p_retraso = $p_retraso." Día";
						}

						$efectividad = ((100 * ($cant - $cant_retraso)) / $cant);

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
							</tbody>
						</table>
						<!--<p><div style="display: inline-block; float: left;"><strong> Actividad <?php //echo $value['actividad']; ?> </strong></div> <div><strong>Tiempo estimado de ejecución: <?php //echo $value['dias'] ." día(s) ". $value['horas']. " hora(s)"; ?></strong></div></p><br>-->
						<table width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
							<tr>
								<td align="center" width="12%" height="1.5em"><b>Cantidad de actividades</b></td>
								<td align="center" width="12%" height="1.5em" style="background: #819FF7"><?=$cant;?></td>
								<td align="center" width="12%" height="1.5em"><b>Promedio de retraso</b></td>
								<td align="center" width="12%" height="1.5em" style="background: #F78181"><?=$p_retraso;?></td>
								<td align="center" width="12%" height="1.5em"><b>% Efectividad de la actividad</b></td>
								<td align="center" width="12%" height="1.5em" style="background: <?php echo $colorE; ?>"><?=$efectividad;?></td>
							</tr>
						</table>
							<?php

					}
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
