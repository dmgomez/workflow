<h1><?php echo CrugeTranslator::t('logon',"Login"); ?></h1>
<?php if(Yii::app()->user->hasFlash('loginflash')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('loginflash'); ?>
</div>
<?php else: ?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'logon-form',
	'enableClientValidation'=>false,
	//'htmlOptions'=>array('class'=>'form-horizontal'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="control-group">
		<?php //echo $form->labelEx($model,'username'); ?>
		<label>Nombre de usuario</label>
		<div class="controls">
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<div class="controls">
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
	</div>

	<div class="control-group">
		
		<div class="controls">
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe'); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>
	</div>

	<div class="clear">&nbsp;</div>

	<div class="control-group">
		<div class="controls">
		<?php Yii::app()->user->ui->tbutton(CrugeTranslator::t('logon', "Login"), array('class'=>'btn-primary')); ?>
		</div>
	</div>

	<div>
		<?php //echo Yii::app()->user->ui->passwordRecoveryLink; ?>
		<?php
			/*if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
				echo Yii::app()->user->ui->registrationLink;*/
		?>
	</div>

	<?php
		//	si el componente CrugeConnector existe lo usa:
		if(Yii::app()->getComponent('crugeconnector') != null){
		if(Yii::app()->crugeconnector->hasEnabledClients){
	?>

	<div class='crugeconnector'>
		<span><?php echo CrugeTranslator::t('logon', 'You also can login with');?>:</span>
		<ul>
		<?php
			$cc = Yii::app()->crugeconnector;
			foreach($cc->enabledClients as $key=>$config){
				$image = CHtml::image($cc->getClientDefaultImage($key));
				echo "<li>".CHtml::link($image,
					$cc->getClientLoginUrl($key))."</li>";
			}
		?>
		</ul>
	</div>
	<?php }} ?>


<?php $this->endWidget(); ?>
</div>
<?php endif; ?>
<style>

	#CrugeLogon_username {
	    background-color: transparent;
	    background-image: url("../../images/img_usuario.png") !important;
	    background-position: 50% 50%;
	    background-repeat: no-repeat;
	    border: 0 none;
	    color: black;
	    height: 22px;
	    padding-left: 30px;
	    text-indent: 5px;
	    width: 190px;
	}

	#CrugeLogon_password {
	    background-color: transparent;
	    background-image: url("../../images/img_password.png") !important;
	    background-position: 50% 50%;
	    background-repeat: no-repeat;
	    border: 0 none;
	    color: black;
	    height: 22px;
	    padding-left: 30px;
	    text-indent: 5px;
	    width: 190px;
	}

</style>