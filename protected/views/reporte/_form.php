<script type="text/javascript">
$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{
		erroresIngreso="";
		arrFechaIni=$("#reporte_fechaIni").val().split("-");
		arrFechaFin=$("#reporte_fechaFin").val().split("-");
		
		$("#check_procesos_error").text("");

		$("#reporte_fechaIni_error").text("");
		$("#reporte_fechaIni").removeClass("error");

		$("#reporte_fechaFin_error").text("");
		$("#reporte_fechaFin").removeClass("error");

		if($("#Reporte__procesosSeleccionados").val()=="")
		{
			erroresIngreso+="<li>Debe seleccionar al menos un proceso.</li>";

			$("#check_procesos_error").text("Debe seleccionar al menos un proceso.");
			$("#check_procesos_error").css("color", "#b94a48");
	
		}

		if($('#reporte_fechaIni').val()=="")
		{
			erroresIngreso+="<li>Desde no puede ser nulo.</li>";
			$("#reporte_fechaIni_error").text("Desde no puede ser nulo.");
			$("#reporte_fechaIni_error").css("color", "#b94a48");
			$("#reporte_fechaIni").addClass("error");
		}

		if($('#reporte_fechaFin').val()=="")
		{
			erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
			$("#reporte_fechaFin_error").text("Hasta no puede ser nulo.");
			$("#reporte_fechaFin_error").css("color", "#b94a48");
			$("#reporte_fechaFin").addClass("error");
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
				$("#reporte_fechaFin_error").text("Hasta debe ser una fecha posterior a Desde.");
				$("#reporte_fechaFin_error").css("color", "#b94a48");

				break;
			}

		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			$('#btnBuscar').attr('href','buscarActividades?procesos='+$("#Reporte__procesosSeleccionados").val()+'&f_ini='+$("#reporte_fechaIni").val()+'&f_fin='+$("#reporte_fechaFin").val()+'&mostrar='+$("#Reporte__mostrar").val());
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
	/*$("#procesos_select").val('');
	
	var cadena='';
	//$("input:checked").each(function()
	$("#_procesos input:checked").each(function()
	{ 
		cadena=cadena+$(this).val()+',';
	})

	cadena = cadena.substring(0, cadena.length-1);

	$("#Reporte__procesosSeleccionados").val(cadena);*/
	
	$("#Reporte__procesosSeleccionados").val($( "input:checked" ).val());
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
	'id'=>'reporte-form',
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<div id="resumenError" class="errorForm" style="display: none"></div>

	<?php echo $form->hiddenField($model,'_procesosSeleccionados'); ?>

	<label>Procesos <span class="required">*</span></label>

	<input type="text" id="search" name="search" title="Ingrese texto a buscar" style="width:250px" onKeyUp="searchTable(this.value);">

	<table id="tblData">
		<?php
		foreach ($procesos as $key => $value) 
		{
			?>
			<tr>
				<td>
					<?php echo CHtml::radioButton('_procesos', '', 
						array(//'separator'=>'',
							//'style'=>'float:left; margin-right: 5px;',
							'onClick'=>'seleccionados()',
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
	<div id="check_procesos_error"></div>
	
	<div>&nbsp;</div>

	<table width="100%">
    	<tr>
    		<td width="50%">
				<?php echo $form->labelEx($model, '_fechaIni'); ?>
				
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'reporte_fechaIni',
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
				<div id="reporte_fechaIni_error"></div>
			</td>

    		<td width="50%">
				<?php echo $form->labelEx($model, '_fechaFin'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'reporte_fechaFin',
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
				<div id="reporte_fechaFin_error"></div>
			</td>
		</tr>
		<tr>
			<td width="50%">
				<div class="itemAyuda">
					<div class="itemLabel">
						<label>
							<?php echo $form->dropDownListRow($model,'_mostrar', array('1' => 'Iniciadas y finalizadas', '2' => 'Iniciadas')/*, array('class'=>'span12')*/); ?> 
						</label>
					</div>
					<div class='tooltipAyuda help'>
	                    <span>?</span>
	                    <div class='content'>
		                    <b></b>
		                    <p>Las opciones corresponden al rango de fechas seleccionado.</p>
	                	</div>
	              	</div>
	            </div>  
            </td>

			<!--<td width="50%"> <?php //echo $form->dropDownListRow($model,'_tiempo', array('1' => 'Menor Tiempo', '2' => 'Mayor Tiempo', '3'=>'Promedio')); ?> </td>-->
    	</tr>
    </table>


	<div class="form-actions">
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



