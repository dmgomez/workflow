<?php
$sqlMunicipio="SELECT valor FROM configuracion WHERE variable = 'id_municipio'";
$municipio= Yii::app()->db->createCommand($sqlMunicipio)->queryRow();
$idMunicipio=$municipio['valor'];
?>
<div>

    <div class="modal-header">
        <h2>Agregar Inmueble</h2>
    </div> 

	<div class="modal-body">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'inmueble-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
		)); ?>

		<p class="note">Los campos marcados con <span class="required">*</span> son requeridos.</p>

		<?php echo $form->textAreaRow($model, 'direccion_inmueble', array('class'=>'span6', 'rows'=>4, 'maxlength'=>250)); ?>
		
		<div class="control-group">
			<label class="control-label" >
				<?php echo CHtml::activeLabel($model, '_municipio'); ?>
			</label>
			<div class="controls">
				<?php echo $form->dropDownList($model, '_municipio', CHtml::listData(Municipio::model()->findAll(array('order' => 'nombre_municipio')), 'id_municipio', 'nombre_municipio'), 
					array('class' => 'span4', 'options' => array($idMunicipio=>array('selected'=>true)),
						'ajax' => array(
							'type' => 'post',
							'dataType'=>'json',
							'data'=>array('municipio'=> 'js:$("#Inmueble__municipio").val()', 'parroquiaId'=>'Inmueble_id_parroquia', 'parroquiaName'=>'Inmueble[id_parroquia]', 'class' => 'span4'),
							'url' => $this->createUrl('inmueble/getParroquias'),
							'success' => 'js:function(data) {
								$("#Inmueble_id_parroquia").replaceWith(data.parroquia);
							}'
					))); ?> 
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" ><?php echo $form->labelEx($model, 'id_parroquia'); ?></label>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'id_parroquia', CHtml::listData(Parroquia::model()->findAllByAttributes(array('id_municipio' => $idMunicipio)), 'id_parroquia', 'nombre_parroquia'), 
						array('prompt'=>'Seleccione', 'class' => 'span4', 'options' => array($model->id_parroquia => array('selected' => true)))); ?>
				<?php echo $form->error($model, 'id_parroquia'); ?>
			</div>
		</div>

		<div class="form-actions">
			
		
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',
			'url'=>$this->createUrl('instanciaProceso/AgregarInmueble'),
			'size'=>'medium',
			'label'=>'Agregar',
			'htmlOptions'=>array('title'=>'Agrega un inmueble.'),
			'ajaxOptions'=>array(
				'type'=>'POST',
				'data'=>'js:{
					direccion: $("#Inmueble_direccion_inmueble").val(), municipio: $("#Inmueble__municipio").val(), parroquia: $("#Inmueble_id_parroquia").val()
				}',
				'dataType'=>'json',
				'success' => "js: function(data) {
					
					if(data.success)
					{
						$('#InstanciaProceso__direccionInmueble').val(data.direccion);
						$('#InstanciaProceso__municipio').val(data.municipio);
						$('#InstanciaProceso__parroquia').val(data.parroquia);
						$('#InstanciaProceso_id_inmueble').val(data.id);
						$('#Inmueble_direccion_inmueble').val('');
						$('#Inmueble_id_parroquia').val('');

						$('#agregar-inmueble').modal('hide');
					}
					else
					{
						$('#InstanciaProceso__direccionInmueble').val('');
						$('#InstanciaProceso__municipio').val('');
						$('#InstanciaProceso__parroquia').val('');
						$('#InstanciaProceso_id_inmueble').val('');

						$('#agregar-inmueble').modal('hide');
					}

					showAlertAnimatedToggled(data.success, 'Registro agregado con éxito.', data.message, 'Error', data.message);
				}",
			),

		)); ?>

		</div>
			
		 
		<?php $this->endWidget(); ?>


	</div>

    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cerrar</a>	
    </div>

</div>