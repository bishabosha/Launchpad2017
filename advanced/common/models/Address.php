<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property integer $addressId
 * @property string $name
 * @property string $street1
 * @property string $street2
 * @property string $city
 * @property string $postcode
 * @property integer $userId
 * @property string $latlng
 *
 * @property string[] $shortFormat
 * @property Event[] $events
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'street1', 'city', 'postcode'], 'required'],
            [['name', 'street1', 'street2', 'city', 'postcode'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'addressId' => 'Address ID',
            'name' => 'Name',
            'street1' => 'Street1',
            'street2' => 'Street2',
            'city' => 'City',
            'postcode' => 'Postcode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['addressId' => 'addressId']);
    }

    public function getShortFormat() {
        return $this->name . ", " . $this->street1;
    }

    public function getFullFormat(){
        return $this->name. " ". $this->street1. ", ". $this->city.", ". $this->postcode;
    }
}
