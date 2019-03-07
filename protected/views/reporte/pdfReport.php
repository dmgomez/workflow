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
				<b>Fecha de Impresión: </b> <?php echo $fecha; ?> 
			</div><br>
			
			<div align="center"><b>Reporte de Tiempo de Ejecución de Actividades por Empleado</b></div><br>

			<div align="left">
				<p><b>Rango de fecha seleccionado: </b> <?php echo $f_ini.' - '.$f_fin; ?></p>
				<?php
				if($mostrar==1)
					$act="Actividades iniciadas y finalizadas en el rango seleccionado.";
				else
					$act="Actividades iniciadas en el rango seleccionado.";
				?>
				<p> <?php echo $act; ?> </p> 
			</div>

			
			<?php
			
			if(isset($reporte) && $reporte!=null)
			{
				$id_proceso=-1;
				$cont=0;
				
				foreach ($reporte as $key => $value) 
				{
					if($id_proceso != $value['id_proceso'])
					{
						$cont=0;
						$id_actividad=-1;
						$id_proceso=$value['id_proceso'];
						
						?>
						<br><br><p><strong> Trámite <?php echo $value['codigo_proceso'].'. '.$value['nombre_proceso']; ?> </strong></p>

						<p><b>&nbsp;&nbsp;&nbsp;Cantidad de Trámites Iniciados: </b> <?php if(isset($array_iniciados[$id_proceso]) && $array_iniciados[$id_proceso]!=""){ echo $array_iniciados[$id_proceso]; } else{ echo '0';} ?> </p>
						<p><b>&nbsp;&nbsp;&nbsp;Cantidad de Trámites Procesados: </b> <?php if(isset($array_completados[$id_proceso]) && $array_completados[$id_proceso]!="") { echo $array_completados[$id_proceso]; } else{ echo '0';} ?> </p>

						<?php
					}

					if($id_actividad != $value['id_actividad'])
					{
						$id_actividad=$value['id_actividad'];
					
					?>
					
					<br><br><strong> &nbsp;&nbsp;&nbsp; Actividad <?php echo  $value['codigo_actividad'].'.</strong> '.$value['nombre_actividad']; ?> <br><br>

						<table page-break-inside="avoid" class="tablaRep" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
										
							<thead>
								<tr>
									<td align="center" style="background: #045FB4; color:white;"><b>Empleado</b></td>
									<td align="center"  style="background: #045FB4; color:white;"><b>Cant. de veces Ejecutada</b></td>
									<td align="center"  style="background: #045FB4; color:white;"><b>Menor Tiempo</b></td>
									<td align="center"  style="background: #045FB4; color:white;"><b>Mayor Tiempo</b></td>
									<td align="center"  style="background: #045FB4; color:white;"><b>Tiempo Promedio</b></td>
									
								</tr>
							</thead>

							<tbody>

					<?php
					}

					$menor=($value['menor_tiempo'] / 60)/$horasDiaLaborable;
					$dTemp= floor($menor);
					$menor=$menor-$dTemp;
					$menor=$menor*$horasDiaLaborable;
					$hTemp= floor($menor);
					$menor= $menor-$hTemp;
					$mTemp=$menor*60;
					$menor=$dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';

					$mayor=($value['mayor_tiempo'] / 60)/$horasDiaLaborable;
					$dTemp= floor($mayor);
					$mayor=$mayor-$dTemp;
					$mayor=$mayor*$horasDiaLaborable;
					$hTemp= floor($mayor);
					$mayor= $mayor-$hTemp;
					$mTemp=$mayor*60;
					$mayor=$dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';

					$promedio=($value['tiempo_promedio'] / 60) / $horasDiaLaborable;
					$dTemp= floor($promedio);
					$promedio=$promedio-$dTemp;
					$promedio=$promedio*$horasDiaLaborable;
					$hTemp= floor($promedio);
					$promedio= $promedio-$hTemp;
					$mTemp=$promedio*60;
					$promedio=$dTemp.' dias - '.$hTemp.' horas - '.$mTemp.' minutos';

					if($cont%2!=0)
						$color="#E6E6E6";
					else
						$color="white";
					?>

					
						<tr>

							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['nombre_persona'] ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['veces_asignada']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $menor; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $mayor; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $promedio; ?> </td>

						</tr>

					<?php
					if(isset($reporte[$key+1]))
					{
						if($id_actividad != $reporte[$key+1]['id_actividad'])
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
				
			}
			else
			{
				echo"<br><br><i>No se encontraron resultados para el periodo seleccionado.</i>";
			}
			?>

	 </body>
 </html>
