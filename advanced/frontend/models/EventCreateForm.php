<?php
namespace frontend\models;

class EventCreateForm extends Model {

    public $name;
    public $timestamp;
    public $price;
    public $capacity;
    public $addressId;
    public $description;

    public function rules(){
        return [
            [['name', 'timestamp', 'price', 'capacity', 'addressId', 'description'], 'required'],
            [['capacity', 'addressId'], 'integer'],
            ['price', 'double'],
            [['name', 'description'], 'string', 'max' => 255],
            [['addressId'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['addressId' => 'addressId']],
        ];
    }
}