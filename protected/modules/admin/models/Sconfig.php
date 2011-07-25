<?php

/**
 * This is the model class for table "sconfig".
 *
 * The followings are the available columns in table 'sconfig':
 * @property string $sitename
 * @property string $description
 * @property string $keyword
 */
class Sconfig extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sconfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sconfig';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		  array('is_oops,oops_tips,record_no', 'default'),
		  array('sitename, description, keyword', 'required'),
			array('sitename, description, keyword', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sitename, description, keyword', 'safe', 'on'=>'search'),
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
			'sitename'    => Yii::t('cp','Sitename'),
			'description' => Yii::t('cp','Description'),
			'keyword'     => Yii::t('cp','Keyword'),
  		'record_no'   => Yii::t('cp','Record No'),
    	'is_oops'     => Yii::t('cp','Is Oops'),
    	'oops_tips'   => Yii::t('cp','Oops Tips'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sitename',$this->sitename,true);

		$criteria->compare('description',$this->description,true);

		$criteria->compare('keyword',$this->keyword,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}