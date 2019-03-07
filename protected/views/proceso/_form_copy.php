<script type="text/javascript">
$(document).ready(function(){
	$('#Proceso_codigo_proceso').blur(function(){

		$.ajax(
		{   

	        url: '<?php echo Yii::app()->createUrl("proceso/buscarCodigo"); ?>',
	        type: "POST",
	        data: {codigo: $("#Proceso_codigo_proceso").val(), idProc: $("#Proceso_id_proceso").val()},
	        dataType: 'json',
	        success: function(data)
	        {  

	          	if(!data.success)
	          	{
					$('#Proceso_codigo_proceso').val('');
					$('#Proceso_codigo_proceso').focus();
					showAlertAnimatedToggled(data.success, '', '', 'Error', data.message);
				}

	       }
	    }); 
	});
});
</script>
<?php
/* @var $this ProcesoController */
/* @var $model Proceso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'proceso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	//'type'=>'horizontal',
)); ?>

	<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id_proceso'); ?>


	<?php $organizacionModel = Organizacion::model();  ?>

	<?php echo $form->dropDownListRow($model,'id_organizacion', CHtml::listData($organizacionModel->findAll(array('order'=>'nombre_organizacion')),'id_organizacion', 'nombre_organizacion'),
		array('class' => 'span4', //'prompt' => '--Seleccione--',
			'ajax' => array(
					'type' => 'post',
					'dataType'=>'json',
					'data'=>array('organizacion'=> 'js:$("#Proceso_id_organizacion").val()', 'procesoCopiaId'=>'Proceso__idProcesoCopia', 'procesoCopiaName'=>'Proceso[_idProcesoCopia]', 'class' => 'span7'),
					'url' => $this->createUrl('proceso/getProcesos'),
					'success' => 'js:function(data) {
						if(data.success)
						{
							$("#Proceso__idProcesoCopia").replaceWith(data.proceso);
						}
					}'
			)
	)); ?>

	<?php echo $form->dropDownListRow($model, '_idProcesoCopia', CHtml::listData(Proceso::model()->findAllByAttributes(array('id_organizacion' => $idOrganizacion), array("order"=>"nombre_proceso")), 'id_proceso', 'nombre_proceso'),
				array('prompt'=>'-- Seleccione --', 'class' => 'span7')); ?>

	<?php echo $form->textFieldRow($model, 'codigo_proceso', array('class'=>'span3', 'size'=>10,'maxlength'=>15)); ?>
	<?php echo $form->textAreaRow($model, 'nombre_proceso', array('class'=>'span10', 'maxlength'=>250)); ?>
	<?php echo $form->textAreaRow($model, 'descripcion_proceso', array('class'=>'span10', 'maxlength'=>250, 'rows'=>2)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>$model->isNewRecord ? 'Agregar' : 'Guardar')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->