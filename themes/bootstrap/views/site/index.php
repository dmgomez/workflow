<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php

/*$this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Bienvenido a '.CHtml::encode(Yii::app()->name),
)); */

?>

<div style="float: left; margin-top:13em;">
	<img src="<?php echo Yii::app()->request->baseUrl . '/images/logo_corto_1.png'; ?>">
</div>

<div style="margin-left:200px; margin-top:13em;">
	<h1>Bienvenido a <?php echo CHtml::encode(Yii::app()->name); ?></h1>
	<h3>Sistema para el Control de Flujo de Procesos</h3>
	<?php if (!Yii::app()->user->isGuest){ ?>
		<p>Para ver sus actividades pendientes presione el siguiente enlace: <?php echo CHtml::link('Actividades Pendientes',array('instanciaActividad/admin')); ?></p>
	<?php } ?>
	<p><?php //echo CHtml::button('Actividades Pendientes', array('class'=>'btn-primary', 'submit' => array('instanciaActividad/admin'))); ?></p>
</div>


<div class="clear">&nbsp;</div>
<div class="clear">&nbsp;</div>

<?php Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$("#info").delay(5000).fadeOut("slow");',
   CClientScript::POS_READY
); ?>