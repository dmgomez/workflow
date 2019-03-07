<script type="text/javascript">
$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{
		erroresIngreso="";
		arrFechaIni=$("#ReporteConsolidado_fechaIni").val().split("-");
		arrFechaFin=$("#ReporteConsolidado_fechaFin").val().split("-");
		
		$("#check_procesos_error").text("");

		$("#ReporteConsolidado_fechaIni_error").text("");
		$("#ReporteConsolidado_fechaIni").removeClass("error");

		$("#ReporteConsolidado_fechaFin_error").text("");
		$("#ReporteConsolidado_fechaFin").removeClass("error");

		if($("#ReporteConsolidado__procesosSeleccionados").val()=="")
		{
			erroresIngreso+="<li>Debe seleccionar al menos un proceso.</li>";

			$("#check_procesos_error").text("Debe seleccionar al menos un proceso.");
			$("#check_procesos_error").css("color", "#b94a48");
	
		}

		if($('#ReporteConsolidado_fechaIni').val()=="")
		{
			erroresIngreso+="<li>Desde no puede ser nulo.</li>";
			$("#ReporteConsolidado_fechaIni_error").text("Desde no puede ser nulo.");
			$("#ReporteConsolidado_fechaIni_error").css("color", "#b94a48");
			$("#ReporteConsolidado_fechaIni").addClass("error");
		}

		if($('#ReporteConsolidado_fechaFin').val()=="")
		{
			erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
			$("#ReporteConsolidado_fechaFin_error").text("Hasta no puede ser nulo.");
			$("#ReporteConsolidado_fechaFin_error").css("color", "#b94a48");
			$("#ReporteConsolidado_fechaFin").addClass("error");
		}

		/*for(i=arrFechaIni.length-1; i>=0; i--)
		{
			if(arrFechaFin[i]<arrFechaIni[i])
			{
				erroresIngreso+="<li>Hasta debe ser una fecha posterior a Desde.</li>";
				$("#ReporteConsolidado_fechaFin_error").text("Hasta debe ser una fecha posterior a Desde.");
				$("#ReporteConsolidado_fechaFin_error").css("color", "#b94a48");

				break;
			}

		}*/

		for(i=arrFechaIni.length-1; i>=0; i--)
		{
			if(arrFechaFin[i]>arrFechaIni[i])
			{
				break;
			}
			else if(arrFechaFin[i]<arrFechaIni[i])
			{
				erroresIngreso+="<li>Hasta debe ser una fecha posterior a Desde.</li>";
				$("#reporte_fechaFin_error").text("Hasta debe ser una fecha posterior a Desde.");
				$("#reporte_fechaFin_error").css("color", "#b94a48");

				break;
			}

		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			$('#btnBuscar').attr('href','buscarActividades?procesos='+$("#ReporteConsolidado__procesosSeleccionados").val()+'&f_ini='+$("#ReporteConsolidado_fechaIni").val()+'&f_fin='+$("#ReporteConsolidado_fechaFin").val());
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
	$("#ReporteConsolidado__procesosSeleccionados").val('');
	
	var cadena='';

	$(" input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);

	$("#ReporteConsolidado__procesosSeleccionados").val(cadena);
	
}

function seleccionarTodas()
{
	$("#ReporteConsolidado__procesosSeleccionados").val('');
	var cadena='';

	if($('#_chequearProcesos').is(":checked"))
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
	
	$("#ReporteConsolidado__procesosSeleccionados").val(cadena);

	searchTable($("#search").val(''));
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


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reporte-consolidado-form',
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<div id="resumenError" class="errorForm" style="display: none"></div>

	<?php echo $form->hiddenField($model,'_procesosSeleccionados'); ?>

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
							'onClick'=>'seleccionados()',
							'value'=>$value['id'],
							//'id'=>'_procesos_'.$key,
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
	<div id="check_procesos_error"></div>
	
	<div>&nbsp;</div>

	<table width="100%">
    	<tr>
    		<td width="50%">
				<?php echo $form->labelEx($model, '_fechaIni'); ?>
				
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'ReporteConsolidado_fechaIni',
						'language'=>'es',
						'htmlOptions' => array(/*'class'=>'span4',*/ 'readonly'=>'readonly'),
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
				<div id="ReporteConsolidado_fechaIni_error"></div>
			</td>

    		<td width="50%">
				<?php echo $form->labelEx($model, '_fechaFin'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'ReporteConsolidado_fechaFin',
						'language'=>'es',
						'htmlOptions' => array(/*'class'=>'span4',*/ 'readonly'=>'readonly'),
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
				<div id="ReporteConsolidado_fechaFin_error"></div>
			</td>
		</tr>
		
    </table>


	<div class="form-actions">
	<?php	
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'link',
		'url'=>$this->createUrl('reporteConsolidado/BuscarActividades'),
		'size'=>'medium',
		'label'=>'Generar Reporte',
		'htmlOptions'=>array('target'=>'_BLANK', 'id'=>'btnBuscar'),
		
	));	
	?>
	</div>


<?php $this->endWidget(); ?>



