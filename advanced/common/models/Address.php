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
 *
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
}
