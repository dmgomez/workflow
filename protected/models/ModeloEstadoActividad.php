<?php

/**
 * This is the model class for table "modelo_estado_actividad".
 *
 * The followings are the available columns in table 'modelo_estado_actividad':
 * @property integer $id_modelo_estado_actividad
 * @property integer $id_actividad_origen
 * @property integer $id_actividad_destino
 * @property integer $id_estado_actividad
 * @property boolean $espera_destino
 *
 * The followings are the available model relations:
 * @property Actividad $idActividadDestino
 * @property Actividad $idActividadOrigen
 * @property EstadoActividad $idEstadoActividad
 */
class ModeloEstadoActividad extends CActiveRecord
{
	public $_transiciones;
	public $_recaudos;
	public $_datos;
	public $_idRecaudos;
	public $_idDatos;
    public $nombreGenericoActividad;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modelo_estado_actividad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_actividad_origen, id_actividad_destino, id_estado_actividad_inicial, id_estado_actividad_salida, espera_destino', 'required'),
			array('id_actividad_origen, id_actividad_destino, id_estado_actividad_inicial, id_estado_actividad_salida', 'numerical', 'integerOnly'=>true),
			array('_idRecaudos, _idDatos', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_modelo_estado_actividad, id_actividad_origen, id_actividad_destino, id_estado_actividad_inicial, id_estado_actividad_salida, espera_destino', 'safe', 'on'=>'search'),
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
			'idActividadDestino' => array(self::BELONGS_TO, 'Actividad', 'id_actividad_destino'),
			'idActividadOrigen' => array(self::BELONGS_TO, 'Actividad', 'id_actividad_origen'),
			'idEstadoActividadInicial' => array(self::BELONGS_TO, 'EstadoActividad', 'id_estado_actividad_inicial'),
			'idEstadoActividadSalida' => array(self::BELONGS_TO, 'EstadoActividad', 'id_estado_actividad_salida'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_modelo_estado_actividad' => 'Id Modelo Estado Actividad',
			'id_actividad_origen' => 'Actividad Origen',
			'id_estado_actividad_inicial' => 'Estado Inicial Actividad Destino',
			'id_actividad_destino' => 'Actividad Destino',
			'id_estado_actividad_salida' => 'Estado de Transición',
			'espera_destino' => 'Espera Destino',
            'nombreGenericoActividad' => 'Actividad',
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

		$criteria->compare('id_modelo_estado_actividad',$this->id_modelo_estado_actividad);
		$criteria->compare('id_actividad_origen',$this->id_actividad_origen);
		$criteria->compare('id_actividad_destino',$this->id_actividad_destino);
		$criteria->compare('id_estado_actividad_salida',$this->id_estado_actividad_salida);
		$criteria->compare('espera_destino',$this->espera_destino);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModeloEstadoActividad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
