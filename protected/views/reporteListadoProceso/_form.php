<script type="text/javascript">
/*$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{
		erroresIngreso="";
		$("#ReporteListadoProceso__proceso_error").text("");
		//$("#ReporteListadoProceso__proceso").removeClass("error");

		if($("#ReporteListadoProceso__proceso").val()=="")
		{
			erroresIngreso+="<li>Proceso no puede ser nulo.</li>";

			$("#ReporteListadoProceso__proceso_error").text("Proceso no puede ser nulo.");
			$("#ReporteListadoProceso__proceso_error").css("color", "#b94a48");
	
		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			$('#btnBuscar').attr('href','buscarActividades?proceso='+$("#ReporteListadoProceso__proceso").val());
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




function seleccionados()
{
	
	$("#ReporteListadoProceso__proceso").val($( "input:checked" ).val());

	
}*/

$(document ).ready(function() {
	$( "#btnGenerar" ).on( "click", function() 
	{
		erroresIngreso="";
		$("#check_procesos_error").text("");
		//$("#ReporteListadoProceso__proceso").removeClass("error");

		if($("#ReporteListadoProceso__procesosSeleccionados").val()=="")
		{
			erroresIngreso+="<li>Proceso no puede ser nulo.</li>";

			$("#check_procesos_error").text("Proceso no puede ser nulo.");
			$("#check_procesos_error").css("color", "#b94a48");
	
		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			//$('#btnGenerar').attr('href','generarReporte?organizacion='+$("#ReporteListadoProceso__organizacion").val()+'&proceso='+$("#ReporteListadoProceso__procesosSeleccionados").val()+'&actividad='+$("#ReporteListadoProceso__mostrarActividades").val()+'&empleado='+$("#ReporteListadoProceso__mostrarEmpleados").val());
			$('#btnGenerar').attr('href','generarReporte?proceso='+$("#ReporteListadoProceso__procesosSeleccionados").val()+'&actividad='+$("#ReporteListadoProceso__mostrarActividades").val()+'&empleado='+$("#ReporteListadoProceso__mostrarEmpleados").val());
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

/*function seleccionados(a)
{
	$("#ReporteListadoProceso__procesosSeleccionados").val('');
alert(a);
	if($(this)[0].checked)
	{
		alert("si ");
	}
	else
	{
		alert("no ");
	}

	$("input[type=checkbox]").each(function()
	{ 
		$("#"+$(this).val()).css("display", "none");
		$("#A"+$(this).val()).prop("class", "toggleStatus btn btn-info");
		$("#E"+$(this).val()).prop("class", "toggleStatus disabled btn btn-info");

		$("#ReporteListadoProceso__mostrarActividades").val('');
		$("#ReporteListadoProceso__mostrarEmpleados").val('');
	})
	
	var cadena='';

	$(" input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
		$("#"+$(this).val()).css("display", "");
	})

	cadena = cadena.substring(0, cadena.length-1);

	$("#ReporteListadoProceso__procesosSeleccionados").val(cadena);
	
}*/

function seleccionarProceso(element)
{
	//alert(element.is(":checked"));
	//alert(element.val());
	if($("#ReporteListadoProceso__procesosSeleccionados").val() != '')
	{
		var cadena = $("#ReporteListadoProceso__procesosSeleccionados").val()+',';	
	}
	else
	{
		var cadena = '';
	}

	//id_actividad = id.substring(1, id.length);

	if(element.is(":checked"))
	{
		cadena=cadena+element.val()+',';
		$("#"+element.val()).css("display", "");
	}
	else
	{	
		cadena = cadena.replace(element.val()+',', '');
		cadena = cadena.replace(element.val(), '');
		//cadena = cadena.replace(',,', '');

		var cadenaA = $("#ReporteListadoProceso__mostrarActividades").val();
		cadenaA = cadenaA.replace(element.val()+',', '');
		cadenaA = cadenaA.replace(','+element.val(), '');

		cadenaA = cadenaA.replace(element.val(), '');
		//cadenaA = cadenaA.replace(',,', '');
		//var regex = element.val()+','|','+element.val()|element.val()
		//cadenaA = cadenaA.replace(/regex/, '');
		$("#ReporteListadoProceso__mostrarActividades").val(cadenaA);

		$("#A"+element.val()).prop("class", "toggleStatus btn btn-info");

		var cadenaE = $("#ReporteListadoProceso__mostrarEmpleados").val();
		cadenaE = cadenaE.replace(element.val()+',', '');
		cadenaE = cadenaE.replace(','+element.val(), '');

		cadenaE = cadenaE.replace(element.val(), '');
		//cadenaE = cadenaE.replace(',,', '');
		//cadenaE = cadenaE.replace(/element.val()+','|','+element.val()|element.val()/, '');
		$("#ReporteListadoProceso__mostrarEmpleados").val(cadenaE);

		$("#E"+element.val()).prop("class", "toggleStatus disabled btn btn-info");

		$("#"+element.val()).css("display", "none");
	}


	cadena = cadena.substring(0, cadena.length-1);

	$("#ReporteListadoProceso__procesosSeleccionados").val(cadena);
}

function seleccionarActividad(id)
{
	//$("#ReporteListadoProceso__mostrarActividades").val('');
	if($("#ReporteListadoProceso__mostrarActividades").val() != '')
	{
		var cadena = $("#ReporteListadoProceso__mostrarActividades").val()+',';	
	}
	else
	{
		var cadena = '';
	}

	id_actividad = id.substring(1, id.length);

	if($("#"+id).prop("class") == "toggleStatus btn btn-info")
	{
		cadena=cadena+id_actividad+',';
		$("#E"+id_actividad).prop("class", "toggleStatus btn btn-info");
	}
	else
	{	
		cadena = cadena.replace(id_actividad+',', '');
		cadena = cadena.replace(id_actividad, '');
		//cadena = cadena.replace(',,', '');

		var cadenaE = $("#ReporteListadoProceso__mostrarEmpleados").val();
		cadenaE = cadenaE.replace(id_actividad+',', '');
		cadenaE = cadenaE.replace(','+id_actividad, '');
		cadenaE = cadenaE.replace(id_actividad, '');
		//cadenaE = cadenaE.replace(',,', '');
		$("#ReporteListadoProceso__mostrarEmpleados").val(cadenaE);

		$("#E"+id_actividad).prop("class", "toggleStatus disabled btn btn-info");
	}


	cadena = cadena.substring(0, cadena.length-1);

	$("#ReporteListadoProceso__mostrarActividades").val(cadena);
	
}

function seleccionarEmpleado(id)
{
	if($("#ReporteListadoProceso__mostrarEmpleados").val() != '')
	{
		var cadena = $("#ReporteListadoProceso__mostrarEmpleados").val()+',';	
	}
	else
	{
		var cadena = '';
	}

	id_empleado = id.substring(1, id.length);

	if($("#"+id).prop("class") == "toggleStatus btn btn-info")
	{
		cadena=cadena+id_empleado+',';
	}
	else
	{	
		cadena = cadena.replace(id_empleado+',', '');
		//cadena = cadena.replace(',,', '');
	}


	cadena = cadena.substring(0, cadena.length-1);

	$("#ReporteListadoProceso__mostrarEmpleados").val(cadena);
	
}

function seleccionarTodas()
{
	searchTable($("#search").val(''));
	$("#ReporteListadoProceso__procesosSeleccionados").val('');
	var cadena='';

	if($('#_chequearProcesos').is(":checked"))
	{
		$("input[type=checkbox]").each(function()
		{  
			cadena=cadena+$(this).val()+',';
			$(" input").prop("checked", "checked");
			$("#"+$(this).val()).css("display", "");
		})
	}
	else
	{ 
		$("input[type=checkbox]").each(function()
		{ 
			$("input").prop('checked', false);
			$("#"+$(this).val()).css("display", "none");
			$("#A"+$(this).val()).prop("class", "toggleStatus btn btn-info");
			$("#E"+$(this).val()).prop("class", "toggleStatus disabled btn btn-info");

			$("#ReporteListadoProceso__mostrarActividades").val('');
			$("#ReporteListadoProceso__mostrarEmpleados").val('');
		})
	}

	if(cadena!="")
	{
		cadena = cadena.substring(0, cadena.length-1);
	}
	
	$("#ReporteListadoProceso__procesosSeleccionados").val(cadena);

}



</script>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reporte-form',
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<div id="resumenError" class="errorForm" style="display: none"></div>

	<?php echo $form->hiddenField($model,'_procesosSeleccionados'); ?>
	<?php echo $form->hiddenField($model,'_mostrarActividades'); ?>
	<?php echo $form->hiddenField($model,'_mostrarEmpleados'); ?>

	<div>
		<?php 
		if(Yii::app()->user->isSuperAdmin)
		{
			echo $form->dropDownListRow($model, '_organizacion', CHtml::listData(Organizacion::model()->findAll(array('order' => 'nombre_organizacion')), 'id_organizacion', 'nombre_organizacion'), 
			array('class' => 'span4', 'options' => array($idOrganizacion=>array('selected'=>true)),
				'ajax' => array(
					'type' => 'post',
					'dataType'=>'json',
					'data'=>array('idOrganizacion'=> 'js:$("#ReporteListadoProceso__organizacion").val()'),
					'url' => $this->createUrl('reporteListadoProceso/CargarTabla'),
					'success' => 'js:function(data) {
						if(data.success)
						{
							$("#tblData").html(data.tabla);
							
							$("#ReporteListadoProceso__procesosSeleccionados").val("");
							$("#ReporteListadoProceso__mostrarActividades").val("");
							$("#ReporteListadoProceso__mostrarEmpleados").val("");
						}
						

					}'
				)
			) );
		} 
		?> 
	</div>
	<div id="ReporteListadoProceso__organizacion_error"> </div>



	<label>Procesos <span class="required">*</span></label>

	<?php echo CHtml::checkBox('_chequearProcesos',false, array('onClick'=>'seleccionarTodas()')); ?> <div><i>Seleccionar Todo</i></div>
	<div>&nbsp;</div>

	<input type="text" id="search" name="search" title="Ingrese texto a buscar" style="width:250px" onKeyUp="searchTable(this.value);">

	<table id="tblData">
		<?php
		foreach ($procesos as $key => $value) 
		{
			?>
			<tr>
				<td>
					<?php echo CHtml::checkBox('_procesos', '',
						array(//'separator'=>'',
							//'style'=>'float:left; margin-right: 5px;',
							'onClick'=>'seleccionarProceso($(this))',
							'value'=>$value['id'],
						));
					?> 
				</td>
				<td>
					<?php echo $value['nombre']; ?>
				</td>
			</tr>
			<tr id="<?=$value['id']?>" style="display: none">
				<td></td>
				<td>
				<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'toggle' => 'checkbox',
				    'buttons' => array(
				        array(
				            'label' => 'Mostrar Actividades',
				            'type' => 'info',
				            //'url' => Yii::app()->createUrl('admin/news/publish', array('id' => $data->id)),
				            'htmlOptions' => array(
				                'id' => 'A' . $value['id'],
				                'class' => 'toggleStatus',
				                'onClick'=>'seleccionarActividad($(this).prop("id"))',
				            ),
				            //'active' => /*($data->isPublished()) ?*/ true /*: false*/,
				        ),
				        array(
				            'label' => 'Mostrar Empleados',
				            'type' => 'info',
				            //'url' => Yii::app()->createUrl('admin/news/archive', array('id' => $data->id)),
				            'htmlOptions' => array(
				                'id' => 'E' . $value['id'],
				                'class' => 'toggleStatus disabled',
				                'onClick'=>'seleccionarEmpleado($(this).prop("id"))',
				            ),
				            //'active' => /*($data->isArchived()) ? true :*/ false,
				        ),
				        
				    )
				));?>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
	<!--<div id="ReporteListadoProceso__proceso_error"></div>-->
	<div id="check_procesos_error"></div>
	
	<div>&nbsp;</div>





	<div class="form-actions">
	<?php	
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'link',
		'url'=>$this->createUrl('reporte/generarReporte'),
		'size'=>'medium',
		'label'=>'Generar Reporte',
		'htmlOptions'=>array('target'=>'_BLANK', 'id'=>'btnGenerar'),
		
	));	
	?>
	</div>


<?php $this->endWidget(); ?>



