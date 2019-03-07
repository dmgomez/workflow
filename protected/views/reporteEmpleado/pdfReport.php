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
			
			<div align="center"><b>Reporte de Empleados</b></div><br>

			
			<?php
			
			if(isset($reporte) && $reporte!=null)
			{
			?>
				<table page-break-inside="avoid" width="100%" border="0" style="border: 1pt solid #000000; border-radius: 0.3em;">
										
					<thead>
						<tr>
							<td align="center" style="background: #045FB4; color:white;"><b>Cédula</b></td>
							<td align="center"  style="background: #045FB4; color:white;"><b>Nombre</b></td>
							<td align="center"  style="background: #045FB4; color:white;"><b>Cargo</b></td>
							<td align="center"  style="background: #045FB4; color:white;"><b>Departamento</b></td>
							<td align="center"  style="background: #045FB4; color:white;"><b>Rol de Ejecución de Actividades</b></td>
							<td align="center"  style="background: #045FB4; color:white;"><b>Rol del Sistema</b></td>
							<td align="center"  style="background: #045FB4; color:white;"><b>Estado</b></td>
							
							
						</tr>
					</thead>

					<tbody>
			<?php
				
				$cont=0;

				foreach ($reporte as $key => $value) 
				{
					if($cont%2!=0)
						$color="#E6E6E6";
					else
						$color="white";

					if($value['estado']==1)
						$estado = "Activo";
					else if($value['estado']==0)
						$estado = "Inactivo";
					?>

						<tr>

							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['cedula_persona'] ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['nombre_persona']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['nombre_cargo']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['nombre_departamento']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['rol_empleado']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $value['itemname']; ?> </td>
							<td align="center" style="background: <?php echo $color ?>"> <?php echo $estado; ?> </td>

						</tr>

				<?php

					$cont++;
				}
						
				?>
					</tbody>
				
				</table>		
					
			<?php
	
			}
			else
			{
				echo"<br><br><i>No se encontraron resultados para los datos especificados.</i>";
			}
			?>

	 </body>
 </html>
