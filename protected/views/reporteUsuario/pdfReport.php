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

			<?php
			date_default_timezone_set('America/Caracas');
			$fecha=date('d-m-Y');
			?>
			<div style="text-align: right; font-size: 10pt">
				<b>Fecha de Impresión: </b> <?php echo $fecha; ?> 
			</div><br>
			
			<div align="center"><b>Reporte de Ejecución de Actividades por Usuario</b></div><br>
			
			<?php
			
			if(isset($reporte) && $reporte!=null)
			{
				$proceso=-1;
				$empleado=0;
				$cont=0;
				$p_estimado=0;
				$p_retraso=0;
				$p_ejecucion=0;
				
				foreach ($reporte as $key => $value) 
				{
					if($key!=0 && $proceso != $value['proceso'])
					{
					?>
						<pagebreak orientation="L" margin-left="15" margin-right="15" margin-top="50" margin-bottom="25" />
					<?php
					}
					//if($empleado==0)
					//{
						?>
						<p><b>Empleado: </b> <?php echo $value['empleado']; ?></p>
						<?php
					//	$empleado=1;
					//}
					if($proceso != $value['proceso'])
					{
						$cont=0;
						$id_actividad=-1;
						$proceso=$value['proceso'];
						
						?>
						<br><br><p><strong> Trámite <?php echo $value['proceso']; ?> </strong></p>

						
						<?php
					}

					if($id_actividad != $value['id_actividad'])
					{
						$id_actividad=$value['id_actividad'];
					
					?>
					
					<br><strong> &nbsp;&nbsp;&nbsp; Actividad <?php echo  $value['actividad']; ?> </strong><br><br>

						<table page-break-inside="avoid" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
										
							<thead>
								<tr>
									<td align="center" style="background: #045FB4; color:white;"><b>Cód. Trámite</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Fecha Inicio</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Fecha Fin</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Tiempo Estimado</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Tiempo Retraso</b></td>
									<td align="center" style="background: #045FB4; color:white;"><b>Tiempo Ejecución</b></td>
								</tr>
							</thead>

							<tbody>

					<?php
					}

					$p_estimado += $value['tiempo_estimado'];
					$t_estimado = ($value['tiempo_estimado'] / 60) / $horasDiaLaborable;
					$dTemp = floor($t_estimado);
					$t_estimado = $t_estimado - $dTemp;
					$t_estimado = $t_estimado * $horasDiaLaborable;
					$hTemp = floor($t_estimado);
					$t_estimado = $t_estimado - $hTemp;
					$mTemp = $t_estimado * 60;
					//$t_estimado = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';
					$t_estimado = $dTemp.' dias - '.$hTemp.' horas';


					$tiempo_ejecucion = $value['tiempo_ejecucion'];
					if($tiempo_ejecucion < 0)
						$tiempo_ejecucion = 0;


					$t_retraso = $value['tiempo_estimado'] - $tiempo_ejecucion;
					//$p_retraso += $t_retraso;
					if($t_retraso<0)
					{
						$t_retraso=abs($t_retraso);

						$t_retraso = ($t_retraso / 60) / $horasDiaLaborable;
						$dTemp = floor($t_retraso);
						$t_retraso = $t_retraso - $dTemp;
						$t_retraso = $t_retraso * $horasDiaLaborable;
						$hTemp = floor($t_retraso);
						$t_retraso = $t_retraso - $hTemp;
						$mTemp = $t_retraso * 60;
						$t_retraso = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';
					}
					else
					{
						$t_retraso = '0 dias - 0 horas - 0 minutos';
					}

					
					$p_ejecucion += $tiempo_ejecucion;
					$t_ejecucion = ($tiempo_ejecucion / 60) / $horasDiaLaborable;
					$dTemp = floor($t_ejecucion);
					$t_ejecucion = $t_ejecucion - $dTemp;
					$t_ejecucion = $t_ejecucion * $horasDiaLaborable;
					$hTemp = floor($t_ejecucion);
					$t_ejecucion = $t_ejecucion - $hTemp;
					$mTemp = $t_ejecucion * 60;
					$t_ejecucion = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';


					if($cont%2!=0)
						$color="#E6E6E6";
					else
						$color="white";
					?>

					
						<tr>

							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['codigo_instancia_proceso'] ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['fecha_inicio']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['fecha_fin']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $t_estimado; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $t_retraso; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $t_ejecucion; ?> </td>

						</tr>

					<?php
					if(isset($reporte[$key+1]))
					{
						if($id_actividad != $reporte[$key+1]['id_actividad'])
						{
							$p_retraso = $p_estimado - $p_ejecucion;

							$p_estimado = ($p_estimado / 60) / $horasDiaLaborable;
							$dTemp = floor($p_estimado);
							$p_estimado = $p_estimado - $dTemp;
							$p_estimado = $p_estimado * $horasDiaLaborable;
							$hTemp = floor($p_estimado);
							$p_estimado = $p_estimado - $hTemp;
							$mTemp = $p_estimado * 60;
							//$p_estimado = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';
							$p_estimado = $dTemp.' dias - '.$hTemp.' horas';

							
							if($p_retraso<0)
							{
								$p_retraso=abs($p_retraso);
								//$p_retraso = $p_retraso / $cont;

								$p_retraso = ($p_retraso / 60) / $horasDiaLaborable;
								$dTemp = floor($p_retraso);
								$p_retraso = $p_retraso - $dTemp;
								$p_retraso = $p_retraso * $horasDiaLaborable;
								$hTemp = floor($p_retraso);
								$p_retraso = $p_retraso - $hTemp;
								$mTemp = $p_retraso * 60;
								$p_retraso = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';
							}
							else
							{
								$p_retraso = '0 dias - 0 horas - 0 minutos';
							}

							//$p_ejecucion = $p_ejecucion / $cont;
							$p_ejecucion = ($p_ejecucion / 60) / $horasDiaLaborable;
							$dTemp = floor($p_ejecucion);
							$p_ejecucion = $p_ejecucion - $dTemp;
							$p_ejecucion = $p_ejecucion * $horasDiaLaborable;
							$hTemp = floor($p_ejecucion);
							$p_ejecucion = $p_ejecucion - $hTemp;
							$mTemp = $p_ejecucion * 60;
							$p_ejecucion = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';

							?>
								<tr>

									<td align="center" style="background: #A4A4A4;"><b> Total General </b></td>
									<td align="center" style="background: #A4A4A4;"></td>
									<td align="center" style="background: #A4A4A4;"></td>
									<td align="center" style="background: #A4A4A4;"><b> <?php echo $p_estimado; ?> </b></td>
									<td align="center" style="background: #A4A4A4;"><b> <?php echo $p_retraso; ?> </b></td>
									<td align="center" style="background: #A4A4A4;"><b> <?php echo $p_ejecucion; ?> </b></td>

								</tr>
						</tbody>
				

					</table>
					
					<?php
							$p_estimado=0;
							$p_retraso=0;
							$p_ejecucion=0;

						}
					}
					else
					{
						$p_retraso = $p_estimado - $p_ejecucion;

						$p_estimado = ($p_estimado / 60) / $horasDiaLaborable;
						$dTemp = floor($p_estimado);
						$p_estimado = $p_estimado - $dTemp;
						$p_estimado = $p_estimado * $horasDiaLaborable;
						$hTemp = floor($p_estimado);
						$p_estimado = $p_estimado - $hTemp;
						$mTemp = $p_estimado * 60;
						//$p_estimado = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';
						$p_estimado = $dTemp.' dias - '.$hTemp.' horas';

						
						if($p_retraso<0)
						{
							$p_retraso=abs($p_retraso);
							//$p_retraso = $p_retraso / $cont;

							$p_retraso = ($p_retraso / 60) / $horasDiaLaborable;
							$dTemp = floor($p_retraso);
							$p_retraso = $p_retraso - $dTemp;
							$p_retraso = $p_retraso * $horasDiaLaborable;
							$hTemp = floor($p_retraso);
							$p_retraso = $p_retraso - $hTemp;
							$mTemp = $p_retraso * 60;
							$p_retraso = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';
						}
						else
						{
							$p_retraso = '0 dias - 0 horas - 0 minutos';
						}

						//$p_ejecucion = $p_ejecucion / $cont;
						$p_ejecucion = ($p_ejecucion / 60) / $horasDiaLaborable;
						$dTemp = floor($p_ejecucion);
						$p_ejecucion = $p_ejecucion - $dTemp;
						$p_ejecucion = $p_ejecucion * $horasDiaLaborable;
						$hTemp = floor($p_ejecucion);
						$p_ejecucion = $p_ejecucion - $hTemp;
						$mTemp = $p_ejecucion * 60;
						$p_ejecucion = $dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';

						?>
							<tr>

								<td align="center" style="background: #A4A4A4;"><b> Total General </b></td>
								<td align="center" style="background: #A4A4A4;"></td>
								<td align="center" style="background: #A4A4A4;"></td>
								<td align="center" style="background: #A4A4A4;"><b> <?php echo $p_estimado; ?> </b></td>
								<td align="center" style="background: #A4A4A4;"><b> <?php echo $p_retraso; ?> </b></td>
								<td align="center" style="background: #A4A4A4;"><b> <?php echo $p_ejecucion; ?> </b></td>

							</tr>
						</tbody>
				

					</table>
					
					<?php

					}
					?>

					
					<?php

					$cont++;
				}
				if($key!=0 && $proceso != $value['proceso'])
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
