<script type="text/javascript">
/*$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{

		erroresIngreso="";

		arrFechaIni=$("#ReporteUsuario_fechaIni").val().split("-");
		arrFechaFin=$("#ReporteUsuario_fechaFin").val().split("-");
		
		$("#ReporteUsuario_fechaIni_error").text("");
		$("#ReporteUsuario_fechaIni").removeClass("error");

		$("#ReporteUsuario_fechaFin_error").text("");
		$("#ReporteUsuario_fechaFin").removeClass("error");

		$("#ReporteUsuario__departamento_error").text("");
		$("#ReporteUsuario__departamento").removeClass("error");

		$("#ReporteUsuario__cargo_error").text("");
		$("#ReporteUsuario__cargo").removeClass("error");

		$("#ReporteUsuario__empleado_error").text("");
		$("#ReporteUsuario__empleado").removeClass("error");

				

		if($("#ReporteUsuario__departamento").val()=="")
		{
			erroresIngreso+="<li>Departamento no puede ser nulo.</li>";

			$("#ReporteUsuario__departamento_error").text("Departamento no puede ser nulo.");
			$("#ReporteUsuario__departamento_error").css("color", "#b94a48");
			$("#ReporteUsuario__departamento").addClass("error");
		}

		if($("#ReporteUsuario__cargo").val()=="")
		{
			erroresIngreso+="<li>Cargo no puede ser nulo.</li>";

			$("#ReporteUsuario__cargo_error").text("Cargo no puede ser nulo.");
			$("#ReporteUsuario__cargo_error").css("color", "#b94a48");
			$("#ReporteUsuario__cargo").addClass("error");
		}

		if($("#ReporteUsuario__empleado").val()=="")
		{
			erroresIngreso+="<li>Empleado no puede ser nulo.</li>";

			$("#ReporteUsuario__empleado_error").text("Empleado no puede ser nulo.");
			$("#ReporteUsuario__empleado_error").css("color", "#b94a48");
			$("#ReporteUsuario__empleado").addClass("error");
		}

		if($('#ReporteUsuario_fechaIni').val()=="")
		{
			erroresIngreso+="<li>Desde no puede ser nulo.</li>";
			$("#ReporteUsuario_fechaIni_error").text("Desde no puede ser nulo.");
			$("#ReporteUsuario_fechaIni_error").css("color", "#b94a48");
			$("#ReporteUsuario_fechaIni").addClass("error");
		}

		if($('#ReporteUsuario_fechaFin').val()=="")
		{
			erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
			$("#ReporteUsuario_fechaFin_error").text("Hasta no puede ser nulo.");
			$("#ReporteUsuario_fechaFin_error").css("color", "#b94a48");
			$("#ReporteUsuario_fechaFin").addClass("error");
		}

		for(i=arrFechaIni.length-1; i>=0; i--)
		{
			if(arrFechaFin[i]>arrFechaIni[i])
			{
				break;
			}
			else if(arrFechaFin[i]<arrFechaIni[i])
			{
				erroresIngreso+="<li>Hasta debe ser una fecha posterior a Desde.</li>";
				$("#ReporteUsuario_fechaFin_error").text("Hasta debe ser una fecha posterior a Desde.");
				$("#ReporteUsuario_fechaFin_error").css("color", "#b94a48");
				$("#ReporteUsuario_fechaFin").addClass("error");

				break;
			}

		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			$('#btnBuscar').attr('href','buscarActividades?empleado='+$("#ReporteUsuario__empleado").val()+'&f_ini='+$("#ReporteUsuario_fechaIni").val()+'&f_fin='+$("#ReporteUsuario_fechaFin").val());
			return true;
		}
		else
		{
			$('#resumenError').html('<p>Por favor corrija los siguientes errores de ingreso.</p><ul>'+erroresIngreso+'</ul>');
			
			$("#resumenError").css("display", "");
			return false;
		}
		
	});
});*/

$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{
		erroresIngreso="";

		arrFechaIni=$("#ReporteUsuario_fechaIni").val().split("-");
		arrFechaFin=$("#ReporteUsuario_fechaFin").val().split("-");
		
		$("#ReporteUsuario_fechaIni_error").text("");
		$("#ReporteUsuario_fechaIni").removeClass("error");

		$("#ReporteUsuario_fechaFin_error").text("");
		$("#ReporteUsuario_fechaFin").removeClass("error");


		$("#check_empleados_error").text("");
	//	$("#ReporteUsuario__empleado").removeClass("error");


		//erroresIngreso="";
		//$("#check_empleados_error").text("");
		//$("#ReporteListadoProceso__proceso").removeClass("error");

		/*if($("#ReporteUsuario__empleadosSeleccionados").val()=="")
		{
			erroresIngreso+="<li>Proceso no puede ser nulo.</li>";

			$("#check_empleados_error").text("Empleado no puede ser nulo.");
			$("#check_empleados_error").css("color", "#b94a48");
	
		}*/


		if($("#ReporteUsuario__tipoReporte").val() != 1)
		{

			if($('#ReporteUsuario_fechaIni').val()=="")
			{
				erroresIngreso+="<li>Desde no puede ser nulo.</li>";
				$("#ReporteUsuario_fechaIni_error").text("Desde no puede ser nulo.");
				$("#ReporteUsuario_fechaIni_error").css("color", "#b94a48");
				$("#ReporteUsuario_fechaIni").addClass("error");
			}

			if($('#ReporteUsuario_fechaFin').val()=="")
			{
				erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
				$("#ReporteUsuario_fechaFin_error").text("Hasta no puede ser nulo.");
				$("#ReporteUsuario_fechaFin_error").css("color", "#b94a48");
				$("#ReporteUsuario_fechaFin").addClass("error");
			}

			for(i=arrFechaIni.length-1; i>=0; i--)
			{
				if(arrFechaFin[i]>arrFechaIni[i])
				{
					break;
				}
				else if(arrFechaFin[i]<arrFechaIni[i])
				{
					erroresIngreso+="<li>Hasta debe ser una fecha posterior a Desde.</li>";
					$("#ReporteUsuario_fechaFin_error").text("Hasta debe ser una fecha posterior a Desde.");
					$("#ReporteUsuario_fechaFin_error").css("color", "#b94a48");
					$("#ReporteUsuario_fechaFin").addClass("error");

					break;
				}

			}
		}


		if($("#ReporteUsuario__empleadosSeleccionados").val()=="")
		{
			erroresIngreso+="<li>Empleado no puede ser nulo.</li>";

			$("#check_empleados_error").text("Empleado no puede ser nulo.");
			$("#check_empleados_error").css("color", "#b94a48");
			$("#ReporteUsuario__empleadosSeleccionados").addClass("error");
		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			$('#btnBuscar').attr('href','generarReporte?tipo='+$("#ReporteUsuario__tipoReporte").val()+'&empleado='+$("#ReporteUsuario__empleadosSeleccionados").val()+'&f_ini='+$("#ReporteUsuario_fechaIni").val()+'&f_fin='+$("#ReporteUsuario_fechaFin").val());
			return true;
		}
		else
		{
			$('#resumenError').html('<p>Por favor corrija los siguientes errores de ingreso.</p><ul>'+erroresIngreso+'</ul>');
			
			$("#resumenError").css("display", "");
			return false;
		}
		
	});
});

function cambiarTipoReporte(value)
{
	if(value != 1)
	{
		$("#fechas").css("display", "");
	}
	else
	{
		$("#fechas").css("display", "none");
	}
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

function seleccionarTodos()
{
	searchTable($("#search").val(''));
	$("#ReporteUsuario__empleadosSeleccionados").val('');
	var cadena='';

	if($('#_chequearEmpleados').is(":checked"))
	{
		$("input[type=checkbox]").each(function()
		{  
			cadena=cadena+$(this).val()+',';
			$(" input").prop("checked", "checked");
		})
	}
	else
	{ 
		$("input[type=checkbox]").each(function()
		{ 
			$("input").prop('checked', false);
		})
	}

	if(cadena!="")
	{
		cadena = cadena.substring(0, cadena.length-1);
	}
	
	$("#ReporteUsuario__empleadosSeleccionados").val(cadena);

}

</script>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reporte-form',
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<div id="resumenError" class="errorForm" style="display: none"></div>

	<?php echo $form->hiddenField($model,'_empleadosSeleccionados'); ?>

	<div>
		<?php 
		if(Yii::app()->user->isSuperAdmin)
		{
			echo $form->dropDownListRow($model, '_organizacion', CHtml::listData(Organizacion::model()->findAll(array('order' => 'nombre_organizacion')), 'id_organizacion', 'nombre_organizacion'), 
			array('class' => 'span4', 'options' => array($idOrganizacion=>array('selected'=>true)),
				'ajax' => array(
					'type' => 'post',
					'dataType'=>'json',
					'data'=>array('idOrganizacion'=> 'js:$("#ReporteUsuario__organizacion").val()'),
					'url' => $this->createUrl('reporteUsuario/CargarTabla'),
					'success' => 'js:function(data) {
						if(data.success)
						{
							$("#tblData").html(data.tabla);
							
							$("#ReporteUsuario__empleadosSeleccionados").val("");
							
						}
						

					}'
				)
			) );
		} 
		?> 
	</div>
	<div id="ReporteUsuario__organizacion_error"> </div>

	<?php echo $form->dropDownListRow($model, '_tipoReporte', $tipoReporte, 
		array('class' => 'span4', 'options' => array(1=>array('selected'=>true)),
			'onChange' => 'cambiarTipoReporte(this.value);'
		) ); ?>


	<div id="fechas" style="display: none;">
		<?php //echo $form->labelEx($model, '_fechaIni', array("class"=>"required")); ?>
		<label>Desde <span class="required">*</span></label>
				
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
				array(
					'name'=>'ReporteUsuario_fechaIni',
					'language'=>'es',
					'htmlOptions' => array( 'readonly'=>'readonly'),
					'options' => array(
						'showAnim'=>'slideDown',
						'showButtonPanel' => 'true',
						'changeMonth'=>true,
						'changeYear'=>true,
						'autoSize'=>true,
						'dateFormat'=>'dd-mm-yy',
						'constrainInput' => 'true',
						'minDate'=> "-10Y",
						'maxDate'=> 'date("Y-m-d")'
					)
				)
			); ?>
			<div id="ReporteUsuario_fechaIni_error"></div>
	
			<?php //echo $form->labelEx($model, '_fechaFin'); ?>
			<label>Hasta <span class="required">*</span></label>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
				array(
					'name'=>'ReporteUsuario_fechaFin',
					'language'=>'es',
					'htmlOptions' => array('readonly'=>'readonly'),
					'options' => array(
						'showAnim'=>'slideDown',
						'showButtonPanel' => 'true',
						'changeMonth'=>true,
						'changeYear'=>true,
						'autoSize'=>true,
						'dateFormat'=>'dd-mm-yy',
						'constrainInput' => 'true',
						'minDate'=> "-10Y",
						'maxDate'=> 'date("Y-m-d")'
					)
				)
			); ?>
			<div id="ReporteUsuario_fechaFin_error"></div>
	</div>
	<br><br>

	<label>Empleados <span class="required">*</span></label>

	<?php echo CHtml::checkBox('_chequearEmpleados',false, array('onClick'=>'seleccionarTodos()')); ?> <div><i>Seleccionar Todo</i></div>
	<div>&nbsp;</div>

	<input type="text" id="search" name="search" title="Ingrese texto a buscar" style="width:250px" onKeyUp="searchTable(this.value);">

	<table id="tblData">
		<?php
		foreach ($empleados as $key => $value) 
		{
			?>
			<tr>
				<td>
					<?php echo CHtml::checkBox('_empleados', '',
						array(//'separator'=>'',
							//'style'=>'float:left; margin-right: 5px;',
							'onClick'=>'seleccionarEmpleado($(this))',
							'value'=>$value['id'],
						));
					?> 
				</td>
				<td>
					<?php echo $value['nombre']; ?>
				</td>
			</tr>
			
			<?php
		}
		?>
	</table>
	<!--<div id="ReporteUsuario__proceso_error"></div>-->
	<div id="check_empleados_error"></div>
	
	<div>&nbsp;</div>

	
	<!--<table width="100%">
		<tr>
			<td width="50%">

	<?php /*echo $form->dropDownListRow($model, '_organizacion', CHtml::listData(Organizacion::model()->findAll(array('order' => 'nombre_organizacion')), 'id_organizacion', 'nombre_organizacion'), 
		array('class' => 'span4', 'options' => array($idOrganizacion=>array('selected'=>true)),
			'ajax' => array(
				'type' => 'post',
				'dataType'=>'json',
				'data'=>array('organizacion'=> 'js:$("#ReporteUsuario__organizacion").val()', 'departamentoId'=>'ReporteUsuario__departamento', 'departamentoName'=>'ReporteUsuario[_departamento]', 'class' => 'span4'),
				'url' => $this->createUrl('reporteUsuario/getDepartamentos'),
				'success' => 'js:function(data) {
					if(data.success)
					{
						$("#ReporteUsuario__departamento").replaceWith(data.departamento);
					}
				}'
			)
		) 
	);*/ ?> 
	<div id="ReporteUsuario__organizacion_error"> </div>

			</td>
			<td>

	<?php /*echo $form->dropDownListRow($model,'_departamento', CHtml::listData($departamentos, 'id_departamento', 'nombre_departamento'),
			array('class' => 'span4', 'prompt' => '--Seleccione--',
				'ajax' => array(
						'type' => 'post',
						'dataType'=>'json',
						//'data'=>array('departamento'=> 'js:$("#ReporteUsuario__departamento").val()', 'cargo'=> 'js:$("#ReporteUsuario__cargo").val()', 'empleadoId'=>'ReporteUsuario__empleado', 'empleadoName'=>'ReporteUsuario[_empleado]', 'class' => 'span4'),
						'data'=>array('departamento'=> 'js:$("#ReporteUsuario__departamento").val()', 'empleadoId'=>'ReporteUsuario__empleado', 'empleadoName'=>'ReporteUsuario[_empleado]', 'class' => 'span4'),
						'url' => $this->createUrl('reporteUsuario/getEmpleados'),
						'success' => 'js:function(data) {
							if(data.success)
							{
								$("#ReporteUsuario__empleado").replaceWith(data.empleado);
							}
						}'
				)
		));*/ ?>
	<div id="ReporteUsuario__departamento_error"></div>

			</td>
		</tr>
		<tr>
			<!--<td>-->
	<?php /*echo $form->dropDownListRow($model,'_cargo', CHtml::listData($cargos, 'id_cargo', 'nombre_cargo'), 
			array('class' => 'span4', 'prompt' => '--Seleccione--',
				'ajax' => array(
						'type' => 'post',
						'dataType'=>'json',
						'data'=>array('departamento'=> 'js:$("#ReporteUsuario__departamento").val()', 'cargo'=> 'js:$("#ReporteUsuario__cargo").val()', 'empleadoId'=>'ReporteUsuario__empleado', 'empleadoName'=>'ReporteUsuario[_empleado]', 'class' => 'span4'),
						'url' => $this->createUrl('reporteUsuario/getEmpleados'),
						'success' => 'js:function(data) {
							if(data.success)
							{
								$("#ReporteUsuario__empleado").replaceWith(data.empleado);
							}
						}'
				)
		));*/ ?>
		<!--<div id="ReporteUsuario__cargo_error"></div>
			</td>-->
<!--			<td>

	

	<div class="control-group">
		<?php //echo $form->labelEx($model, '_empleado'); ?>
		<div class="controls">
			<?php //echo $form->dropDownList($model, '_empleado', CHtml::listData(Empleado::model()->findAllByAttributes(array('id_departamento' => '-1', 'id_cargo' => '-1')), 'id_empleado', 'id_empleado'),
				/*echo $form->dropDownList($model, '_empleado', CHtml::listData(Empleado::model()->findAllByAttributes(array('id_departamento' => '-1')), 'id_empleado', 'id_empleado'),
					array('prompt'=>'Seleccione', 'class' => 'span4'));*/ ?>
		</div>
		<div id="ReporteUsuario__empleado_error"></div>
	</div>
	

			</td>
		</tr>
		<tr>
    		<td width="50%">
				<?php //echo $form->labelEx($model, '_fechaIni'); ?>
				
				<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'ReporteUsuario_fechaIni',
						'language'=>'es',
						'htmlOptions' => array( 'readonly'=>'readonly'),
						'options' => array(
							'showAnim'=>'slideDown',
							'showButtonPanel' => 'true',
							'changeMonth'=>true,
							'changeYear'=>true,
							'autoSize'=>true,
							'dateFormat'=>'dd-mm-yy',
							'constrainInput' => 'true',
							'minDate'=> "-10Y",
							'maxDate'=> 'date("Y-m-d")'
						)
					)
				);*/ ?>
				<div id="ReporteUsuario_fechaIni_error"></div>
			</td>

    		<td width="50%">
				<?php //echo $form->labelEx($model, '_fechaFin'); ?>
				<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'ReporteUsuario_fechaFin',
						'language'=>'es',
						'htmlOptions' => array('readonly'=>'readonly'),
						'options' => array(
							'showAnim'=>'slideDown',
							'showButtonPanel' => 'true',
							'changeMonth'=>true,
							'changeYear'=>true,
							'autoSize'=>true,
							'dateFormat'=>'dd-mm-yy',
							'constrainInput' => 'true',
							'minDate'=> "-10Y",
							'maxDate'=> 'date("Y-m-d")'
						)
					)
				);*/ ?>
				<div id="ReporteUsuario_fechaFin_error"></div>
			</td>
		</tr>
	</table>-->

	<div class="form-actions">
	<?php	
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'link',
		'url'=>$this->createUrl('reporte/generarReporte'),
		'size'=>'medium',
		'label'=>'Generar Reporte',
		'htmlOptions'=>array('target'=>'_BLANK', 'id'=>'btnBuscar'),
		
	));	
	?>
	</div>


<?php $this->endWidget(); ?>



