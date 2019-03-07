<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/scripts/functions.js"></script>

	<title>Control de Flujo de Procesos</title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body class="backglogin">

<?php

	$menu = new BarraMenu(Yii::app()->user->getId());

	// Si uso acentos se friega. Tengo que revisar eso
	$this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>$menu->crearMenu(),
	));

?>

<div class="container" id="page">

	<div style="top: 60px; position: fixed; width: 1170px">
        <div id="flash" class="nodisplay"></div>
    </div>

    <?php
        $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'closeText'=>false,
            'htmlOptions'=>array('id'=>'info', 'style'=>'top: 60px; position: fixed; width: 1170px;'),
        )
        );
    ?>

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear">&nbsp;</div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> CFP.<br/>
		Todos los Derechos Reservados.<br/>
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>

<style type="text/css">
.data {
  margin: 40px auto;
  border: 1px solid #cdd3d7;
  border-radius: 8px;
  padding-left: 2em;
  -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.data-title {
  line-height: inherit;
  font-size: 14px;
  font-weight: bold;
  position: relative;
  top: -2em;
  left: -1.5em;
}
.data-body{
	position: relative;
	top: -1.5em;
}

div.errorForm
{
  padding:.8em;
  margin-bottom:1em;
  border:1px solid #ddd;
  border-radius: 0.3em;

  background:#FBE3E4;
  color:#8a1f11;
  border-color:#FBC2C4;
}

div.errorForm a
{
  color:#8a1f11;
}
</style>