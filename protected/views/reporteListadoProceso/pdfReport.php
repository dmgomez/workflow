<html>
	<head>
		<style>
		 body {font-family: sans-serif;
		 font-size: 10pt;
		 }
		 p { margin: 0pt;
		 }

		/* .tabla {
		    border-collapse: collapse;
		}
*/
		/*th, td {
		    border: 1px solid black;
		}*/

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

		
		
		
		<div align="center"><b>Listado de Proceso</b></div><br>
		<?php
			if(isset($reporte) && $reporte!=null)
			{
				$proceso=-1;
				$cont=0;

				foreach ($reporte as $key => $value) 
				{
					//if($key!=0 && $proceso != $value['id_proceso'])
					//{
					?>
					<!--	<pagebreak orientation="P" margin-left="15" margin-right="15" margin-top="50" margin-bottom="25" />-->
					<?php
					//}
					
					if($proceso != $value['id_proceso'])
					{
						$cont=0;
						$actividad=-1;
						//$empleado = -1;
						$proceso=$value['id_proceso'];

						?>
						<br>
						<div align="left">
							<p><b>Proceso <?php echo $value['nombre_proceso']; ?></b></p><br>
						</div>
						<?php
//echo $value['id_actividad'];exit();
						if($value['id_actividad'] != -1)
						{
							?>
							<table page-break-inside="avoid" width="100%" border="0" style="border: 1pt solid #000000; ">
										
								<thead>
									<tr>
										<td align="center" style="background: #045FB4; color:white;"><b>Actividad</b></td>
										<?php
										if($value['id_empleado'] != -1)
										{
											?>
											<td align="center" style="background: #045FB4; color:white;"><b>Emleados que pueden ejecutarla</b></td>
											<?php
										}
										?>
										
									</tr>
								</thead>
								<tbody>
							<?php
						}
					}
//echo $value['id_actividad'];exit();
					if($actividad != $value['id_actividad'])
					{
						$cont++;
						if($cont%2!=0)
							$color="#E6E6E6";
						else
							$color="white";
						//$empleado = -1;
						$actividad=$value['id_actividad'];
					
					?>

						<!--<table page-break-inside="avoid" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
										
							<thead>
								<tr>
									<td align="center" style="background: #045FB4; color:white;"><b>Actividad</b></td>
									<?php
									/*if($value['id_empleado'] != -1)
									{
										?>
										<td align="center" style="background: #045FB4; color:white;"><b>Emleados que pueden ejecutarla</b></td>
										<?php
									}*/
									?>
									
								</tr>
							</thead>
							<tbody>-->
						<tr style="background: <?php echo $color ?>"><td><?php echo $value['nombre_actividad']; ?></td>

						<?php
						if($value['id_empleado'] != -1)
						{
							?>
							<td><table >
										
								
							<?php
						}
					
					}

					
					




					if($value['id_empleado'] != -1)
					{
						?>
							<tr><td><?=$value['nombre_empleado']?></td></tr>
						<?php

						if(isset($reporte[$key+1]))
						{
							if($actividad != $reporte[$key+1]['id_actividad'])
							{ 
								?>
									</td>
								</table>
							</tr>
								<?php
							}
							else
							{
								echo "<hr>";
							}
						}
						else
						{
							?>
							</td>
						</table>
					</tr>
						<?php
						}
					}

					if(isset($reporte[$key+1]))
					{
						if($proceso != $reporte[$key+1]['id_proceso'] && $actividad != -1)
						{ 
							?>
							
							</tbody>
						</table>
						<?php

						}
					}
					else if($actividad != -1)
					{ 
						?>
						
						</tbody>
					</table>
					<?php

					}
					//}

					
				}
				//if($key!=0 && $proceso != $value['proceso'])
				//{
				?>

					<!--</pagebreak>-->
				<?php
				//}
			}
			else
			{
				echo"<br><br><i>No se encontraron resultados para el proceso seleccionado.</i>";
			}
		?>


	 </body>
 </html>