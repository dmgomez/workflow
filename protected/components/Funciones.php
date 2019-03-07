<?php
/**
* 	CLASE DE FUNCIONES GENERALES
*/
class Funciones
{

	public static function usuarioEsDirector()
	{
		$sqlEsDirector = "SELECT count(userid) as es
						FROM cruge_authassignment 
						WHERE itemname = (SELECT valor 
											FROM configuracion 
											WHERE variable = 'cruge_itemname_director')
						AND userid = ".Yii::app()->user->id_usuario;
		$esDirector = Yii::app()->db->createCommand($sqlEsDirector)->queryRow();
		if ($esDirector['es'] == 1)
			return true;
		else
			return false;
	}

	public static function usuarioEsJefeDepartamento()
	{
		$sqlEsJefe = "SELECT count(userid) as es
						FROM cruge_authassignment 
						WHERE itemname = (SELECT valor 
											FROM configuracion 
											WHERE variable = 'cruge_itemname_jefe')
						AND userid = ".Yii::app()->user->id_usuario;
		$esJefe = Yii::app()->db->createCommand($sqlEsJefe)->queryRow();
		if ($esJefe['es'] == 1)
			return true;
		else
			return false;
	}

	public static function usuarioEsOperador()
	{
		$sqlEsOperador = "SELECT count(userid) as es
						FROM cruge_authassignment 
						WHERE itemname = (SELECT valor 
											FROM configuracion 
											WHERE variable = 'cruge_itemname_operador')
						AND userid = ".Yii::app()->user->id_usuario;
		$esOperador = Yii::app()->db->createCommand($sqlEsOperador)->queryRow();
		if ($esOperador['es'] == 1)
			return true;
		else
			return false;
	}

	/*
	* @return Invierte el sentido de la cadena que representa a la fecha. Bien para mostrarla en el
	* formato regional adecuado o para ingresarla a la Base de Datos.
	*/

	public static function generarCabecera($ubicacion_logo, $titulo_reporte, $subtitulo_1, $subtitulo_2, $subtitulo_3, $subtitulo_4, $alinear){


		if (isset($ubicacion_logo))
		{
			$logo=Yii::app()->request->baseUrl.'/images/logos/'.$ubicacion_logo;
			$logo_cfp=Yii::app()->request->baseUrl.'/images/logos/logo_CFP.jpg';

			$cabecera = '<table width="100%">
			 		<tr>
			 			<td width="20%" align="center"><img width="150" style="max-height: 150px" src="'.$logo_cfp.'"/></td>
			 			<td width="60%" align="center">
			 				<table width="100%">';
			 				if (isset($titulo_reporte))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 14pt" align="'.$alinear.'"><b>'.$titulo_reporte.'</b></td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_1))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 12pt" align="'.$alinear.'">'. $subtitulo_1 .'</td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_2))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 10pt" align="'.$alinear.'">'.$subtitulo_2.'</td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_3))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 10pt" align="'.$alinear.'" >'.$subtitulo_3.'</td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_4))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 10pt" align="'.$alinear.'" >'.$subtitulo_4.'</td>
			 					</tr>';
			 				}
			 				$cabecera.='
			 				</table>
			 			</td>
			 			<td width="20%" align="center"><img width="150" style="max-height: 180px" src="'.$logo.'"/></td>
			 		</tr>
			 	</table>';

			return $cabecera;
		}

	}

	public static function generarCabeceraEmail($logo_cfp, $logo, $titulo_reporte, $subtitulo_1, $subtitulo_2, $subtitulo_3, $subtitulo_4, $alinear){


		//if (isset($ubicacion_logo))
		//{
			$cabecera = '<table width="100%">
			 		<tr>
			 			<td width="20%" align="center"><img width="120" style="max-height: 120px" src="'.$logo_cfp.'"/></td>
			 			<td width="60%" align="center">
			 				<table width="100%">';
			 				if (isset($titulo_reporte))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 14pt" align="'.$alinear.'"><b>'.$titulo_reporte.'</b></td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_1))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 12pt" align="'.$alinear.'">'. $subtitulo_1 .'</td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_2))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 10pt" align="'.$alinear.'">'.$subtitulo_2.'</td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_3))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 10pt" align="'.$alinear.'" >'.$subtitulo_3.'</td>
			 					</tr>';
			 				}
			 				if (isset($subtitulo_4))
			 				{
			 					$cabecera.='
			 					<tr>
			 						<td style="font-size: 10pt" align="'.$alinear.'" >'.$subtitulo_4.'</td>
			 					</tr>';
			 				}
			 				$cabecera.='
			 				</table>
			 			</td>
			 			<td width="20%" align="center"><img width="120" style="max-height: 150px" src="'.$logo.'"/></td>
			 		</tr>
			 	</table>';

			return $cabecera;
		//}
		
	}
	
	public static function invertirFecha($fecha){

		return implode( "-", array_reverse( preg_split( '/-/', $fecha ) ) );
	}

	public static function enviarMensaje($url, $telefono, $codigo, $mensaje, $retorno){

		$telefono = explode('/', $telefono);

		foreach ($telefono as $value) 
		{
			$tlf=trim($value);
			$codTlf=substr($tlf, 0, 4);

			$expresionRegular='/(0414|0424|0416|0426|0412)/';

			if( preg_match($expresionRegular, $codTlf))
			{
				$ch=curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1) ;
				curl_setopt($ch, CURLOPT_POSTFIELDS, "telefono=".$tlf."&codigo=".$codigo."&mensaje=".$mensaje."&retorno=".$retorno);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				$result = curl_exec($ch);
				curl_close($ch);
			}			
		}
	}

	public static function minuscula_utf8($cadena){

		return mb_strtolower($cadena, "UTF-8");
	}

}
?>