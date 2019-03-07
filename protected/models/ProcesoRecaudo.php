<?php

/**
 * This is the model class for table "proceso_recaudo".
 *
 * The followings are the available columns in table 'proceso_recaudo':
 * @property integer $id_proceso_recaudo
 * @property integer $id_proceso
 * @property integer $id_recaudo
 * @property integer $obligatorio
 *
 * The followings are the available model relations:
 * @property Proceso $idProceso
 * @property Recaudo $idRecaudo
 */
class ProcesoRecaudo extends CActiveRecord
{
	private $_nombreRecaudo;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'proceso_recaudo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_proceso, id_recaudo, nombreRecaudo', 'required'),
			array('id_proceso, id_recaudo', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_proceso_recaudo, id_proceso, id_recaudo, nombreRecaudo', 'safe', 'on'=>'search'),
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
			'idProceso' => array(self::BELONGS_TO, 'Proceso', 'id_proceso'),
			'idRecaudo' => array(self::BELONGS_TO, 'Recaudo', 'id_recaudo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_proceso_recaudo' => 'Id Proceso Recaudo',
			'id_proceso' => 'Id Proceso',
			'id_recaudo' => 'Id Recaudo',
			'nombreRecaudo' => 'Nombre Recaudo',
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
	public function search($idProceso)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array("idRecaudo"=>array('alias' => 'recaudo'));

		$criteria->compare('id_proceso_recaudo',$this->id_proceso_recaudo);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('id_recaudo',$this->id_recaudo);
		$criteria->addSearchCondition('LOWER(recaudo.nombre_recaudo)',strtolower($this->nombreRecaudo),true);

		$sort = new CSort();
		$sort->attributes = array(

		    'nombreRecaudo'=>array(
		        'asc'=>'recaudo.nombre_recaudo',
		        'desc'=>'recaudo.nombre_recaudo desc',
		    ),
		);

		$sort->defaultOrder = 'recaudo.nombre_recaudo ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	public function getnombreRecaudo(){

	    if ($this->_nombreRecaudo === null && $this->idRecaudo !== null){

	        $this->_nombreRecaudo = $this->idRecaudo->nombre_recaudo;
	    }

	    return $this->_nombreRecaudo;
	}

	public function setnombreRecaudo($value){

		$this->_nombreRecaudo = $value;
	}

	public function get_visibilidad_update()
	{
		$visible = false;

		$proceso_con_recaudo = ProcesoRecaudo::model()->find(array("condition" => "id_proceso <> ".$this->id_proceso." and id_recaudo =".$this->id_recaudo));


		if(!$proceso_con_recaudo)
		{
			$visible = true;
		}
		
		return $visible;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProcesoRecaudo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}