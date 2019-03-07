<?php

/**
 * This is the model class for table "vis_reporte".
 *
 * The followings are the available columns in table 'vis_reporte':
 * @property string $codigo_proceso
 * @property string $nombre_proceso
 * @property string $nombre_actividad
 * @property string $codigo_actividad
 * @property integer $dias
 * @property integer $horas
 * @property string $_codigo_1
 * @property string $_codigo_2
 * @property string $_codigo_3
 * @property integer $id_instancia_proceso
 * @property string $fecha_ini_actividad
 * @property string $hora_ini_actividad
 * @property string $fecha_fin_actividad
 * @property string $hora_fin_actividad
 * @property integer $ejecutada
 * @property string $f_inicio
 * @property string $f_fin
 * @property integer $id_proceso
 * @property string $fecha_ini_proceso
 * @property string $fecha_fin_proceso
 * @property integer $ejecutado
 * @property string $nombre
 * @property string $cedula_persona
 */
class VisReporte extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vis_reporte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dias, horas, id_instancia_proceso, ejecutada, id_proceso, ejecutado', 'numerical', 'integerOnly'=>true),
			array('codigo_proceso', 'length', 'max'=>15),
			array('nombre_proceso', 'length', 'max'=>300),
			array('nombre_actividad', 'length', 'max'=>200),
			array('codigo_actividad', 'length', 'max'=>20),
			array('_codigo_1, _codigo_2, _codigo_3, fecha_ini_actividad, hora_ini_actividad, fecha_fin_actividad, hora_fin_actividad, f_inicio, f_fin, fecha_ini_proceso, fecha_fin_proceso, nombre, cedula_persona', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codigo_proceso, nombre_proceso, nombre_actividad, codigo_actividad, dias, horas, _codigo_1, _codigo_2, _codigo_3, id_instancia_proceso, fecha_ini_actividad, hora_ini_actividad, fecha_fin_actividad, hora_fin_actividad, ejecutada, f_inicio, f_fin, id_proceso, fecha_ini_proceso, fecha_fin_proceso, ejecutado, nombre, cedula_persona', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo_proceso' => 'Codigo Proceso',
			'nombre_proceso' => 'Nombre Proceso',
			'nombre_actividad' => 'Nombre Actividad',
			'codigo_actividad' => 'Codigo Actividad',
			'dias' => 'Dias',
			'horas' => 'Horas',
			'_codigo_1' => 'Codigo 1',
			'_codigo_2' => 'Codigo 2',
			'_codigo_3' => 'Codigo 3',
			'id_instancia_proceso' => 'Id Instancia Proceso',
			'fecha_ini_actividad' => 'Fecha Ini Actividad',
			'hora_ini_actividad' => 'Hora Ini Actividad',
			'fecha_fin_actividad' => 'Fecha Fin Actividad',
			'hora_fin_actividad' => 'Hora Fin Actividad',
			'ejecutada' => 'Ejecutada',
			'f_inicio' => 'F Inicio',
			'f_fin' => 'F Fin',
			'id_proceso' => 'Id Proceso',
			'fecha_ini_proceso' => 'Fecha Ini Proceso',
			'fecha_fin_proceso' => 'Fecha Fin Proceso',
			'ejecutado' => 'Ejecutado',
			'nombre' => 'Nombre',
			'cedula_persona' => 'Cedula Persona',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codigo_proceso',$this->codigo_proceso,true);
		$criteria->compare('nombre_proceso',$this->nombre_proceso,true);
		$criteria->compare('nombre_actividad',$this->nombre_actividad,true);
		$criteria->compare('codigo_actividad',$this->codigo_actividad,true);
		$criteria->compare('dias',$this->dias);
		$criteria->compare('horas',$this->horas);
		$criteria->compare('_codigo_1',$this->_codigo_1,true);
		$criteria->compare('_codigo_2',$this->_codigo_2,true);
		$criteria->compare('_codigo_3',$this->_codigo_3,true);
		$criteria->compare('id_instancia_proceso',$this->id_instancia_proceso);
		$criteria->compare('fecha_ini_actividad',$this->fecha_ini_actividad,true);
		$criteria->compare('hora_ini_actividad',$this->hora_ini_actividad,true);
		$criteria->compare('fecha_fin_actividad',$this->fecha_fin_actividad,true);
		$criteria->compare('hora_fin_actividad',$this->hora_fin_actividad,true);
		$criteria->compare('ejecutada',$this->ejecutada);
		$criteria->compare('f_inicio',$this->f_inicio,true);
		$criteria->compare('f_fin',$this->f_fin,true);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('fecha_ini_proceso',$this->fecha_ini_proceso,true);
		$criteria->compare('fecha_fin_proceso',$this->fecha_fin_proceso,true);
		$criteria->compare('ejecutado',$this->ejecutado);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('cedula_persona',$this->cedula_persona,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisReporte the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
