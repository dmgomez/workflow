<script type="text/javascript">
$(document ).ready(function() {
	$( "#btnBuscar" ).on( "click", function() 
	{
		$("#ReporteTramite__codigo_error").text("");
		$("#ReporteTramite__codigo").removeClass("error");

		$.ajax({   

	        url: '<?php echo Yii::app()->createUrl("reporteTramite/BuscarTramite"); ?>',
	        type: "POST",
	        data: {codigo: $("#ReporteTramite__codigo").val()},
	        dataType: 'json',
	        success: function(datos){  
	        	
	          	erroresIngreso="";

	          	if(datos.success)
	          	{
					$('#resumenError').html('');
					$("#resumenError").css("display", "none");

					window.open("cargarReporte?idTramite="+datos.idTramite,"_blank");
	          	}
	          	else
	          	{
	          		if($("#ReporteTramite__codigo").val()=="")
					{
						erroresIngreso="<li>Código del Trámite no puede ser nulo.</li>";

						$("#ReporteTramite__codigo_error").text("Código del Trámite no puede ser nulo.");
						$("#ReporteTramite__codigo_error").css("color", "#b94a48");
						$("#ReporteTramite__codigo").addClass("error");
					}
					else
					{
		          		erroresIngreso="<li>Código del Trámite inválido. El código que ingresó no corresponde a ningún trámite.</li>";

						$("#ReporteTramite__codigo_error").text("Código del Trámite inválido. El código que ingresó no corresponde a ningún trámite.");
						$("#ReporteTramite__codigo_error").css("color", "#b94a48");
						$("#ReporteTramite__codigo").addClass("error");
					}
					
	          	}

	          	if(erroresIngreso!="")
	          	{
	          		$('#resumenError').html('<p>Por favor corrija los siguientes errores de ingreso.</p><ul>'+erroresIngreso+'</ul>');
		
					$("#resumenError").css("display", "");
	          	}
	       }
	    });
		
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

	
	<?php echo $form->textFieldRow($model, '_codigo', array('class'=>'span4',)); ?> 
	<div id="ReporteTramite__codigo_error"></div>

	<div class="form-actions">
	<?php	
	$this->widget('bootstrap.widgets.TbButton', array(
		//'buttonType'=>'link',
		'buttonType'=>'button',
		//'url'=>$this->createUrl('reporteTramite/cargarReporte'),
		'size'=>'medium',
		'label'=>'Generar Reporte',
		//'htmlOptions'=>array('target'=>'_BLANK', 'id'=>'btnBuscar'),
		'htmlOptions'=>array('id'=>'btnBuscar'),
		
	));	
	?>
	</div>


<?php $this->endWidget(); ?>



