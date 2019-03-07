<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Sesión Expirada',
);
?>

<h2>Sesión Expirada</h2>

<div class="error">
<?php echo $error; ?>
</div>