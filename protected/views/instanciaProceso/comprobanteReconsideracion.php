<html>
	<head>
		<style>
		 body {font-family: sans-serif;
		 font-size: 10px;
		 }
		 p { margin: 0pt;
		 }

		 .data {
		  margin: 11px auto;
		  border: 1px solid #cdd3d7;
		  border-radius: 8px;
		  padding-left: 2em;
		}
		.data-title {
		  /*line-height: inherit;*/
		  font-size: 11px;
		  font-weight: bold;
		  /*position: relative;*/
		  color: #2378b0;
		 /* top: 10em;
		  left: -1.5em;*/
		}
		.title {
		  font-size: 14px;
		  font-weight: bold;
		  color: #2378b0;
		}
		/*.data-body{
			position: relative;
			top: -1.5em;
		}*/

		</style>
	</head>
	
	<body>
	
			<?php

			$logo=Yii::app()->request->baseUrl.'/images/logos/CPU.jpg';
			$logoOmpu=Yii::app()->request->baseUrl.'/images/logos/ompu.jpg';
			$fecha = Funciones::invertirFecha($fecha);
			$fecha .= ' '.$hora;
			?>
			<table width="100%">
				<tr>
					<td width="33%"><?php //echo '<img width="100" style="max-height: 150px" src="'.$logo.'"/>'; ?></td>
					<td align="center"><h2 class="title">Comprobante Recurso de Reconsideración</h2></td>
					<td width="33%" align="right"><?php //echo '<img width="100" style="max-height: 150px" src="'.$logoOmpu.'"/>'; ?></td>
				</tr>
			</table>

			
			<div  class="data"> 
				<h2 class="data-title">Datos de la Solicitud</h2>
				<div class="data-body">

					<table width="100%">
						<tr>
							<td width="60%">
								<strong>Expediente N°: </strong> <?php echo $codigoProc; ?>
							</td>
					
							<td width="40%">
								<strong>Fecha: </strong> <?php echo $fecha; ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Tipo de Solicitud: </strong><?php echo $proceso; ?>
							</td>
						
							<td>
								<strong>Dirección que Procesa la Solicitud: </strong> <?php echo $organizacion; ?>
							</td>
						</tr>
					</table>

				</div>
			</div>

			<div  class="data"> 
				<h2 class="data-title">Datos del Propietario</h2>
				<div class="data-body">

					<table width="100%">
						<tr>
							<td width="60%">
								<strong>Nombre: </strong><?php echo $nombre; ?>

							</td>
						
							<td width="40%">
								<strong>Cédula: </strong> <?php echo $cedula; ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Teléfonos: </strong> <?php echo $tlf; ?>
							</td>
						</tr>
					</table>

				</div>
			</div>

			<div  class="data"> 
				<h2 class="data-title">Datos del Inmueble</h2>
				<div class="data-body">

					<table width="100%">
						<tr>
							<td width="60%">
								<strong>Dirección: </strong><?php echo $direccion; ?>

							</td>
					
							<td width="40%">
								<strong>Parroquia: </strong> <?php echo $parroquia; ?>
							</td>
						</tr>
					</table>

				</div>
			</div>

			

			<br><br><br><br><br>

			

			<table width="100%">
				<tr>
					<td width="100%" align="center"><b>Firma y Sello</b></td>
				</tr>
				<tr>
					<td width="100%" align="center"><b><?php echo $empleado; ?></b></td>
				</tr>
				<tr>
					<td width="100%" align="center"><?php echo $cargo; ?></td>
				</tr>
			</table>

			<br><br><br><br>

			<div align="center">_________________________________________________________________________________________________________________________________</div>

			<br><br><br><br>


			<table width="100%">
				<tr>
					<td width="33%"><?php //echo '<img width="100" style="max-height: 150px" src="'.$logo.'"/>'; ?></td>
					<td align="center"><h2 class="title">Comprobante Recurso de Reconsideración</h2></td>
					<td width="33%" align="right"><?php //echo '<img width="100" style="max-height: 150px" src="'.$logoOmpu.'"/>'; ?></td>
				</tr>
			</table>

			<div  class="data"> 
				<h2 class="data-title">Datos de la Solicitud</h2>
				<div class="data-body">

					<table width="100%">
						<tr>
							<td width="60%">
								<strong>Expediente N°: </strong> <?php echo $codigoProc; ?>
							</td>
					
							<td width="40%">
								<strong>Fecha: </strong> <?php echo $fecha; ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Tipo de Solicitud: </strong><?php echo $proceso; ?>
							</td>
						
							<td>
								<strong>Dirección que Procesa la Solicitud: </strong> <?php echo $organizacion; ?>
							</td>
						</tr>
					</table>

				</div>
			</div>

			<div  class="data"> 
				<h2 class="data-title">Datos del Propietario</h2>
				<div class="data-body">

					<table width="100%">
						<tr>
							<td width="60%">
								<strong>Nombre: </strong><?php echo $nombre; ?>

							</td>
						
							<td width="40%">
								<strong>Cédula: </strong> <?php echo $cedula; ?>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Teléfonos: </strong> <?php echo $tlf; ?>
							</td>
						</tr>
					</table>

				</div>
			</div>

			<div  class="data"> 
				<h2 class="data-title">Datos del Inmueble</h2>
				<div class="data-body">

					<table width="100%">
						<tr>
							<td width="60%">
								<strong>Dirección: </strong><?php echo $direccion; ?>

							</td>
					
							<td width="40%">
								<strong>Parroquia: </strong> <?php echo $parroquia; ?>
							</td>
						</tr>
					</table>

				</div>
			</div>

			

			<br><br><br><br><br>

			

			<table width="100%">
				<tr>
					<td width="100%" align="center"><b>Firma y Sello</b></td>
				</tr>
				<tr>
					<td width="100%" align="center"><b><?php echo $empleado; ?></b></td>
				</tr>
				<tr>
					<td width="100%" align="center"><?php echo $cargo; ?></td>
				</tr>
			</table>

	 </body>
 </html>
