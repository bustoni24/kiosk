<?php

/**
 * This is the model class for table "level".
 *
 * The followings are the available columns in table 'level':
 * @property integer $id
 * @property string $nama
 */
class Level extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'level';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama', 'required'),
			array('nama', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nama', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'nama' => 'Nama',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nama',$this->nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			// 'pagination'=>array(
			// 	'pageSize'=>30,
			// ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Level the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getOptions($data = []) {
		$id = (isset($data['id']) ? $data['id'] : null);
		$level_akses = (isset($data['level_akses']) ? $data['level_akses'] : null);

        if ($id != null){
			$addCond = "";
			if (isset($level_akses) && $level_akses != 1) {
				$addCond = "AND id <> 1";
			}

			$criteria = new CDbCriteria;
			$criteria->condition = '1 = 1 '.$addCond;
			$criteria->order = 'nama';
			$level = $this->findAll($criteria);
			return CHtml::listData($level, 'id', 'nama');
		}else{
			$addCond = "";
			if (isset($level_akses) && $level_akses != 1) {
				$addCond = "AND id <> 1";
			}
			 return CHtml::listData($this->findAll(array('condition' => '1=1 '.$addCond,'order'=>'nama')), 'id', 'nama');
		}
    }
}
