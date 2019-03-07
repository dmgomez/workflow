<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);

if($code==401)
{
?>
	<h2>Sesión Expirada</h2>
	<div class="error">
		Su sesión ha expirado. Para continuar inicie sesión nuevamente.
	</div>
<?php
}
else
{
?>
	<h2>Error <?php echo $code; ?></h2>
	<div class="error">
		<?php echo CHtml::encode($message); ?>
	</div>
<?php
}
?>