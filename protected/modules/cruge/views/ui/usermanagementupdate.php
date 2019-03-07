<?php
	/*
		$model:  
			es una instancia que implementa a ICrugeStoredUser, y debe traer ya los campos extra 	accesibles desde $model->getFields()
		
		$boolIsUserManagement: 
			true o false.  si es true indica que esta operandose bajo el action de adminstracion de usuarios, si es false indica que se esta operando bajo 'editar tu perfil'
	*/
?>
<h1><?php echo ucwords(CrugeTranslator::t(	
	$boolIsUserManagement ? "editando usuario" : "editando tu perfil"
));?></h1>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'crugestoreduser-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
)); ?>
<!--<div class="row form-group">-->
<div class="form">

	<!--<div class='field-group'>-->
	<div class='data'>

		<h2 class="data-title"><?php echo ucfirst(CrugeTranslator::t("datos de la cuenta"));?></h2>
		<div class="data-body">
			
				<?php echo $form->labelEx($model,'username'); ?>
				<?php 
				if($boolIsUserManagement)
					echo $form->textField($model,'username', array('class'=>'span4')); 
				else
					echo $form->textField($model,'username', array('class'=>'span4', 'readonly'=>'readonly')); 
				?>
				<?php echo $form->error($model,'username'); ?>
			
		
				<?php //echo $form->labelEx($model,'email'); ?>
				<?php //echo $form->textField($model,'email', array('class'=>'span4')); ?>
				<?php //echo $form->error($model,'email'); ?>
			
				<?php echo $form->labelEx($model,'newPassword'); ?>
				<?php echo $form->textField($model,'newPassword',array('size'=>10, 'class'=>'span4')); ?>
				<?php echo $form->error($model,'newPassword'); ?>
				<script>
					function fnSuccess(data){
						$('#CrugeStoredUser_newPassword').val(data);
					}
					function fnError(e){
						alert("error: "+e.responseText);
					}
				</script>
				&nbsp;&nbsp;&nbsp;<?php echo CHtml::ajaxbutton(
					CrugeTranslator::t("Generar una nueva clave")
					,Yii::app()->user->ui->ajaxGenerateNewPasswordUrl
					,array('success'=>new CJavaScriptExpression('fnSuccess'),
						'error'=>new CJavaScriptExpression('fnError'))
					,array('class'=>'btn-primary')
				); ?>
			
		</div>
	</div>
	
	<!--<div class='data'>
		<h2 class="data-title">Observaciones</h2>
		<div class="data-body">
			<div class='col textfield-readonly'>
				<?php //echo $form->labelEx($model,'regdate'); ?>
				<?php /*echo $form->textField($model,'regdate'
						,array(
							'readonly'=>'readonly',
							'value'=>Yii::app()->user->ui->formatDate($model->regdate),
						)
				);*/ ?>
			</div>
			<div class='col textfield-readonly'>
				<?php //echo $form->labelEx($model,'actdate'); ?>
				<?php /*echo $form->textField($model,'actdate'
						,array(
							'readonly'=>'readonly',
							'value'=>Yii::app()->user->ui->formatDate($model->actdate),
						)
					);*/ ?>
			</div>
			<div class='col textfield-readonly'>
				<?php //echo $form->labelEx($model,'logondate'); ?>
				<?php /*echo $form->textField($model,'logondate'
						,array(
							'readonly'=>'readonly',
							'value'=>Yii::app()->user->ui->formatDate($model->logondate),
						)
					);*/ ?>
			</div>
		</div>
	</div>-->
</div>

<!-- inicio de campos extra definidos por el administrador del sistema -->
<?php 
	if(count($model->getFields()) > 0){
		echo "<div class='row form-group'>";
		echo "<h6>".ucfirst(CrugeTranslator::t("perfil"))."</h6>";
		foreach($model->getFields() as $f){
			// aqui $f es una instancia que implementa a: ICrugeField
			echo "<div class='col'>";
			echo Yii::app()->user->um->getLabelField($f);
			echo Yii::app()->user->um->getInputField($model,$f);
			echo $form->error($model,$f->fieldname);
			echo "</div>";
		}
		echo "</div>";
	}
?>
<!-- fin de campos extra definidos por el administrador del sistema -->




<!-- inicio de opciones avanazadas, solo accesible bajo el rol 'admin' -->

<?php 
	if($boolIsUserManagement)
	if(Yii::app()->user->checkAccess('edit-advanced-profile-features'
		,__FILE__." linea ".__LINE__))
		$this->renderPartial('_edit-advanced-profile-features'
			,array('model'=>$model,'form'=>$form),false); 
?>

<!-- fin de opciones avanazadas, solo accesible bajo el rol 'admin' -->





<div class="form-actions">
	<?php Yii::app()->user->ui->tbutton("Guardar Cambios"); ?>
	
</div>
<?php echo $form->errorSummary($model); ?>
<?php $this->endWidget(); ?>
</div>
