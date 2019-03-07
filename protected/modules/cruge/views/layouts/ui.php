<?php
/*
	aqui: $this->beginContent('//layouts/main'); indica que este layout se amolda 
	al layout que se haya definido para todo el sistema, y dentro de el colocara
	su propio layout para amoldar a un CPortlet.
	
	esto es para asegurar que el sistema disponga de un portlet, 
	esto es casi lo mismo que haber puesto en UiController::layout = '//layouts/column2'
	a diferencia que aqui se indica el uso de un archivo CSS para estilos predefinidos
	
	Yii::app()->layout asegura que estemos insertando este contenido en el layout que
	se ha definido para el sistema principal.
*/
?>
<?php 
	//$this->beginContent('//layouts/'.Yii::app()->layout); 
	$this->beginContent('//layouts/main');
?>

<?php	
	if(Yii::app()->user->isSuperAdmin)
		echo Yii::app()->user->ui->superAdminNote();
?>

<!--<div class="container">
	<div class="span-19">
		<div id="content">
			<?php //echo $content; ?>
		</div>--><!-- content -->
	<!--</div>

	<?php //if(Yii::app()->user->checkAccess('admin')) { ?>

	<div class="span-5 last">
		<div id="sidebar">
		<?php
			/*$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>ucfirst(CrugeTranslator::t("administracion de usuarios")),
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>Yii::app()->user->ui->adminItems,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();*/
		?>
		</div>--><!-- sidebar -->
	<!--</div>
	
	<?php //} ?>
	
</div>-->
<?php //$this->endContent(); ?>




<div class="row">

	<div style="top: 60px; position: fixed; width: 1170px; z-index:1000;">
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
	<?php if(Yii::app()->user->checkAccess('admin')) { ?>
    <div class="span2">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>ucfirst(CrugeTranslator::t("administracion de usuarios")),
			));
			//$this->widget('zii.widgets.CMenu', array(
			$this->widget('bootstrap.widgets.TbMenu', array(
				'items'=>Yii::app()->user->ui->adminItems,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
        ?>

        </div><!-- sidebar -->
    </div>

	<div class="span10">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <?php } ?>
</div>
<?php $this->endContent(); ?>

<style type="text/css">
.data {
  margin: 40px auto;
  border: 1px solid #cdd3d7;
  border-radius: 8px;
  padding-left: 2em;
  padding-right: 2em;
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
</style>