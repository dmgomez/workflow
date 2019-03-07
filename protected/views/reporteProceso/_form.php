<script type="text/javascript">
$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{
		erroresIngreso="";
		arrFechaIni=$("#ReporteProceso_fechaIni").val().split("-");
		arrFechaFin=$("#ReporteProceso_fechaFin").val().split("-");

		$("#ReporteProceso_proceso_error").text("");
		$("#ReporteProceso__proceso").removeClass("error");


		$("#ReporteProceso_fechaIni_error").text("");
		$("#ReporteProceso_fechaIni").removeClass("error");

		$("#ReporteProceso_fechaFin_error").text("");
		$("#ReporteProceso_fechaFin").removeClass("error");

		if($('#ReporteProceso__proceso').val()=="")
		{
			erroresIngreso+="<li>Proceso no puede ser nulo.</li>";
			$("#ReporteProceso_proceso_error").text("Proceso no puede ser nulo.");
			$("#ReporteProceso_proceso_error").css("color", "#b94a48");
			$("#ReporteProceso__proceso").addClass("error");
		}

		if($('#ReporteProceso_fechaIni').val()=="")
		{
			erroresIngreso+="<li>Desde no puede ser nulo.</li>";
			$("#ReporteProceso_fechaIni_error").text("Desde no puede ser nulo.");
			$("#ReporteProceso_fechaIni_error").css("color", "#b94a48");
			$("#ReporteProceso_fechaIni").addClass("error");
		}

		if($('#ReporteProceso_fechaFin').val()=="")
		{
			erroresIngreso+="<li>Hasta no puede ser nulo.</li>";
			$("#ReporteProceso_fechaFin_error").text("Hasta no puede ser nulo.");
			$("#ReporteProceso_fechaFin_error").css("color", "#b94a48");
			$("#ReporteProceso_fechaFin").addClass("error");
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
				$("#ReporteProceso_fechaFin_error").text("Hasta debe ser una fecha posterior a Desde.");
				$("#ReporteProceso_fechaFin_error").css("color", "#b94a48");
				$("#ReporteProceso_fechaFin").addClass("error");

				break;
			}

		}

		if(erroresIngreso=="")
		{
			$('#resumenError').html('');
			$("#resumenError").css("display", "none");
			$('#btnBuscar').attr('href','buscarActividades?proceso='+$("#ReporteProceso__proceso").val()+'&f_ini='+$("#ReporteProceso_fechaIni").val()+'&f_fin='+$("#ReporteProceso_fechaFin").val());
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
				'data'=>array('idOrganizacion'=> 'js:$("#ReporteProceso__organizacion").val()'),
				'url' => $this->createUrl('reporteProceso/CargarProcesos'),
				'success' => 'js:function(data) {
					if(data.success)
					{
						$("#ReporteProceso__proceso").html(data.proceso);
					}
					

				}'
			)
		) ); ?> 
	</div>

	<?php echo $form->dropDownListRow($model,'_proceso', CHtml::listData($procesos, 'id','nombre'), array('class'=>'span8')); ?>
	<div id="ReporteProceso_proceso_error"></div>
	<!--<div id="check_proceso_error"></div>-->
	
	<div>&nbsp;</div>

	<table width="93%">
    	<tr>
    		<td width="50%">
				<?php echo $form->labelEx($model, '_fechaIni'); ?>
				
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'ReporteProceso_fechaIni',
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
				<div id="ReporteProceso_fechaIni_error"></div>
			</td>

    		<td width="50%">
				<?php echo $form->labelEx($model, '_fechaFin'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
					array(
						'name'=>'ReporteProceso_fechaFin',
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
				<div id="ReporteProceso_fechaFin_error"></div>
			</td>
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



