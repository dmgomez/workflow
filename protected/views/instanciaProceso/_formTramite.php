<script type="text/javascript">

function seleccionadas(id)
{
	$("#Tramite__actividad").val('');	
	var cadena='';
	var activar = false;
	var desactivar = false;

	$("#Tramite__check_actividad input").each(function()
	{ 
		if(activar)
		{
			$(this).attr("disabled", false);

			activar = false;
		}
		if(desactivar)
		{
			$(this).attr("disabled", true);
			$(this).attr("checked", false);
		}

		if( $(this).is( ":checked" ) )
		{
			cadena=cadena+$(this).val()+',';

			if( !$(this).is( ":disabled" ) )
			{
				activar = true;
			}
		}
		else if( $(this).val() == id )
		{
			desactivar = true;
		}
	})

	cadena = cadena.substring(0, cadena.length-1);
	$("#Tramite__actividad").val(cadena);
}

$(document).ready(function() {
	
	$("#Tramite__check_actividad_0").attr("disabled", false);

});

</script>
<?php
/* @var $this InstanciaProcesoController */
/* @var $model InstanciaProceso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'regresar-tramite-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p><br>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'_actividad'); ?>

	<p class="note">Seleccione las actividades que desea eliminar para regresar el proceso a una actividad anterior.</p>
	<?php echo $form->labelEx($model, '_check_actividad'); //echo CHtml::activeLabel($model, '_check_actividad'); ?>

	<?php
		echo CHtml::activeCheckBoxList($model, '_check_actividad', 
			CHtml::listData($actividades, 'id_instancia_actividad', 'nombre_actividad'), 
			array('separator'=>'',
			'style'=>'float:left; margin-right: 5px;',
			'onChange'=>'seleccionadas($(this).val())',
			'disabled'=>true,
		));
	?>

	<div class="form-actions">
		<?php	
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			//'url'=>$this->createUrl('instanciaProceso/BuscarActividades'),
			'size'=>'medium',
			'label'=>'Regresar',
			//'htmlOptions'=>array('target'=>'_BLANK', 'id'=>'btnBuscar'),
		));	
		?>
	</div>

<?php $this->endWidget(); ?>