<script type="text/javascript">
$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{
		erroresIngreso="";
		
		$("#ReporteEmpleado__departamento_error").text("");
		
		$("#ReporteEmpleado__cargo_error").text("");
		
		$("#ReporteEmpleado__rol_error").text("");
		
		$("#ReporteEmpleado__ordenar_error").text("");

		$("#ReporteEmpleado__mostrar_error").text("");

		
		if($("#ReporteEmpleado__departamento").val()=="")
		{
			erroresIngreso+="<li>Debe seleccionar al menos un departamento.</li>";

			$("#ReporteEmpleado__departamento_error").text("Debe seleccionar al menos un departamento.");
			$("#ReporteEmpleado__departamento_error").css("color", "#b94a48");
	
		}

		if($('#ReporteEmpleado__cargo').val()=="")
		{
			erroresIngreso+="<li>Debe seleccionar al menos un cargo.</li>";
			$("#ReporteEmpleado__cargo_error").text("Debe seleccionar al menos un cargo.");
			$("#ReporteEmpleado__cargo_error").css("color", "#b94a48");
		}

		if($('#ReporteEmpleado__rol').val()=="")
		{
			//erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
			erroresIngreso+="<li>Roles de Ejecución de Actividades no puede ser nulo.</li>";
			$("#ReporteEmpleado__rol_error").text("Roles de Ejecución de Actividades no puede ser nulo.");
			$("#ReporteEmpleado__rol_error").css("color", "#b94a48");
		}

		if($('#ReporteEmpleado__rol_sistema').val()=="")
		{
			erroresIngreso+="<li>Roles del Sistema no puede ser nulo.</li>";
			$("#ReporteEmpleado__rol_sistema_error").text("Roles del Sistema no puede ser nulo.");
			$("#ReporteEmpleado__rol_sistema_error").css("color", "#b94a48");
		}

		if($('#ReporteEmpleado__ordenar').val()=="")
		{
			//erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
			erroresIngreso+="<li>Ordenar no puede ser nulo.</li>";
			$("#ReporteEmpleado__ordenar_error").text("Ordenar no puede ser nulo.");
			$("#ReporteEmpleado__ordenar_error").css("color", "#b94a48");
		}

		if($('#ReporteEmpleado__mostrar').val()=="")
		{
			//erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
			erroresIngreso+="<li>Mostrar no puede ser nulo.</li>";
			$("#ReporteEmpleado__mostrar_error").text("Mostrar no puede ser nulo.");
			$("#ReporteEmpleado__mostrar_error").css("color", "#b94a48");
		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			$('#btnBuscar').attr('href','buscarActividades?departamento='+$("#ReporteEmpleado__departamento").val()+'&cargo='+$("#ReporteEmpleado__cargo").val()+'&rol='+$("#ReporteEmpleado__rol").val()+'&rolSistema='+$("#ReporteEmpleado__rol_sistema").val()+'&ordenar='+$("#ReporteEmpleado__ordenar").val()+'&mostrar='+$("#ReporteEmpleado__mostrar").val());
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

function seleccionadosDep()
{
	$("#ReporteEmpleado__departamento").val('');
	var cadena='';

	$("#ReporteEmpleado__check_departamento input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);
	$("#ReporteEmpleado__departamento").val(cadena);	
}

function seleccionadosCargo()
{
	$("#ReporteEmpleado__cargo").val('');
	var cadena='';

	$("#ReporteEmpleado__check_cargo input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);
	$("#ReporteEmpleado__cargo").val(cadena);
}

function seleccionadosRol()
{
	$("#ReporteEmpleado__rol").val('');	
	var cadena='';

	$("#ReporteEmpleado__check_rol input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);
	$("#ReporteEmpleado__rol").val(cadena);
}

function seleccionadosRolSistema()
{
	$("#ReporteEmpleado__rol_sistema").val('');	
	var cadena='';

	$("#ReporteEmpleado__check_rol_sistema input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);
	$("#ReporteEmpleado__rol_sistema").val(cadena);
}

function seleccionOrden()
{
	$("#ReporteEmpleado__ordenar").val($("#ReporteEmpleado__radio_ordenar input:checked").val());
}

function seleccionMostrar()
{
	$("#ReporteEmpleado__mostrar").val($("#ReporteEmpleado__radio_mostrar input:checked").val());
}

function seleccionarTodasDep()
{
	$("#ReporteEmpleado__departamento").val('');
	var cadena='';

	if($('#_chequearDep').is(":checked"))
	{
		$("#ReporteEmpleado__check_departamento input").each(function()
		{ 
			cadena=cadena+$(this).val()+',';
			$("#ReporteEmpleado__check_departamento input").prop("checked", "checked");
		})
	}
	else
	{
		$("#ReporteEmpleado__check_departamento input").each(function()
		{ 
			$("#ReporteEmpleado__check_departamento input").prop('checked', false);
		})
	}

	if(cadena!="")
	{
		cadena = cadena.substring(0, cadena.length-1);
	}

	$("#ReporteEmpleado__departamento").val(cadena);
}


function seleccionarTodasCargo()
{
	$("#ReporteEmpleado__cargo").val('');
	var cadena='';

	if($('#_chequearCargo').is(":checked"))
	{
		$("#ReporteEmpleado__check_cargo input").each(function()
		{ 
			cadena=cadena+$(this).val()+',';
			$("#ReporteEmpleado__check_cargo input").prop("checked", "checked");
		})
	}
	else
	{
		$("#ReporteEmpleado__check_cargo input").each(function()
		{ 
			$("#ReporteEmpleado__check_cargo input").prop('checked', false);
		})
	}

	if(cadena!="")
	{
		cadena = cadena.substring(0, cadena.length-1);
	}

	$("#ReporteEmpleado__cargo").val(cadena);
}

function seleccionarTodasRol()
{
	$("#ReporteEmpleado__rol").val('');
	var cadena='';

	if($('#_chequearRol').is(":checked"))
	{
		$("#ReporteEmpleado__check_rol input").each(function()
		{ 
			cadena=cadena+$(this).val()+',';
			$("#ReporteEmpleado__check_rol input").prop("checked", "checked");
		})
	}
	else
	{
		$("#ReporteEmpleado__check_rol input").each(function()
		{ 
			$("#ReporteEmpleado__check_rol input").prop('checked', false);
		})
	}

	if(cadena!="")
	{
		cadena = cadena.substring(0, cadena.length-1);
	}

	$("#ReporteEmpleado__rol").val(cadena);
}

function seleccionarTodasRolSistema()
{
	$("#ReporteEmpleado__rol_sistema").val('');
	var cadena='';

	if($('#_chequearRolSistema').is(":checked"))
	{
		$("#ReporteEmpleado__check_rol_sistema input").each(function()
		{ 
			cadena=cadena+$(this).val()+',';
			$("#ReporteEmpleado__check_rol_sistema input").prop("checked", "checked");
		})
	}
	else
	{
		$("#ReporteEmpleado__check_rol_sistema input").each(function()
		{ 
			$("#ReporteEmpleado__check_rol_sistema input").prop('checked', false);
		})
	}

	if(cadena!="")
	{
		cadena = cadena.substring(0, cadena.length-1);
	}

	$("#ReporteEmpleado__rol_sistema").val(cadena);
}

</script>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reporte-form',
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<div id="resumenError" class="errorForm" style="display: none"></div>

	<div>
		<?php echo $form->dropDownListRow($model, '_organizacion', CHtml::listData(Organizacion::model()->findAll(array('order' => 'nombre_organizacion')), 'id_organizacion', 'nombre_organizacion'), 
		array('class' => 'span4', 'options' => array($idOrganizacion=>array('selected'=>true)),
			'ajax' => array(
				'type' => 'post',
				'dataType'=>'json',
				'data'=>array('idOrganizacion'=> 'js:$("#ReporteEmpleado__organizacion").val()'),
				'url' => $this->createUrl('reporteEmpleado/CargarCampos'),
				'success' => 'js:function(data) {
					if(data.success)
					{
						$("#departamento_organizacion").html(data.departamento);
						$("#cargo_organizacion").html(data.cargo);
					}
					

				}'
			)
		) ); ?> 
	</div>
	<div id="ReporteEmpleado__organizacion_error"> </div>



	<?php echo $form->hiddenField($model,'_departamento'); ?>

	<?php echo $form->hiddenField($model,'_cargo'); ?>

	<?php echo $form->hiddenField($model,'_rol'); ?>

	<?php echo $form->hiddenField($model,'_rol_sistema'); ?>

	<?php echo $form->hiddenField($model,'_ordenar'); ?>

	<?php echo $form->hiddenField($model,'_mostrar'); ?>


	<div class="span5 data" style="margin-right:5em; "><!--style="background-color: white; padding: 1.5em; float:left; margin-right:3em; "-->
		<h2 class="data-title">Departamentos  <span class="required">*</span></h2>
		<div class="data-body" >
			<?php echo CHtml::checkBox('_chequearDep',false, array('onClick'=>'seleccionarTodasDep()')); ?> <div><i>Seleccionar Todo</i></div>
			<div>&nbsp;</div>
			<div id="departamento_organizacion" style="overflow:auto; height:250px; ">
			<?php
				echo CHtml::activeCheckBoxList($model, '_check_departamento', 
					CHtml::listData($departamentos, 'id_departamento', 'nombre_departamento'), 
					array('separator'=>'',
					'style'=>'float:left; margin-right: 5px;',
					'onChange'=>'seleccionadosDep()',
				));
			?>
			</div>
			<div id="ReporteEmpleado__departamento_error"> </div>
		</div>
	</div>

	<div class="span5 data"><!--style="background-color: white; padding: 1.5em;"-->
		<h2 class="data-title">Cargos <span class="required">*</span></h2>
		<div class="data-body" >
			<?php echo CHtml::checkBox('_chequearCargo',false, array('onClick'=>'seleccionarTodasCargo()')); ?> <div><i>Seleccionar Todo</i></div>
			<div>&nbsp;</div>
			<div id="cargo_organizacion" style="overflow:auto; height:250px; ">
			<?php 
				echo CHtml::activeCheckBoxList($model, '_check_cargo', 
					CHtml::listData($cargos, 'id_cargo', 'nombre_cargo'), 
					array('separator'=>'',
					'style'=>'float:left; margin-right: 5px;',
					'onChange'=>'seleccionadosCargo()',
				));
			?>
			</div>
			<div id="ReporteEmpleado__cargo_error"> </div>
		</div>
	</div>

	<div class="span5 data" style="margin-right:5em;" ><!--style="background-color: white; padding: 1.5em;"-->
		<h2 class="data-title">Roles de Ejecución de Actividades<span class="required">*</span> </h2>
		<div class="data-body" >
			<?php echo CHtml::checkBox('_chequearRol',false, array('onClick'=>'seleccionarTodasRol()')); ?> <div><i>Seleccionar Todo</i></div>
			<div>&nbsp;</div>
			<div style="overflow:auto; height:250px; ">	
			<?php
				echo CHtml::activeCheckBoxList($model, '_check_rol', 
					CHtml::listData($roles, 'id_rol', 'nombre_rol'), 
					array('separator'=>'',
					'style'=>'float:left; margin-right: 5px;',
					'onChange'=>'seleccionadosRol()',
				));
			?>
			</div>
			<div id="ReporteEmpleado__rol_error"> </div>
		</div>
	</div>

	<div class="span5 data" >
		
		<h2 class="data-title">Roles del Sistema <span class="required">*</span><?php //echo $form->labelEx($model, '_ordenar'); ?></h2>
		
		<div class="data-body" >
			<?php echo CHtml::checkBox('_chequearRolSistema',false, array('onClick'=>'seleccionarTodasRolSistema()')); ?> <div><i>Seleccionar Todo</i></div>
			<div>&nbsp;</div>
			<div style="overflow:auto; height:250px; ">	
			<?php
				echo CHtml::activeCheckBoxList($model, '_check_rol_sistema', 
					CHtml::listData($rolesSistema, 'variable', 'valor'), 
					array('separator'=>'',
					'style'=>'float:left; margin-right: 5px;',
					'onChange'=>'seleccionadosRolSistema()',
				));
			?>
			</div>
			<div id="ReporteEmpleado__rol_sistema_error"> </div>
		</div>

	</div>

	<div class="span5 data" style="margin-right:5em;">
		
		<h2 class="data-title">Ordenar por <span class="required">*</span><?php //echo $form->labelEx($model, '_ordenar'); ?></h2>
		
		<div class="data-body">
			<?php echo CHtml::activeRadioButtonList($model, '_radio_ordenar', array(1=>'Cédula', 2=>'Nombre'), array('separator'=>' ', 'onChange'=>'seleccionOrden()')); ?>
			<div id="ReporteEmpleado__ordenar_error"> </div>
		</div>

	</div>

	<div class="span5 data" >
		
		<h2 class="data-title">Mostrar <span class="required">*</span><?php //echo $form->labelEx($model, '_mostrar'); ?></h2>
		
		<div class="data-body">
		
			<?php echo CHtml::activeRadioButtonList($model, '_radio_mostrar', array(1=>'Activos', 2=>'Inactivos', 3=>'Todos'), array('separator'=>' ', 'onChange'=>'seleccionMostrar()')); ?>
			<div id="ReporteEmpleado__mostrar_error"> </div>
		</div>
		
	</div>
	
	<div>&nbsp;</div>

	<div class="form-actions span11">
	<?php	
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'link',
		'url'=>$this->createUrl('reporte/BuscarActividades'),
		'size'=>'medium',
		'label'=>'Generar Reporte',
		'htmlOptions'=>array('target'=>'_BLANK', 'id'=>'btnBuscar'),
	));	
	?>
	</div>

<?php $this->endWidget(); ?>



