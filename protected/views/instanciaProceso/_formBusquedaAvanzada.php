<script type="text/javascript">

	function datosSeleccionados()
	{
		$("#InstanciaProceso__datoAdicional").val('');
		var cadena='';

		$("input:checked").each(function()
		{ 
			cadena=cadena+$(this).val()+',';
		})

		cadena = cadena.substring(0, cadena.length-1);
		$("#InstanciaProceso__datoAdicional").val(cadena);	

		activarCampos();
	}

	function activarCampos()
	{
		var datosProc = $("#InstanciaProceso__datosProceso").val();
		var datosAct = $("#InstanciaProceso__datoAdicional").val();

		datosProc = datosProc.split(",");
		datosAct = datosAct.split(",");


		$.each( datosProc, function( key, value ) {

		  	if( jQuery.inArray(value, datosAct) != -1 )
		  	{
		  		$("#"+value).attr('readonly', false);
		  	}
		  	else
		  	{
		  		$("#"+value).attr('readonly', true);
		  		$("#"+value).val('');

		  		valorDatos();
		  	}
		});

	}

	function valorDatos()
	{
		var datosAct = $("#InstanciaProceso__datoAdicional").val();
		var cadena = "";

		datosAct = datosAct.split(",");

		$.each( datosAct, function( key, value ) {

		  	cadena += $("#"+value).val() +",";
		});

		cadena = cadena.substring(0, cadena.length-1);
		$("#InstanciaProceso__valorDatoAdicional").val(cadena);	
	}


	function searchTable(inputVal)
	{
		var table = $('#tblData');
		table.find('tr').each(function(index, row)
		{
			var allCells = $(row).find('td');
			if(allCells.length > 0)
			{
				var found = false;
				allCells.each(function(index, td)
				{
					var regExp = new RegExp(inputVal, 'i');
					if(regExp.test($(td).text()))

					{
						found = true;
						return false;
					}
				});
				if(found == true)$(row).show();else $(row).hide();
			}
		});
	}

</script>



<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
//	'id'=>'busqueda-avanzada-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div id="resumenError" class="errorForm" style="display: none"></div>

	<?php echo CHtml::label('Tipo de Trámite', ''); ?>
	<?php echo CHtml::activeDropDownList($model,'id_proceso',  CHtml::listData(Proceso::model()->findAll(array('order' => 'nombre_proceso')), 'id_proceso', 'nombre_proceso'),
		array('class'=>'span8', 'id'=>'InstanciaProceso_id_proceso',
			'ajax' => array(
				'type' => 'post',
				'dataType'=>'json',
				'data'=>array('idProceso'=> 'js:$("#InstanciaProceso_id_proceso").val()'),
				'url' => $this->createUrl('instanciaProceso/getDatosAdicionales'),
				'success' => 'js:function(data) {
					
					$("#checkbox-list-dato").html(data.datos);
					$("#InstanciaProceso__datosProceso").val(data.datosProceso);
					$("#InstanciaProceso__datoAdicional").val("");
				}'
			)
		)
	); ?>

	
	<?php echo CHtml::activeHiddenField($model, '_datosProceso', array('value'=>$datosProceso, 'id'=>'InstanciaProceso__datosProceso')); ?>
	<?php echo CHtml::activeHiddenField($model, '_datoAdicional', array('id'=>'InstanciaProceso__datoAdicional')); ?>
	<?php echo CHtml::activeHiddenField($model, '_valorDatoAdicional', array('id'=>'InstanciaProceso__valorDatoAdicional')); ?>



	<div class="data span5" style="margin-right: 1%; float: left;" >
		<h2 class="data-title">Datos del Trámite</h2>
		<div class="data-body" style="height: 245px;">
			<?php echo CHtml::label('Número de Solicitud', ''); ?> 
			<?php echo CHtml::activeTextField($model, 'codigo_instancia_proceso', array('class'=>'span5', 'id'=>'InstanciaProceso_codigo_instancia_proceso')); ?>

			<?php echo CHtml::label('Estado del Trámite', ''); ?> 
			<?php echo CHtml::activeTextField($model, 'nombreEstado', array('class'=>'span5', 'id'=>'InstanciaProceso_nombreEstado')); ?>

		</div>
	</div>

	<div class="data span6" style="display: inline-block;">
		<h2 class="data-title">Datos Adicionales</h2>
		<div class="data-body">

			<table><tr><td width="33%"><i>Filtrar campos: </i></td> <td width="60%"><?php echo CHtml::textField('search', '', array("id"=>"search", "name"=>"search", "title"=>"Ingrese texto a buscar", "class"=>"span4", "onKeyUp"=>"searchTable(this.value);")); ?></td></tr></table> <!--<input type="text" id="search" name="search" title="Ingrese texto a buscar" class="span4" onKeyUp="searchTable(this.value);">-->
			<div id="checkbox-list-dato"  style="overflow:auto; height:205px; ">
				<table id="tblData", style="margin-right: 6px;">
					<?php
					if($datos && $datos[0]!="")
					{
						foreach ($datos as $key => $value) 
						{
							?>
							<tr>
								<td width="5%">
									<?php echo CHtml::checkBox('_checkDatoAdicional', false,
										array('separator'=>'',
											'style'=>'float:left; margin-right: 5px;',
											'onClick'=>'datosSeleccionados()',
											'value'=>$value['id'],						
										));
									?> 
								</td>
								<td width="30%">
									<?php echo $value['nombre']; ?>
								</td>
								<td width="60%">
									<?php echo CHtml::textField('_datoBuscar', '', array('id'=>$value['id'], 'class'=>'span4', 'style'=>'margin-left: 5px;', 'readonly'=>'readonly', 'onblur'=>'valorDatos()')); ?>
								</td>
							</tr>
							<?php
						}
					}
					?>
				</table>
			</div>

		</div>
	</div>


	
	<div class="form-actions" style="display: flex; min-width: 100%;">
	<?php	
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit', 
		'size'=>'medium',
		'label'=>'Buscar',
		'htmlOptions'=>array('id'=>'btnBuscar'),
		
	));	
	?>

	</div>
	
	
<?php $this->endWidget(); ?>


</div><!-- form -->