<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $eventId
 * @property string $name
 * @property string $timestamp
 * @property integer $price
 * @property integer $capacity
 * @property string $attending
 * @property integer $hostId
 * @property integer $addressId
 * @property string $description
 *
 * @property Address $address
 * @property User $host
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'timestamp', 'price', 'capacity', 'attending', 'hostId', 'addressId', 'description'], 'required'],
            [['timestamp'], 'safe'],
            [['price', 'capacity', 'hostId', 'addressId'], 'integer'],
            [['name', 'attending', 'description'], 'string', 'max' => 255],
            [['addressId'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['addressId' => 'addressId']],
            [['hostId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['hostId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'eventId' => 'Event ID',
            'name' => 'Name',
            'timestamp' => 'Timestamp',
            'price' => 'Price',
            'capacity' => 'Capacity',
            'attending' => 'Attending',
            'hostId' => 'Host ID',
            'addressId' => 'Address ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['addressId' => 'addressId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHost()
    {
        return $this->hasOne(User::className(), ['id' => 'hostId']);
    }
}
